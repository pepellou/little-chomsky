<?php

declare(strict_types=1);

namespace Chomsky;

use Symfony\Component\Yaml\Yaml;


final class Chomsky {

    private static $rules = [ ];

    public static function learn($knowledge_file) : void
    {
        self::$rules = Yaml::parseFile('Knowledge/' . $knowledge_file);
    }

    public static function talk($text) : string
    {
        foreach (self::$rules as $category => $rules) {
            foreach ($rules as $rule) {
                if (self::ruleApplies($text, $rule)) {
                    return self::applyRule($text, $rule);
                }
            }
        }
        return 'Non entendo o que queres dicir (' . $text . ')';
    }

    private static function ruleApplies($text, $rule) : bool
    {
        return $text == $rule['input'];
    }

    private static function applyRule($text, $rule) : string
    {
        if (isset($rule['answer_same_as'])) {
            return self::talk($rule['answer_same_as']);
        }
        if (isset($rule['answer'])) {
            if (is_string($rule['answer'])) {
                return $rule['answer'];
            }
            if (is_array($rule['answer'])) {
                return $rule['answer'][rand(0, count($rule['answer']) - 1)];
            }
        }
        return "Non entendo o que queres dicir (${text})";
    }

}
