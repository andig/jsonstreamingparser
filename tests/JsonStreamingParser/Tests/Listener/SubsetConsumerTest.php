<?php

namespace JsonStreamingParser\Tests\Listener;

use JsonStreamingParser\Parser;

class SubsetConsumerTest extends \PHPUnit_Framework_TestCase
{
    public function testProposesAJsonSubsetToConsume()
    {
        $listener = new DatesRangeConsumer;
        $parser = new Parser(fopen(__DIR__ . '/data/dateRanges.json', 'r'), $listener);
        $parser->parse();

        $this->assertSame(
            array(
                array(
                    'startDate' => '2013-10-24',
                    'endDate'   => '2013-10-25',
                ),
                array(
                    'startDate' => '2013-10-26',
                    'endDate'   => '2013-10-27',
                ),
                array(
                    'startDate' => '2013-11-01',
                    'endDate'   => '2013-11-10',
                ),
            ),
            $listener->dateRanges
        );
    }

    public function testConsumesFirstLevelCorrectly()
    {
        $listener = new IdealConsumer;
        $parser = new Parser(fopen(__DIR__ . '/data/plain.json', 'r'), $listener);
        $parser->parse();

        $this->assertEquals(
            array('key 1' => 'value 1', 'key 2' => 'value 2', 'key 3' => 'value 3'),
            $listener->data
        );
    }

    /**
     * @dataProvider differentJsonFiles
     */
    public function testCollectsStructureCorrectly($fileToProcess)
    {
        $listener = new IdealConsumer;
        $parser = new Parser(fopen($fileToProcess, 'r'), $listener);
        $parser->parse();

        $this->assertEquals(
            json_decode(file_get_contents($fileToProcess), true),
            $listener->data
        );

    }

    public static function differentJsonFiles()
    {
        return array(
            array(__DIR__ . '/../example/example.json'),
            array(__DIR__ . '/data/plain.json'),
            array(__DIR__ . '/data/dateRanges.json'),
            array(__DIR__ . '/data/escapedChars.json'),
        );
    }
}
