<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Chomsky\Chomsky;
use Chomsky\Expression;

final class ExpressionTalkTest extends TestCase
{

    /**
     * @dataProvider listsOfValues
     */
    public function testCanEvaluateAListOfValues($listName, $values, $expectedOutput): void
    {
        Chomsky::remember($listName, $values);

        $this->assertEquals(
            $expectedOutput,
            Chomsky::evaluate(new Expression($listName))
        );
    }

    /**
     * @dataProvider objects
     */
    public function testCanEvaluateObjects($objectName, $object, $expectedOutput): void
    {
        Chomsky::remember($objectName, $object);

        $this->assertEquals(
            $expectedOutput,
            Chomsky::evaluate(new Expression($objectName))
        );
    }

    /**
     * @dataProvider listsOfObjects
     */
    public function testCanEvaluateAListOfObjects($listName, $objects, $expectedOutput): void
    {
        Chomsky::remember($listName, $objects);

        $this->assertEquals(
            $expectedOutput,
            Chomsky::evaluate(new Expression($listName))
        );
    }

    public function testCanEvaluateAListOfObjectsFilteredByField(): void
    {
        $anObject = new stdclass();
        $anObject->name = 'a name';
        $anObject->value = 42;

        $anotherObject = new stdclass();
        $anotherObject->name = 'another name';
        $anotherObject->value = 2;

        $yetAnotherObject = new stdclass();
        $yetAnotherObject->name = 'yet another name';
        $yetAnotherObject->value = 4;

        Chomsky::remember('aName', [ $anObject, $anotherObject, $yetAnotherObject ]);

        $this->assertEquals(
            '{name:a name,value:42}',
            Chomsky::evaluate(new Expression('aName[name=a name]'))
        );

        $this->assertEquals(
            '{name:another name,value:2}',
            Chomsky::evaluate(new Expression('aName[name=another name]'))
        );
    }

    public function listsOfValues()
    {
        return [
            [ 'aList', [ 'One' ], 'One' ],
            [ 'aList', [ 'One', 'Two' ], 'One e Two' ],
            [ 'aList', [ 'One', 'Two', 'Three' ], 'One, Two e Three' ],
        ];
    }

    public function objects()
    {
        $anObject = new stdclass();
        $anObject->name = 'a name';
        $anObject->value = 42;

        $anotherObject = new stdclass();
        $anotherObject->name = 'another name';
        $anotherObject->value = 2;

        $yetAnotherObject = new stdclass();
        $yetAnotherObject->name = 'yet another name';
        $yetAnotherObject->value = 4;
        return [
            [
                'anObject',
                $anObject,
                '{name:a name,value:42}'
            ],
            [
                'anObject',
                $anotherObject,
                '{name:another name,value:2}'
            ],
            [
                'anObject',
                $yetAnotherObject,
                '{name:yet another name,value:4}'
            ],
        ];
    }

    public function listsOfObjects()
    {
        $anObject = new stdclass();
        $anObject->name = 'a name';
        $anObject->value = 42;

        $anotherObject = new stdclass();
        $anotherObject->name = 'another name';
        $anotherObject->value = 2;

        $yetAnotherObject = new stdclass();
        $yetAnotherObject->name = 'yet another name';
        $yetAnotherObject->value = 4;
        return [
            [
                'aListName',
                [ $anObject ],
                '{name:a name,value:42}'
            ],
            [
                'aListName',
                [ $anObject, $anotherObject ],
                '{name:a name,value:42} e {name:another name,value:2}'
            ],
            [
                'aListName',
                [ $anObject, $anotherObject, $yetAnotherObject ],
                '{name:a name,value:42}, {name:another name,value:2} e {name:yet another name,value:4}'
            ],
        ];
    }

}
