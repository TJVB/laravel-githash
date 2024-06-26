# Contributing
Contributions are always very welcome. This file is a guideline about how to contribute.

## How to contribute
All the contributions need to be done with a merge request. It is possible to create a merge request prefixed with Draft: to ask for feedback or if you didn't know how to match all requirements.  
Please be sure to check all the [requirements](#requirements) before sending your merge request (except a Draft merge request).

## Requirements
* All the code need to confirm to the [PSR-12](https://www.php-fig.org/psr/psr-12/) and additional rules, the rules are described in `ecs.php`. You can validate this locally with `composer cs` or automate the fixes with. `composer cs-fix`
* We use [PHPMD](https://phpmd.org) to validate the quality of the code. You can check it locally with `composer phpmd`
* We use [PHPStan](https://phpstan.org/) to find possible bugs in the code. You can run it with `composer phpstan`.
* Add tests for code changes, we use [PHPUnit](https://phpunit.de/). You can run the test with `composer test`. If you want to see the code coverage you can run `composer test-coverage` the coverage html will be stored in `build/coverage`.
* In addition to PHPUnit we have [Infection](https://infection.github.io/) to validate the quality of our tests. You can run infection with `composer infection`, this wil give information in the console and store log files in `build/infection`.
* You can run all the checks written above at once with `composer check`.
* Document the changes, any functional change or bug fix need to be written in [CHANGELOG.md](CHANGELOG.md). Depending on your change you need to add some documentation to the [README.md](README.md)
* Respect [SemVer](http://semver.org/), we use Semantic Versioning so please respect it with the changes you want to add.
* A merge request for a change. Please don't mix multiple changes in one merge request.
* Ask questions. This can be if you are not sure about something, or you think about adding something. 

