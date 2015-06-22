<?php

namespace Scraper\Http;
use Goutte\Client;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;

/**
 * Main class
 */
class HtmlScraper
{

    private $client;
    private $config;

    /**
     * 
     * @param array $config array cotaining the various selectors
     * @param Client $client [optional]
     */
    public function __construct(array $config, Client $client = null)
    {
        if(!$client) {
            $client =  new Client();
        }
        $this->client = $client;
        $this->config = $config;
    }
    
    /**
     * Returns the content of url as an array
     * 
     * @param string $url
     * @return array
     */
    public function scrapeHtml($url) {
        
        $list    = [
            'results' => []
        ];
        
        $totalInPence = 0;
        
        $crawler = $this->client->request('GET', $url);
        
        $crawler->filter($this->config['list-selector'])->each(function ($node) use(&$list, &$totalInPence) {
            $title = trim($node->filter($this->config['title-selector'])->text());
            
            $link        = $node->selectLink($title)->link();
            $subCrawler  = $this->client->click($link);       
            
            /* There might be a better way, but this is approx correct */
            $sizeInKb    = round(strlen($subCrawler->html()) / 1000, 2). 'kb';
            
            /**
             * There seems to be a unicode issue with Goutte, ideally we want to sanitize the string here, we still have some duplicate spaces.
             */
            $description = trim(
                    preg_replace(
                        '/\s+/',
                        ' ',
                        $subCrawler->filter($this->config['description-selector'])->first()->text()));
            
            $priceText = $subCrawler->filter($this->config['unit-price-selector'])->text();
            $matches   = [];
            
            preg_match("/([\d\.]+)/", $priceText, $matches);
            
            $unitPrice   = $matches[0];
            
            $list['results'][] = [
                'title'       => $title,
                'size'        => $sizeInKb,
                'unit_price'  => $unitPrice,
                'description' => $description
            ];
            
            $totalInPence += $unitPrice * 100;
        });
        
        $list['total'] = sprintf('%0.2f', $totalInPence/100);
        return $list;
    }
}

