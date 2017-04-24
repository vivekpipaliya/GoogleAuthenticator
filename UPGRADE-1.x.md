UPGRADE 1.x
===========

UPGRADE FROM 1.0 to 1.1
=======================

### Closed API

Extending any class defined in this library is now deprecated
and will not be possible on next major release.

### Tests

All files under the ``Tests`` directory are now correctly handled as internal test classes. 
You can't extend them anymore, because they are only loaded when running internal tests. 
More information can be found in the [composer docs](https://getcomposer.org/doc/04-schema.md#autoload-dev).
