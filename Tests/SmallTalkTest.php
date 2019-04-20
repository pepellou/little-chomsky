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

    private function listToDataSets($list) {
        $data = [];
        foreach($list as $text) {
            $data [$text] = [ $text ];
        }
        return $data;
    }
}
