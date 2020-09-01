# Google Authenticator

Ported from http://code.google.com/p/google-authenticator/

You can use the Google Authenticator app from here
http://www.google.com/support/accounts/bin/answer.py?hl=en&answer=1066447
to generate One Time Passwords/Tokens and check them with this little
PHP app (Of course, you can also create them with this).

[![Latest Stable Version](https://poser.pugx.org/sonata-project/google-authenticator/v/stable)](https://packagist.org/packages/sonata-project/google-authenticator)
[![Latest Unstable Version](https://poser.pugx.org/sonata-project/google-authenticator/v/unstable)](https://packagist.org/packages/sonata-project/google-authenticator)
[![License](https://poser.pugx.org/sonata-project/google-authenticator/license)](https://packagist.org/packages/sonata-project/google-authenticator)

[![Total Downloads](https://poser.pugx.org/sonata-project/google-authenticator/downloads)](https://packagist.org/packages/sonata-project/google-authenticator)
[![Monthly Downloads](https://poser.pugx.org/sonata-project/google-authenticator/d/monthly)](https://packagist.org/packages/sonata-project/google-authenticator)
[![Daily Downloads](https://poser.pugx.org/sonata-project/google-authenticator/d/daily)](https://packagist.org/packages/sonata-project/google-authenticator)

Branch | Github Actions | Coverage |
------ | -------------- | -------- |
3.x    | [![Test][test_stable_badge]][test_stable_link]     | [![Coverage Status][coverage_stable_badge]][coverage_stable_link]     |
master | [![Test][test_unstable_badge]][test_unstable_link] | [![Coverage Status][coverage_unstable_badge]][coverage_unstable_link] |

### Installation using Composer

Add the dependency:

```bash
php composer.phar require sonata-project/google-authenticator
```

If asked for a version, type in 'dev-master' (unless you want another version):

```bash
Please provide a version constraint for the sonata-project/google-authenticator requirement: dev-master
```

## Usage

See example.php for how to use it.

There's a little web app showing how it works in web/, please make users.dat
writeable for the webserver, doesn't really work otherwise (it can't save the
secret). Try to login with chregu/foobar.

What's missing in the example:

 * Prevent replay attacks. One token should only be used once
 * Show QR Code only when providing password again (or not at all)
 * Regenerate secret

## Support

For general support and questions, please use [StackOverflow](http://stackoverflow.com/questions/tagged/sonata).

If you think you found a bug or you have a feature idea to propose, feel free to open an issue
**after looking** at the [contributing guide](CONTRIBUTING.md).

## License

This package is available under the [MIT license](LICENSE).

[test_stable_badge]: https://github.com/sonata-project/GoogleAuthenticator/workflows/Test/badge.svg?branch=2.x
[test_stable_link]: https://github.com/sonata-project/GoogleAuthenticator/actions?query=workflow:test+branch:2.x
[test_unstable_badge]: https://github.com/sonata-project/GoogleAuthenticator/workflows/Test/badge.svg?branch=master
[test_unstable_link]: https://github.com/sonata-project/GoogleAuthenticator/actions?query=workflow:test+branch:master

[coverage_stable_badge]: https://codecov.io/gh/sonata-project/GoogleAuthenticator/branch/2.x/graph/badge.svg
[coverage_stable_link]: https://codecov.io/gh/sonata-project/GoogleAuthenticator/branch/2.x
[coverage_unstable_badge]: https://codecov.io/gh/sonata-project/GoogleAuthenticator/branch/master/graph/badge.svg
[coverage_unstable_link]: https://codecov.io/gh/sonata-project/GoogleAuthenticator/branch/master
