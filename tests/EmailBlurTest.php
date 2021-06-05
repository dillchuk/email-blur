<?php

namespace Wobeto\EmailBlur\Tests;

use PHPUnit\Framework\TestCase;
use Wobeto\EmailBlur\Blur;


class EmailBlurTest extends TestCase
{

    public function testDefaultBlur()
    {
        $blur = new Blur('example@test.com');

        $obscured = $blur->make();

        $this->assertEquals('exa***@***.com', $obscured);
    }

    public function testDefaultBlurShortEmail()
    {
        $blur = new Blur('jo@test.com');

        $obscured = $blur->make();

        $this->assertEquals('j***@***.com', $obscured);
    }

    public function testDefaultBlurComBr()
    {
        $blur = new Blur('example@test.com.br');

        $obscured = $blur->make();

        $this->assertEquals('exa***@***.com.br', $obscured);
    }

    public function testBlurWithMaskChanged()
    {
        $blur = new Blur('example@test.com');

        $obscured = $blur->setTotalMask(5)->make();

        $this->assertEquals('exa*****@*****.com', $obscured);
    }

}