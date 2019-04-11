<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Chomsky\Chomsky;

final class BasicConversationTest extends TestCase
{
    /**
     * @dataProvider stuffThatChomskyShouldNotUnderstand
     */
    public function testShouldNotUnderstandSomeStuff($stuff): void
    {
        $this->assertEquals(
            "Non entendo o que queres dicir (${stuff})",
            Chomsky::talk($stuff)
        );
    }

    /**
     * @dataProvider greetings
     */
    public function testShouldUnderstandGreetings($greeting): void
    {
        $this->assertNotEquals(
            "Non entendo o que queres dicir (${greeting})",
            Chomsky::talk($greeting)
        );
    }

    /*
     * @setupBeforeClass
     */
    public static function setupBeforeClass() : void
    {
        Chomsky::learn('basic_conversation.yml');
    }

    public function stuffThatChomskyShouldNotUnderstand()
    {
        return $this->listToDataSets([
            'Something',
            'asdfg',
        ]);
    }

    public function greetings()
    {
        return $this->listToDataSets([
            'Ola',
            'Que tal?',
            'Boas',
            'Bo dia',
        ]);
    }

    private function listToDataSets($list) {
        $data = [];
        foreach($list as $text) {
            $data [$text] = [ $text ];
        }
        return $data;
    }
}
