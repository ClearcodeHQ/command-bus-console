<?php

namespace tests\Command;

use tests\IntegrationTestCase;

class SomeTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function itShouldRunThisTest()
    {
        $this->assertTrue(true);
    }
    protected function setUp()
    {
        parent::setUp();
    }
}
