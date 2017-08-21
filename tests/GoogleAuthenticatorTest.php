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
        $this->assertEquals(
            16,
            strlen($this->helper->generateSecret())
        );
    }

    /**
     * @group legacy
     * @expectedDeprecation Passing anything other than null or a DateTimeInterface to $time is deprecated as of 2.0 and will not be possible as of 3.0.
     * @dataProvider testCheckCodeData
     */
    public function testCheckCodeWithLegacyArguments($expectation, $inputDate)
    {
        $authenticator = new GoogleAuthenticator(6, 10, new \DateTime('2012-03-17 22:17:00'));
        $this->assertSame(
            $expectation,
            $authenticator->checkCode('3DHTQX4GCRKHGS55CJ', $authenticator->getCode('3DHTQX4GCRKHGS55CJ', strtotime($inputDate) / 30))
        );
    }

    /**
     * @dataProvider testCheckCodeData
     */
    public function testCheckCode($expectation, $inputDate)
    {
        $authenticator = new GoogleAuthenticator(6, 10, new \DateTime('2012-03-17 22:17:00'));

        try {
            $datetime = new \DateTime($inputDate);
        } catch (\Exception $e) {
            return;
        }

        $this->assertSame(
            $expectation,
            $authenticator->checkCode('3DHTQX4GCRKHGS55CJ', $authenticator->getCode('3DHTQX4GCRKHGS55CJ', $datetime))
        );
    }

    /**
     * all dates compare to the same date + or - the several seconds compared
     * to 22:17:00 to verify if the code was perhaps the previous or next 30
     * seconds. This ensures that slow entries or time delays are not causing
     * problems.
     *
     * @return array
     */
    public static function testCheckCodeData(): array
    {
        return array(
            array(false, '2012-03-17 22:16:29'),
            array(true, '2012-03-17 22:16:30'),
            array(true, '2012-03-17 22:17:00'),
            array(true, '2012-03-17 22:17:30'),
            array(false, '2012-03-17 22:18:00'),
            array(false, 'this date cannot be resolved and results into false'),
        );
    }

    /**
     * @group legacy
     * @expectedDeprecation Using Google\Authenticator\GoogleAuthenticator::getUrl() is deprecated as of 2.1 and will be removed in 3.0. Use Google\Authenticator\GoogleQrUrl::generate() instead.
     */
    public function testGetUrlIssuer()
    {
        $this->assertEquals(
            'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2Ffoo%40foobar.org%3Fsecret%3D3DHTQX4GCRKHGS55CJ%26issuer%3DFooBar',
            $this->helper->getUrl('foo', 'foobar.org', '3DHTQX4GCRKHGS55CJ', 'FooBar')
        );
    }

    /**
     * @group legacy
     * @expectedDeprecation Using Google\Authenticator\GoogleAuthenticator::getUrl() is deprecated as of 2.1 and will be removed in 3.0. Use Google\Authenticator\GoogleQrUrl::generate() instead.
     */
    public function testGetUrlNoIssuer()
    {
        $this->assertEquals(
            'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2Ffoo%40foobar.org%3Fsecret%3D3DHTQX4GCRKHGS55CJ',
            $this->helper->getUrl('foo', 'foobar.org', '3DHTQX4GCRKHGS55CJ')
        );
    }
}
