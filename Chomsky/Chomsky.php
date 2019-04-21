<?php

declare(strict_types=1);

namespace Chomsky;

use Symfony\Component\Yaml\Yaml;


final class Chomsky {

    private static $rules = [ ];
    private static $_input = "";
    private static $_captures = [ ];
    private static $_alreadyLearnt = false;

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

        $input = $rule['input'];

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

        return self::expandVariables($answer);
    }

    private static function expandVariables($text)
    {
        foreach (self::$_captures as $variable => $value) {
            $text = str_replace('{' . $variable . '}', $value, $text);
        }
        return $text;
    }

    public static function cleanInput($text) : string
    {
        if (self::isCommand($text)) {
            return $text;
        }
        $words = preg_split("/\s+/", $text);
        $text = implode(" ", $words);
        $text = preg_replace("/[^a-zA-Z0-9\s_ñÑáéíóúÁÉÍÓÚ]/", "", $text);

        return $text;
    }

    private static function isCommand($text) : bool
    {
        return $text[0] == '/';
    }

}
