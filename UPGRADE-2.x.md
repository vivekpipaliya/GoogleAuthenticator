UPGRADE 2.x
===========

### GoogleAuthenticator

 * Deprecated `GoogleAuthenticator::getUrl()` in favor of `GoogleQrUrl::generate()`.
 
   ```php
   $authenticator->getUrl('username', 'foobar.org', '3DHTQX4GCRKHGS55CJ', 'FooBar');
   // would be replaced by
   GoogleQrUrl::generate('username@foobar.org', '3DHTQX4GCRKHGS55CJ', 'FooBar');
   ```
