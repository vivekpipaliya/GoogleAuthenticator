<?php

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

class FixedBitNotationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider decodeGuardData
     */
    public function testDecodeGuard($input)
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
        return array(
            array(null),
            array(''),
            array(0),
            array(false),
        );
    }

    /**
     * @dataProvider decodeIsSameAsEncode
     */
    public function testDecodeIsSameAsEncode($input)
    {
        $bits = new FixedBitNotation(5);

        $this->assertSame((string) $input, $bits->decode($bits->encode($input)));
    }

    /**
     * Every single value in here should be equal to the returned string value.
     *
     * @return array
     */
    public static function decodeIsSameAsEncode(): array
    {
        return array(
            array('Foobar'),
            array('Foobar <with> *crazy</with> stuff*\n &nbsp;'),
            array(<<<'DATA'
            multi
            line
DATA
            ),
        );
    }
}
