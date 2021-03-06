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
        self::$_captures = [];

        if ($rule['input'] == '/q') {
            return $text == '/q';
        }

        $input = [];
        $matchesRule = preg_match("/^" . str_replace("_", "(.+)", $rule['input']) . "$/i", $text, self::$_captures) != false;

        return $matchesRule;
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
        $num_captures = count(self::$_captures);
        if ($num_captures > 1) {
            if ($num_captures == 2) {
                $text = str_replace("<_>", self::$_captures[1], $text);
            } else {
                $text = str_replace("<_>", self::$_captures[1], $text);
                for ($i = 1; $i < $num_captures; $i++) {
                    $text = str_replace("<_/${i}>", self::$_captures[$i], $text);
                }
            }
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
