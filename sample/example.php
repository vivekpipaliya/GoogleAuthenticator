<?php

include_once __DIR__.'/../lib/Google/Authenticator/FixedBitNotation.php';
include_once __DIR__.'/../lib/Google/Authenticator/GoogleAuthenticator.php';

$secret = 'XVQ2UIGO75XRUKJO';
$time = floor(time() / 30);
$code = '846474';

$g = new \Google\Authenticator\GoogleAuthenticator();

echo 'Current Code is: ';
echo $g->getCode($secret);

echo "\n";

echo "Check if $code is valid: ";

if ($g->checkCode($secret, $code)) {
    echo "YES \n";
} else {
    echo "NO \n";
}

$secret = $g->generateSecret();
echo "Get a new Secret: $secret \n";
echo "The QR Code for this secret (to scan with the Google Authenticator App: \n";

echo $g->getURL('chregu', 'example.org', $secret);
echo "\n";
