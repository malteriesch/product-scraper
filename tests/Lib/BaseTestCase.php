<?php

namespace ScraperTests\Lib;

use org\bovigo\vfs\vfsStreamWrapper;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        vfsStreamWrapper::register();
    }

    public function teardown()
    {
        \Mockery::close();
    }

}
