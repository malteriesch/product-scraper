<?php

namespace Scraper\Format;

/**
 * Converts arrtay to 
 */
class Json implements FormatInterface
{
    /**
     * @inheritdoc
     */
    public function getConverted(array $toConvert)
    {

        return json_encode($toConvert);
    }

}
