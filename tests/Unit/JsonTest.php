<?php

namespace Scrapertests\Unit;

class JsonTest extends \ScraperTests\Lib\BaseTestCase
{

    public function test_getConverted()
    {
        $toConvert = [
            ['col1' => 'a,b', 'col2' => 'row1'],
            ['col1' => 'c'  , 'col2' => 'row2'],
        ];
        $filter    = new \Scraper\Format\Json();
        $this->assertEquals('[{"col1":"a,b","col2":"row1"},{"col1":"c","col2":"row2"}]', $filter->getConverted($toConvert));
    }

}