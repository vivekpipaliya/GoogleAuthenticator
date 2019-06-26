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

use Sonata\GoogleAuthenticator\FixedBitNotation;

class FixedBitNotationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider decodeGuardData
     */
    public function testDecodeGuard($input): void
    {
        $bits = new FixedBitNotation(5);

        $this->assertSame('', $bits->decode($input));
    }

    /**
     * All returned values in here should result in decoding into an empty
     * string.
     *
     * @return array
     */
    public static function decodeGuardData(): array
    {
        return [
            [null],
            [''],
            [0],
            [false],
        ];
    }

    /**
     * @dataProvider decodeIsSameAsEncode
     */
    public function testDecodeIsSameAsEncode($input): void
    {
        $bits = new FixedBitNotation(5);

        $this->assertSame((string) $input, $bits->decode($bits->encode($input)));
    }

    /**
     * Test with padding.
     *
     * @dataProvider decodeIsSameAsEncode
     */
    public function testDecodeIsSameAsEncodeWithPadding($input): void
    {
        $bits = new FixedBitNotation(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567', true, true);

        $this->assertSame((string) $input, $bits->decode($bits->encode($input)));
    }

    /**
     * Every single value in here should be equal to the returned string value.
     *
     * @return array
     */
    public static function decodeIsSameAsEncode(): array
    {
        return [
            ['Foobar'],
            ['Foobar <with> *crazy</with> stuff*\n &nbsp;'],
            [<<<'DATA'
            multi
            line
DATA
            ],
        ];
    }
}
