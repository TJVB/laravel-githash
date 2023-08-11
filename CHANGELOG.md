# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).


## [Unreleased]

### Fixed
- Fix missing ) after the long hash in the view if $version is not set.

## 1.4.0 - 2023-02-14

### Added
- Add Laravel 10 support.

## 1.3.0 - 2023-02-08

### Added
- Add PHP 8.2 support
- Add information to the Laravel about command.

### Changed
- Switch from `getHash` to `getHashAndIgnoreFailures` in the HashLoader to iterate all finders on a failure.

## 1.2.0 - 2022-02-8
### Added
- Add support for Laravel 9

## 1.1.0 - 2021-12-05
### Added
- Add PHP 8.1 support

## 1.0.0 - 2021-10-30
- Initial release
