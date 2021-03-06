<?php

namespace JouwWeb\TokenBucket\Test;

use JouwWeb\TokenBucket\Rate;
use PHPUnit\Framework\TestCase;

class RateTest extends TestCase
{
    /**
     * Tests getTokensPerSecond().
     *
     * @param float $expected
     * @param Rate $rate
     * @dataProvider provideTestGetTokensPerSecond
     */
    public function testGetTokensPerSecond($expected, Rate $rate)
    {
        $this->assertEquals($expected, $rate->getTokensPerSecond());
    }
    
    /**
     * Provides tests cases for testGetTokensPerSecond().
     *
     * @return array Test cases.
     */
    public function provideTestGetTokensPerSecond()
    {
        return [
            [1/60/60/24/365, new Rate(1, Rate::YEAR)],
            [2/60/60/24/365, new Rate(2, Rate::YEAR)],
            [1/2629743.83, new Rate(1, Rate::MONTH)],
            [2/2629743.83, new Rate(2, Rate::MONTH)],
            [1/60/60/24/7, new Rate(1, Rate::WEEK)],
            [2/60/60/24/7, new Rate(2, Rate::WEEK)],
            [1/60/60/24, new Rate(1, Rate::DAY)],
            [2/60/60/24, new Rate(2, Rate::DAY)],
            [1/60/60, new Rate(1, Rate::HOUR)],
            [2/60/60, new Rate(2, Rate::HOUR)],
            [1/60, new Rate(1, Rate::MINUTE)],
            [2/60, new Rate(2, Rate::MINUTE)],
            [1, new Rate(1, Rate::SECOND)],
            [2, new Rate(2, Rate::SECOND)],
            [1000, new Rate(1, Rate::MILLISECOND)],
            [2000, new Rate(2, Rate::MILLISECOND)],
            [1000000, new Rate(1, Rate::MICROSECOND)],
            [2000000, new Rate(2, Rate::MICROSECOND)],
        ];
    }
    
    /**
     * Tests building a rate with an invalid unit fails.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidUnit()
    {
        new Rate(1, "invalid");
    }

    /**
     * Tests building a rate with an invalid amount fails.
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider provideTestInvalidAmount
     */
    public function testInvalidAmount($amount)
    {
        new Rate($amount, Rate::SECOND);
    }

    /**
     * Provides tests cases for testInvalidAmount().
     *
     * @return array Test cases.
     */
    public function provideTestInvalidAmount()
    {
        return [
            [0],
            [-1],
        ];
    }
}
