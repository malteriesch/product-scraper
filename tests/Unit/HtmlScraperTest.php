<?php

namespace Scrapertests\Unit;

use Goutte\Client;
use Scraper\Http\HtmlScraper;


class HtmlScraperTest extends \ScraperTests\Lib\BaseTestCase
{

    protected function createMockResponse($file)
    {
        $mockResponse = $this->getMock('Psr\Http\Message\ResponseInterface');
        $mockResponse->method('getBody')->willReturn(file_get_contents(TEST_ASSETS . $file));
        $mockResponse->method('getStatusCode')->willReturn(304);
        $mockResponse->method('getHeaders')->willReturn([]);
        return $mockResponse;
    }
    
    public function test_SmokeTest()
    {
        $mockGuzzleClient   = \Mockery::mock('GuzzleHttp\Client');
        
        $mockGuzzleClient->shouldReceive('request')->with('GET', 'http://foo.com', \Mockery::any())->andReturn($this->createMockResponse('example.html'));
        $mockGuzzleClient->shouldReceive('request')->with('GET', 'http://www.sainsburys.co.uk/shop/gb/groceries/new-in-season/sainsburys-asparagus-spears-250g', \Mockery::any())->andReturn($this->createMockResponse('link1.html'));
        $mockGuzzleClient->shouldReceive('request')->with('GET', 'http://www.sainsburys.co.uk/shop/gb/groceries/new-in-season/sainsburys-asparagus-tips-100g', \Mockery::any())->andReturn($this->createMockResponse('link2.html'));
        $mockGuzzleClient->shouldReceive('request')->with('GET', 'http://www.sainsburys.co.uk/shop/gb/groceries/new-in-season/sainsburys-asparagus-fine-100g', \Mockery::any())->andReturn($this->createMockResponse('link3.html'));
        
        $client = new Client();
        $client->setClient($mockGuzzleClient);
        
        $scraper = new HtmlScraper(
            [
                'list-selector'        => 'div.product',
                'title-selector'       => 'h3 > a',
                'description-selector' => 'div.productText',
                'unit-price-selector'  => 'p.pricePerUnit'
            ],
            $client
        );
        
        $list = $scraper->scrapeHtml('http://foo.com',$mockGuzzleClient);
        $expected = [
            'results' => [
                [
                    'title' => 'Sainsbury\'s Asparagus Spears 250g',
                    'size' => '38.08kb',
                    'unit_price' => '2.00',
                    'description' => 'Asparagus Spears   Tender & succulent',
                ],
                [
                    'title' => 'Sainsbury\'s Asparagus Tips 100g',
                    'size' => '39.97kb',
                    'unit_price' => '1.75',
                    'description' => 'Asparagus   ideal for stir fries or salads',
                ],
                [
                    'title' => 'Sainsbury\'s Asparagus, Fine 100g',
                    'size' => '37.23kb',
                    'unit_price' => '1.75',
                    'description' => 'Asparagus   selected for tenderness',
                ],
            ],
            'total' => '5.50'
        ];
   
        $this->assertEquals($expected, $list);
    }

}
