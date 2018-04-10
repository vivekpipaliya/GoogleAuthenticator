UPGRADE 2.x
===========

UPGRADE FROM 2.0 to 2.1
=======================

### GoogleAuthenticator

 * Deprecated `GoogleAuthenticator::getUrl()` in favor of `GoogleQrUrl::generate()`.
 
   ```php
   $authenticator->getUrl('username', 'foobar.org', '3DHTQX4GCRKHGS55CJ', 'FooBar');
   // would be replaced by
   GoogleQrUrl::generate('username@foobar.org', '3DHTQX4GCRKHGS55CJ', 'FooBar');
   ```

 * The second argument of `getCode` allowed multiple types and had to be
   divided by 30 in order to work. This behavior is now deprecated and a
   `DateTimeInterface` implementation should be passed instead.
