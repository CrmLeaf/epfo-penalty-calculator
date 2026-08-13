# Changelog

Notable changes to `crmleaf/epfo-penalty-calculator`.

Format per [Keep a Changelog](https://keepachangelog.com/en/1.1.0/); versioning
per [Semantic Versioning](https://semver.org/spec/v2.0.0.html) - with one extra
rule this package observes, because it computes statutory figures:

> **Any change that alters a published result is at minimum a minor release**,
> and is listed under `Changed` with the notification, circular or Act section
> that prompted it.

## [Unreleased]

## [1.0.0] - 2026-08-12

### Added

- Initial release. Prices a late provident fund deposit: simple interest for every day of delay under 7Q, plus damages banded by the length of the delay under 14B, each shown separately because they are separate liabilities.

### Statutory basis

- EPF & MP Act 1952, section 7Q for interest at 12% per annum and section 14B for damages, on both the pre- and post-14-June-2024 bases.

[Unreleased]: https://github.com/crmleaf/epfo-penalty-calculator/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/crmleaf/epfo-penalty-calculator/releases/tag/v1.0.0
