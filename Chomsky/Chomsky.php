<?php

declare(strict_types=1);

namespace Chomsky;

use Symfony\Component\Yaml\Yaml;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


final class Chomsky {

    private static $rules = [ ];
    private static $_input = "";
    private static $_captures = [ ];
    private static $_alreadyLearnt = false;
    private static $_logger = null;
    private static $_database = [];

    public static function learnFromKnowledgeFolder() : void
    {
        if (self::$_alreadyLearnt) {
            return;
        }

        foreach (Yaml::parseFile('Knowledge/list.yaml')['files'] as $knowledge_file) {
            self::learn($knowledge_file);
        }

        self::$_alreadyLearnt = true;
    }

    public static function learn($knowledge_file) : void
    {
        self::getLogger()->warning('Learning rules from ' . $knowledge_file);
        array_push(self::$rules, ...Yaml::parseFile('Knowledge/' . $knowledge_file . '.yaml')['rules']);
    }

    public static function talk($text) : string
    {
        $clean_text = self::cleanInput($text);

        foreach (self::$rules as $rule) {
            if (self::ruleApplies($clean_text, $rule)) {
                return self::applyRule($clean_text, $rule);
            }
        }
        return 'Non entendo o que queres dicir (' . $text . ')';
    }

    private static function ruleApplies($text, $rule) : bool
    {
        self::$_input = $text;

        if ($rule['input'] == '/q') {
            return $text == '/q';
        }

        $input = self::cleanAccents($rule['input']);

        $variables = [];
        preg_match_all("/{([^}]+)}/", $input, $variables);

        self::$_captures = [];
        $tempCaptures = [];

        foreach($variables[1] as $variable) {
            $input = str_replace('{' . $variable . '}', "(?<${variable}>.+)", $input);
        }

        if (preg_match("/^${input}$/i", $text, $tempCaptures) == false) {
            return false;
        }

        foreach($variables[1] as $variable) {
            self::$_captures[$variable] = $tempCaptures[$variable];
        }

        return true;
    }

    private static function applyRule($text, $rule) : string
    {
        $answer = "Non entendo o que queres dicir (${text})";
        if (isset($rule['answer_same_as'])) {
            $answer = self::talk(self::expandVariables($rule['answer_same_as']));
        } elseif (isset($rule['answer'])) {
            if (is_string($rule['answer'])) {
                $answer = $rule['answer'];
            } elseif (is_array($rule['answer'])) {
                $answer = $rule['answer'][rand(0, count($rule['answer']) - 1)];
            }
        }

        return self::expandVariables($answer, $rule['where']);
    }

    private static function expandVariables($text, $where = null)
    {
        $variables = [];
        preg_match_all("/{([^}]+)}/", $text, $variables);

        foreach ($variables[1] as $variable) {
            if (isset(self::$_captures[$variable])) {
                $text = str_replace('{' . $variable . '}', self::$_captures[$variable], $text);
            } elseif (!is_null($where) && isset($where[$variable])) {

            }
        }
        return $text;
    }

    public static function remember($key, $value) : void
    {
        self::$_database[$key] = $value;
    }

    public static function evaluate($expression) : string
    {
        return $expression->evaluate();
    }

    public static function remind($key)
    {
        return self::$_database[$key];
    }

    public static function cleanInput($text) : string
    {
        if (self::isCommand($text)) {
            return $text;
        }
        $words = preg_split("/\s+/", $text);
        $text = implode(" ", $words);
        $text = preg_replace("/[^a-zA-Z0-9\s_ñÑáéíóúÁÉÍÓÚ]/", "", $text);

        return self::cleanAccents($text);
    }

    public static function cleanAccents($text) : string
    {
        $accents_replacements = [
            '/á/' => 'a',
            '/é/' => 'e',
            '/í/' => 'i',
            '/ó/' => 'o',
            '/ú/' => 'u',
            '/Á/' => 'A',
            '/É/' => 'E',
            '/Í/' => 'I',
            '/Ó/' => 'O',
            '/Ú/' => 'U',
        ];

        foreach ($accents_replacements as $from => $to) {
            $text = preg_replace($from, $to, $text);
        }

        return $text;
    }

    private static function isCommand($text) : bool
    {
        return $text[0] == '/';
    }

    private static function getLogger() : Logger
    {
        if (is_null(self::$_logger)) {
            self::$_logger = new Logger('chomsky');
            self::$_logger->pushHandler(new StreamHandler('logs/chomsky.log', Logger::WARNING));
        }
        return self::$_logger;
    }

}
