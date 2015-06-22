<?php

namespace Scraper\Application\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Scraper\Http\HtmlScraper;
use Scraper\Format\Json;

/**
 * Command that does the actual scraping
 */
class ScrapeCommand extends Command {

    protected $config = array();
    
    /**
     * @inheritdoc
     */
    protected function configure()
    {   

        $this->setName("scrape:url")
             ->setDescription("returns the items of a product page in json")
             ->setDefinition(new \Symfony\Component\Console\Input\InputDefinition(
                     array(new InputArgument('url'))))
             ->setHelp(<<<EOT
Returns json of product page

Usage:

<info>php app/scrape.php scrape:url "http://www.sainsburys.co.uk/shop/gb/groceries/fruit-veg/new-in-season#langId=44&storeId=10151&catalogId=10122&categoryId=12524&parent_category_rn=12518&top_category=12518&pageSize=30&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0" > file.json</info>

EOT
);
    }
    
    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $scraper   = new HtmlScraper($this->getConfig());
        $formatter = $this->getFormatter();
        
        $output->writeln(
            $formatter->getConverted(
                    $scraper->scrapeHtml($input->getArgument('url'))));
    }
    
    /**
     * 
     * @return array
     */
    function getConfig()
    {
        return $this->config;
    }
    
    /**
     * 
     * @param array $config
     */
    function setConfig(array $config)
    {
        $this->config = $config;
    }
    
    /**
     * Creating the formatter like this we can later inject it properly
     * 
     * @return Json
     */
    protected function getFormatter() 
    {
        return new Json();
    }
}