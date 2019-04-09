<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Chomsky\Chomsky;

final class EmailTest extends TestCase
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

    public function stuffThatChomskyShouldNotUnderstand()
    {
        return $this->listToDataSets([
            'Something',
            'asdfg',
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
