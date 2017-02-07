# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [0.1.6] - 2017-02-07
### Changed
- Implement `OptionRepository::findAll()` and fix `OptionsStore::getAll()`. Props @Giuseppe-Mazzapica.

### Fixed
- Fix bug in `WordPressOptionRepository::writeOption()` method. Props @Giuseppe-Mazzapica.

## [0.1.5] - 2017-02-07
### Fixed
- Removed `void` return type hint from `IdentityMap::purge()`.

## [0.1.4] - 2017-02-07
### Added
- Added `ConfigurableOptionsStore` that accepts a config to set itself up.
- Added `purge()` method to `IdentityMap` class.
- Added `Prefixable` interface to make prefixes discoverable.

## [0.1.3] - 2017-02-07
### Changed
- Removed unneeded `OptionsStore::update()` method.

## [0.1.2] - 2017-02-07
### Changed
- `Option` interface overrides `setValue()` method to indicate correct return type.

### Fixed
- Filled some empty stubs in `OptionsStore` class.

## [0.1.1] - 2017-02-07
### Changed
- Split out `BrightNucleus\Value` namespace into separate package (`brightnucleus/values`).

## [0.1.0] - 2017-02-07
### Added
- Initial release to GitHub.

[0.1.6]: https://github.com/brightnucleus/options-store/compare/v0.1.5...v0.1.6
[0.1.5]: https://github.com/brightnucleus/options-store/compare/v0.1.4...v0.1.5
[0.1.4]: https://github.com/brightnucleus/options-store/compare/v0.1.3...v0.1.4
[0.1.3]: https://github.com/brightnucleus/options-store/compare/v0.1.2...v0.1.3
[0.1.2]: https://github.com/brightnucleus/options-store/compare/v0.1.1...v0.1.2
[0.1.1]: https://github.com/brightnucleus/options-store/compare/v0.1.0...v0.1.1
[0.1.0]: https://github.com/brightnucleus/options-store/compare/v0.0.0...v0.1.0
