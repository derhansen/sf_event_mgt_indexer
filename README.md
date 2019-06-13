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

This hook can be used to modify/extend the additionalFields value (e.g., if it is required
to index additional event properties like start- and enddate) 

## Feedback and updates

This extension is hosted in GitHub. Please report feedback, bugs and change requests directly at 
https://github.com/derhansen/sf_event_mgt_indexer

Updates will be published on TER and packagist.

## Support

If you need commercial support or want to sponsor new features, please contact me directly by e-mail.