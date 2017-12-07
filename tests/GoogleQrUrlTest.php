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

class GoogleQrUrlTest extends \PHPUnit\Framework\TestCase
{
    public function testGetUrlIssuer(): void
    {
        // otpauth://totp/FooBar:foo@foobar.org?secret=3DHTQX4GCRKHGS55CJ&issuer=FooBar
        $this->assertEquals(
            'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2FFooBar%3AJohn%20Doe%3Fsecret%3D3DHTQX4GCRKHGS55CJ%26issuer%3DFooBar',
            GoogleQrUrl::generate('John Doe', '3DHTQX4GCRKHGS55CJ', 'FooBar')
        );
    }

    public function testGetUrlNoIssuer(): void
    {
        // otpauth://totp/foo@foobar.org?secret=3DHTQX4GCRKHGS55CJ&issuer=FooBar
        $this->assertEquals(
            'https://chart.googleapis.com/chart?chs=400x400&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2Ffoo%40foobar.org%3Fsecret%3D3DHTQX4GCRKHGS55CJ',
            GoogleQrUrl::generate('foo@foobar.org', '3DHTQX4GCRKHGS55CJ', null, 400)
        );
    }

    public function testEmptyIssuer(): void
    {
        $this->expectException(\Sonata\GoogleAuthenticator\RuntimeException::class);
        $this->expectExceptionMessage('The issuer name may not contain a double colon (:) and may not be an empty string. Given "".');

        GoogleQrUrl::generate('JohnDoe', '3DHTQX4GCRKHGS55CJ', '');
    }

    public function testInvalidIssuer(): void
    {
        $this->expectException(\Sonata\GoogleAuthenticator\RuntimeException::class);
        $this->expectExceptionMessage('The issuer name may not contain a double colon (:) and may not be an empty string. Given "Foo: bar".');

        GoogleQrUrl::generate('JohnDoe', '3DHTQX4GCRKHGS55CJ', 'Foo: bar');
    }

    public function testEmptyAccountName(): void
    {
        $this->expectException(\Sonata\GoogleAuthenticator\RuntimeException::class);
        $this->expectExceptionMessage('The account name may not contain a double colon (:) and may not be an empty string. Given "".');

        GoogleQrUrl::generate('', '3DHTQX4GCRKHGS55CJ');
    }

    public function testInvalidAccountName(): void
    {
        $this->expectException(\Sonata\GoogleAuthenticator\RuntimeException::class);
        $this->expectExceptionMessage('The account name may not contain a double colon (:) and may not be an empty string. Given "John: Doe".');

        GoogleQrUrl::generate('John: Doe', '3DHTQX4GCRKHGS55CJ', 'Foo: bar');
    }

    public function testInvalidSecret(): void
    {
        $this->expectException(\Sonata\GoogleAuthenticator\RuntimeException::class);
        $this->expectExceptionMessage('The secret name may not be an empty string.');

        GoogleQrUrl::generate('John Doe', '');
    }
}
