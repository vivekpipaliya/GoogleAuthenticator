<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\GoogleAuthenticator\tests;

use Sonata\GoogleAuthenticator\GoogleQrUrl;

class GoogleQrUrlTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUrlIssuer()
    {
        // otpauth://totp/FooBar:foo@foobar.org?secret=3DHTQX4GCRKHGS55CJ&issuer=FooBar
        $this->assertEquals(
            'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2FFooBar%3AJohn%20Doe%3Fsecret%3D3DHTQX4GCRKHGS55CJ%26issuer%3DFooBar',
            GoogleQrUrl::generate('John Doe', '3DHTQX4GCRKHGS55CJ', 'FooBar')
        );
    }

    public function testGetUrlNoIssuer()
    {
        // otpauth://totp/foo@foobar.org?secret=3DHTQX4GCRKHGS55CJ&issuer=FooBar
        $this->assertEquals(
            'https://chart.googleapis.com/chart?chs=400x400&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2Ffoo%40foobar.org%3Fsecret%3D3DHTQX4GCRKHGS55CJ',
            GoogleQrUrl::generate('foo@foobar.org', '3DHTQX4GCRKHGS55CJ', null, 400)
        );
    }

    /**
     * @expectedException \Sonata\GoogleAuthenticator\RuntimeException
     * @expectedExceptionMessage The issuer name may not contain a double colon (:) and may not be an empty string. Given "".
     */
    public function testEmptyIssuer()
    {
        GoogleQrUrl::generate('JohnDoe', '3DHTQX4GCRKHGS55CJ', '');
    }

    /**
     * @expectedException \Sonata\GoogleAuthenticator\RuntimeException
     * @expectedExceptionMessage The issuer name may not contain a double colon (:) and may not be an empty string. Given "Foo: bar".
     */
    public function testInvalidIssuer()
    {
        GoogleQrUrl::generate('JohnDoe', '3DHTQX4GCRKHGS55CJ', 'Foo: bar');
    }

    /**
     * @expectedException \Sonata\GoogleAuthenticator\RuntimeException
     * @expectedExceptionMessage The account name may not contain a double colon (:) and may not be an empty string. Given "".
     */
    public function testEmptyAccountName()
    {
        GoogleQrUrl::generate('', '3DHTQX4GCRKHGS55CJ');
    }

    /**
     * @expectedException \Sonata\GoogleAuthenticator\RuntimeException
     * @expectedExceptionMessage The account name may not contain a double colon (:) and may not be an empty string. Given "John: Doe".
     */
    public function testInvalidAccountName()
    {
        GoogleQrUrl::generate('John: Doe', '3DHTQX4GCRKHGS55CJ', 'Foo: bar');
    }

    /**
     * @expectedException \Sonata\GoogleAuthenticator\RuntimeException
     * @expectedExceptionMessage The secret name may not be an empty string.
     */
    public function testInvalidSecret()
    {
        GoogleQrUrl::generate('John Doe', '');
    }
}
