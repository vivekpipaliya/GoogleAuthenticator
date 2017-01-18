<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Google\Authenticator\tests;

use Google\Authenticator\GoogleAuthenticator;

class GoogleAuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Google\Authenticator\GoogleAuthenticator
     */
    protected $helper;

    public function setUp()
    {
        $this->helper = new GoogleAuthenticator();
    }

    public function testGenerateSecret()
    {
        $secret = $this->helper->generateSecret();

        $this->assertEquals(16, strlen($secret));
    }

    public function testGetCode()
    {
        $code = $this->helper->getCode('3DHTQX4GCRKHGS55CJ', strtotime('17/03/2012 22:17'));

        $this->assertTrue($this->helper->checkCode('3DHTQX4GCRKHGS55CJ', $code));
    }

    public function testGetUrl()
    {
        $url = $this->helper->getUrl('foo', 'foobar.org', '3DHTQX4GCRKHGS55CJ', 'FooBar');
        $expected = 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/foo@foobar.org%3Fsecret%3D3DHTQX4GCRKHGS55CJ%26issuer%3DFooBar';
        $this->assertEquals($expected, $url);
    }
}
