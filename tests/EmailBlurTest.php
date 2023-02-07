<?php

namespace Wobeto\EmailBlur\Tests;

use PHPUnit\Framework\TestCase;
use Wobeto\EmailBlur\Blur;


class EmailBlurTest extends TestCase
{
    /**
     * @var Blur
     */
    protected $blur;

    public function setUp(): void
    {
        parent::setUp();
        $this->blur = new Blur();
    }

    /**
     * @dataProvider provideDefault
     */
    public function testDefault($input, $expected) {
        $obscured = $this->blur->make($input);
        $this->assertEquals($expected, $obscured);
    }
    public function provideDefault()
    {
        return [
            ['j@test.com', '***@t***.com'],
            ['jo@test.com', 'j***@t***.com'],
            ['joe@test.com', 'j***@t***.com'],
            ['joel@test.com', 'j***@t***.com'],
            ['joelsmith@domain.com', 'joe***@dom***.com'],
            ['joel.smith@domain.com', 'joe***@dom***.com'],
            [' joel.smith@domain.com '.PHP_EOL, 'joe***@dom***.com'],
        ];
    }

    /**
     * @dataProvider provideSld
     */
    public function testSld($input, $expected) {
        $obscured = $this->blur->make($input);
        $this->assertEquals($expected, $obscured);
    }
    public function provideSld()
    {
        return [
            ['joel.smith@domain.co.uk', 'joe***@dom***.co.uk'],
            ['joel.smith@domain.bc.ca', 'joe***@dom***.bc.ca'],
            ['joel.smith@domain.mil.uk', 'joe***@dom***.mil.uk'],
        ];
    }

    /**
     * @dataProvider provideBadSld
     */
    public function testBadSld($input, $expected) {
        $obscured = $this->blur->make($input);
        $this->assertEquals($expected, $obscured);
    }
    public function provideBadSld()
    {
        return [
            ['joel.smith@domain.co.zz', 'joe***@dom***.zz'],
            ['joel.smith@domain.bc.fr', 'joe***@dom***.fr'],
            ['joel.smith@domain.mil.ag', 'joe***@dom***.ag'],
        ];
    }

    /**
     * @dataProvider provideMaskChanged
     */
    public function testMaskChanged($input, $expected) {
        $blur = new Blur(mask: '<redacted>');
        $obscured = $blur->make($input);
        $this->assertEquals($expected, $obscured);
    }
    public function provideMaskChanged()
    {
        return [
            ['joelsmith@domain.com', 'joe<redacted>@dom<redacted>.com'],
            ['j@d.com', '<redacted>@<redacted>.com'],
        ];
    }

    /**
     * @dataProvider provideDomainVisible
     */
    public function testDomainVisible($input, $expected)
    {
        $blur = new Blur(maskDomain: false);
        $obscured = $blur->make($input);
        $this->assertEquals($expected, $obscured);
    }
    public function provideDomainVisible()
    {
        return [
            ['joel.smith@domain.co.zz', 'joe***@domain.co.zz'],
            ['joel.smith@domain.co.uk', 'joe***@domain.co.uk'],
            ['joel.smith@yahoo.com', 'joe***@yahoo.com'],
            ['joel.smith@example.com', 'joe***@example.com'],
        ];
    }

    /**
     * @dataProvider provideFree
     */
    public function testFree($input, $expected)
    {
        $obscured = $this->blur->make($input);
        $this->assertEquals($expected, $obscured);
    }
    public function provideFree()
    {
        return [
            ['joel.smith@gmail.com', 'joe***@gmail.com'],
            ['joel.smith@yahoo.com', 'joe***@yahoo.com'],
            ['joel@yahoo.com.br', 'j***@yahoo.com.br'],
        ];
    }

    /**
     * @dataProvider provideFreeMasked
     */
    public function testFreeMasked($input, $expected)
    {
        $blur = new Blur(maskFree: true);
        $obscured = $blur->make($input);
        $this->assertEquals($expected, $obscured);
    }
    public function provideFreeMasked()
    {
        return [
            ['joel.smith@gmail.com', 'joe***@gma***.com'],
            ['joel.smith@yahoo.com', 'joe***@yah***.com'],
            ['joel@yahoo.com.br', 'j***@yah***.com.br'],
        ];
    }

    /**
     * @dataProvider provideException
     */
    public function testException($input)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->blur->make($input);
    }
    public function provideException()
    {
        return [
            ['joel.smith@com'],
            ['joel.smith@domain,com'],
            ['@yahoo.com'],
            ['joelyahoo.com.br'],
            ['joel@smith@yahoo.com.br'],
            ['a@'],
            ['@a'],
            ['@'],
            [''],
        ];
    }
}
