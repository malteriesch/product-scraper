<?php

// include the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// import the Symfony Console Application 
use Symfony\Component\Console\Application;
use Scraper\Application\Commands\ScrapeCommand;

$command = new ScrapeCommand();
$command->setConfig([
    'list-selector'        => 'div.product',
    'title-selector'       => 'h3 > a',
    'description-selector' => 'div.productText',
    'unit-price-selector'  => 'p.pricePerUnit'
]);

$application = new Application();
$application->add($command);
$application->run();
