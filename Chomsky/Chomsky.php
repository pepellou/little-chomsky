<?php

declare(strict_types=1);

namespace Chomsky;


final class Chomsky {

    public static function learn($knowledge_file) : void
    {
        // TODO do
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
        if (isset($rule['redirect'])) {
            return self::talk($rule['redirect']);
        }
        if (isset($rule['answer'])) {
            if (is_string($rule['answer'])) {
                return $rule['answer'];
            }
            if (is_array($rule['answer'])) {
                return $rule['answer'][rand(0, count($rule['answer']))];
            }
        }
        return "Non entendo o que queres dicir (${text})";
    }

    private static $rules = [
        'basic_conversation' => [
            [
                'input'  => 'Ola',
                'answer' => [
                    'Ola!',
                    'Ola!!',
                    'Ola, que tal? :-)',
                    'Que tal?',
                ]
            ],
            [
                'input'    => 'Que tal?',
                'redirect' => 'Ola'
            ],
            [
                'input'    => 'Boas',
                'redirect' => 'Ola'
            ],
            [
                'input'    => 'Bo dia',
                'redirect' => 'Ola'
            ],
        ]
    ];

}
