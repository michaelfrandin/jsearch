<?php

namespace Test\Json\DB\Drive\File;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Json\DB\Drive\File\Config;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function whenISetTheConfigShouldGetPathReturnPathAndGetIndexReturnIndex()
    {
        $config = new Config("/full/path/", "default");

        Assert::assertEquals("/full/path/", $config->getPath());
        Assert::assertEquals("default", $config->getIndex());
    }
}
