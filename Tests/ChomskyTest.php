<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Chomsky\Chomsky;

final class ChomskyTalkTest extends TestCase
{

    /**
     * @dataProvider cleanInputs
     */
    public function testCleanInput($input, $cleaned): void
    {
        $this->assertEquals(
            $cleaned,
            Chomsky::cleanInput($input)
        );
    }

    /*
     * @setupBeforeClass
     */
    public static function setupBeforeClass() : void
    {
        Chomsky::learnFromKnowledgeFolder();
    }

    public function cleanInputs()
    {
        return [
            [ "This is a TEXT with Upper and Lower cases",
              "This is a TEXT with Upper and Lower cases" ],
            [ "This   is a   text   with random multiple   spaces",
              "This is a text with random multiple spaces" ],
            [ "This is a text with some special characters in it, such as commas or question marks, huh!?",
              "This is a text with some special characters in it such as commas or question marks huh" ],
        ];
    }

}
