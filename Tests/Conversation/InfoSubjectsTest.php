<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Chomsky\Chomsky;

final class InfoSubjectsTest extends TestCase
{
    /**
     * @dataProvider subject_teachers
     */
    public function testShouldGiveTeachersOfSubject($subject, $teachers): void
    {
        $this->markTestSkipped('must be revisited.');

        $this->assertEquals($teachers, Chomsky::talk("Quen imparte ${subject}?"));
    }

    /*
     * @setupBeforeClass
     */
    public static function setupBeforeClass() : void
    {
        Chomsky::learnFromKnowledgeFolder();
    }

    public function subject_teachers()
    {
        return [
            [ 'Lingua Alemá 6', 'Sina Kristin Menrad e Sebastian Windisch' ],
            [ 'Lingua Alemá 7', 'Sina Kristin Menrad e Sebastian Windisch' ],
            [ 'Literatura Alemá desde os seus inicios ata o Barroco', 'Victor Millet Schröder' ],
            [ 'Lingua Alemá 8', 'Emilio González Miranda e Sina Kristin Menrad' ],
            [ 'Semántica e Lexicoloxía Alemás', 'Carmen Mellado Blanco' ],
            [ 'Tradución directa e inversa 1', 'Rosa María Gómez Pato e Sina Kristin Menrad' ],
            [ 'Literatura en lingua alemá desde a postguerra ata os anos 80', 'María Dolores Sabate Planes' ],
            [ 'Literatura en lingua alemá desde 1989', 'Rosa María Gómez Pato' ],
            [ 'Lingüística contrastiva alemá', 'Barbara Lubke' ],
            [ 'Variedades do alemán', 'Barbara Lubke e Sebastian Windisch' ],
            [ 'Panorámica das ideas lingüísticas', 'Francisco José Servando García Gondar' ],
            [ 'Tipoloxía lingüística', 'María Teresa Moure Pereiro' ],
            [ 'Psicolingüística', 'Milagros Fernández Pérez e Lara Lorenzo Herrera' ],
            [ 'Lingüística computacional', 'Ana Isabel Codesido Garcia' ],
        ];
    }

}
