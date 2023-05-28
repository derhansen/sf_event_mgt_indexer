[![Project Status: Active – The project has reached a stable, usable state and is being actively developed.](https://www.repostatus.org/badges/latest/active.svg)](https://www.repostatus.org/#active)

ke_search indexer for sf_event_mgt
==================================

## What is it?

Indexer for ke_search which indexes sf_event_mgt records

## Usage

Install the extension and configure the indexer in the TYPO3 backend

## Hooks

**modifyAdditionalFields**

```
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sf_event_mgt_indexer']['modifyAdditionalFields']
```

This hook can be used to modify/extend the additionalFields value (e.g., if it is required to index additional event
properties like start- and enddate)

**modifyIndexContent**

```
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sf_event_mgt_indexer']['modifyIndexContent']
```

This hook can be used to modify the content to index. See in code for details, which field values can be modified.

## Versions

| Version | TYPO3       | PHP       | Support/Development                  |
|---------|-------------|-----------|--------------------------------------|
| 4.x     | 11.5 - 12.4 | 7.4 - 8.2 | Features, Bugfixes, Security Updates |
| 3.x     | 11.5        | 7.4 - 8.1 | Support dropped                      |
| 2.x     | 8.7 - 10.4  | 7.0 - 7.4 | Security Updates                     |

## Feedback and updates

This extension is hosted in GitHub. Please report feedback, bugs and change requests directly at
https://github.com/derhansen/sf_event_mgt_indexer

Updates will be published on TER and packagist.

## Support

If you need commercial support or want to sponsor new features, please contact me directly by e-mail.