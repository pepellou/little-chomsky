<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Chomsky\Chomsky;

final class SmallTalkTest extends TestCase
{
    /**
     * @dataProvider randomNames
     */
    public function testWithVariable($randomName): void
    {
        $this->assertEquals(
            "Por suposto que son mais listo que ${randomName}!",
            Chomsky::talk("Es mais listo que ${randomName}?")
        );
    }

    /**
     * @dataProvider randomCouples
     */
    public function testWithMultipleVariables($randomValue1, $randomValue2): void
    {
        $answer = Chomsky::talk("Prefires ${randomValue1} ou ${randomValue2}?");

        $this->assertTrue(
            $answer == "Prefiro ${randomValue1}" ||
            $answer == "Prefiro ${randomValue2}",
            "Answer expected to be 'Prefiro ${randomValue1}' or 'Prefiro ${randomValue2}' but was '${answer}'"
        );
    }

    /**
     * @dataProvider randomCouples
     */
    public function testWithMultipleVariablesAndRedirection($randomValue1, $randomValue2): void
    {
        $answer = Chomsky::talk("Queres ${randomValue1} ou ${randomValue2}?");

        $this->assertTrue(
            $answer == "Prefiro ${randomValue1}" ||
            $answer == "Prefiro ${randomValue2}",
            "Answer expected to be 'Prefiro ${randomValue1}' or 'Prefiro ${randomValue2}' but was '${answer}'"
        );
    }

    /*
     * @setupBeforeClass
     */
    public static function setupBeforeClass() : void
    {
        Chomsky::learnFromKnowledgeFolder();
    }

    public function randomNames()
    {
        return $this->listToDataSets([
            'Chomsky',
            'HAL9000',
            'HAL 9000',
        ]);
    }

    public function randomCouples()
    {
        return [
            [ 'Chomsky', 'Asimov' ],
            [ 'HAL9000', 'Marvin' ],
            [ 'coding', 'playing chess' ],
            [ 'coffee', 'tea' ],
        ];
    }

    private function listToDataSets($list) {
        $data = [];
        foreach($list as $text) {
            $data [$text] = [ $text ];
        }
        return $data;
    }
}
