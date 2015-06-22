<?php

namespace Scraper\Format;

/**
 * defines inteface for formatters
 */
interface FormatInterface
{

    /**
     * returns $toConvert in the defined format
     * 
     * @param array $toConvert
     * @return string|mixed
     */
    public function getConverted(array $toConvert);
}
