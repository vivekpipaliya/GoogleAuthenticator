<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at.
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Authenticator;

/**
 * @see https://github.com/google/google-authenticator/wiki/Key-Uri-Format
 */
final class GoogleAuthenticator
{
    /**
     * @var int
     */
    private $secretLength;

    /**
     * @var int
     */
    private $pinModulo;

    /**
     * @var \DateTimeInterface
     */
    private $now;

    /**
     * @var int
     */
    private $codePeriod = 30;

    /**
     * @param int                     $passCodeLength
     * @param int                     $secretLength
     * @param \DateTimeInterface|null $now
     */
    public function __construct(int $passCodeLength = 6, int $secretLength = 10, \DateTimeInterface $now = null)
    {
        $this->secretLength = $secretLength;
        $this->pinModulo = 10 ** $passCodeLength;
        $this->now = $now ?? new \DateTime();
    }

    /**
     * @param string $secret
     * @param string $code
     *
     * @return bool
     */
    public function checkCode($secret, $code): bool
    {
        $time = floor($this->now->getTimestamp() / $this->codePeriod);

        for ($i = -1; $i <= 1; ++$i) {
            if (hash_equals($this->getCode($secret, $time + $i), $code)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string                $secret
     * @param float|string|int|null $time
     *
     * @return string
     */
    public function getCode($secret, $time = null): string
    {
        if (null === $time) {
            $time = floor($this->now->getTimestamp() / $this->codePeriod);
        }

        $base32 = new FixedBitNotation(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567', true, true);
        $secret = $base32->decode($secret);

        $time = pack('N', $time);
        $time = str_pad($time, 8, chr(0), STR_PAD_LEFT);

        $hash = hash_hmac('sha1', $time, $secret, true);
        $offset = ord(substr($hash, -1));
        $offset &= 0xF;

        $truncatedHash = $this->hashToInt($hash, $offset) & 0x7FFFFFFF;

        return str_pad($truncatedHash % $this->pinModulo, 6, '0', STR_PAD_LEFT);
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * @param string $user
     * @param string $hostname
     * @param string $secret
     *
     * @return string
     *
     * @deprecated deprecated as of 2.1 and will be removed in 3.0. Use Google\Authenticator\GoogleQrUrl::generate() instead.
     */
    public function getUrl($user, $hostname, $secret): string
    {
        @trigger_error(sprintf(
            'Using %s() is deprecated as of 2.1 and will be removed in 3.0. '.
            'Use Google\Authenticator\GoogleQrUrl::generate() instead.',
            __METHOD__
        ), E_USER_DEPRECATED);

        $issuer = func_get_args()[3] ?? null;
        $accountName = sprintf('%s@%s', $user, $hostname);

        // manually concat the issuer to avoid a change in URL
        $url = GoogleQrUrl::generate($accountName, $secret);

        if ($issuer) {
            $url .= '%26issuer%3D'.$issuer;
        }

        return $url;
    }

    /**
     * @return string
     */
    public function generateSecret(): string
    {
        return (new FixedBitNotation(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567', true, true))
            ->encode(random_bytes($this->secretLength));
    }

    /**
     * @param string $bytes
     * @param int    $start
     *
     * @return int
     */
    private function hashToInt(string $bytes, int $start): int
    {
        return unpack('N', substr(substr($bytes, $start), 0, 4))[1];
    }
}
