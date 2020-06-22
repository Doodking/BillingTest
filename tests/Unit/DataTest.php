<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testValidate()
    {
        $this->assertEquals(true, \Validation::isCardValid('5404 3627 8871 3019', 'MAX MARKOFF','165','07/2024'));
    }


}
