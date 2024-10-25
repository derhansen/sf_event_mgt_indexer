[![Project Status: Active – The project has reached a stable, usable state and is being actively developed.](https://www.repostatus.org/badges/latest/active.svg)](https://www.repostatus.org/#active)

ke_search indexer for sf_event_mgt
==================================

## What is it?

Indexer for ke_search which indexes sf_event_mgt records

## Usage

Install the extension and configure the indexer in the TYPO3 backend

## PSR-14 Events

The extension currently contains the following PSR-14 event:

* Derhansen\SfEventMgtIndexer\Events
    * `ModifyIndexDataEvent`

This event can be used to modify `title`, `teaser`, `fullContent` and `additionalFields` before
data is stored in the index.

## Versions

| Version | TYPO3       | PHP       | Support/Development                  |
|---------|-------------|-----------|--------------------------------------|
| 5.x     | 12.4 - 13.4 | 8.1 - 8.3 | Features, Bugfixes, Security Updates |
| 4.x     | 11.5 - 12.4 | 7.4 - 8.3 | Features, Bugfixes, Security Updates |
| 3.x     | 11.5        | 7.4 - 8.3 | Support dropped                      |
| 2.x     | 8.7 - 10.4  | 7.0 - 7.4 | Security Updates                     |

## Breaking changes

###  Version 4.0.0

The following hooks have been removed:

* `$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sf_event_mgt_indexer']['modifyAdditionalFields']`
* `$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sf_event_mgt_indexer']['modifyIndexContent']`

Users who previously used one of the removed hooks must use the new `ModifyIndexDataEvent` instead.

## Feedback and updates

This extension is hosted in GitHub. Please report feedback, bugs and change requests directly at
https://github.com/derhansen/sf_event_mgt_indexer

Updates will be published on TER and packagist.

## Support

If you need commercial support or want to sponsor new features, please contact me directly by e-mail.
