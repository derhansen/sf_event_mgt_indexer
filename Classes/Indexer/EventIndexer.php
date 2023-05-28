<?php

namespace Derhansen\SfEventMgtIndexer\Indexer;

use DERHANSEN\SfEventMgt\Utility\PageUtility;
use Tpwd\KeSearch\Indexer\IndexerBase;
use Tpwd\KeSearch\Indexer\IndexerRunner;
use Tpwd\KeSearch\Lib\SearchHelper;
use TYPO3\CMS\Backend\Form\FormDataProvider\TcaSelectItems;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class EventIndexer
 */
class EventIndexer extends IndexerBase
{
    const TABLE = 'tx_sfeventmgt_domain_model_event';

    protected ConnectionPool $connectionPool;

    /**
     * Registers the indexer configuration
     */
    public function registerIndexerConfiguration(array &$params, TcaSelectItems $pObj): void
    {
        // add item to "type" field
        $newArray = [
            'Events (sf_event_mgt)',
            'sfeventmgt',
            GeneralUtility::getFileAbsFileName('EXT:sf_event_mgt_indexer/Resources/Public/Icons/Extension.svg')
        ];
        $params['items'][] = $newArray;
    }

    /**
     * sf_event_mgt indexer for ke_search
     */
    public function customIndexer(array &$indexerConfig, IndexerRunner $indexerObject): string
    {
        $this->connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);

        $content = '';
        if ($indexerConfig['type'] === 'sfeventmgt') {
            $indexPids = $this->getIndexerStoragePages($indexerConfig);
            if ($indexPids === '') {
                return '<p><b>Event Indexer "' . $indexerConfig['title'] . '" failed - Error: No storage Pids configured</b></p>';
            }

            $events = $this->getEvents($indexerConfig);

            $eventCount = 0;
            if (count($events)) {
                foreach ($events as $event) {
                    // Check if indexing of event should be skipped due to indexer category restriction
                    if (!$this->eventHasCategoryOfIndexerConfig($event['uid'], $indexerConfig)) {
                        continue;
                    }

                    $title = strip_tags($event['title']);
                    $teaser = strip_tags($event['teaser']);
                    $content = strip_tags($event['description']);
                    $program = strip_tags($event['program']);
                    $fullContent = $title . "\n" . $teaser . "\n" . $content . "\n" . $program;
                    $params = '&tx_sfeventmgt_pieventdetail[action]=detail&tx_sfeventmgt_pieventdetail[controller]=Event&tx_sfeventmgt_pieventdetail[event]=' . $event['uid'];
                    $tags = '#event#';

                    // Add system categories as tags
                    SearchHelper::makeSystemCategoryTags(
                        $tags,
                        $event['uid'],
                        self::TABLE
                    );

                    $additionalFields =[
                        'sortdate' => $event['crdate'],
                        'orig_uid' => $event['uid'],
                        'orig_pid' => $event['pid'],
                    ];

                    // Hook to modify/extend additional fields (e.g. if start- and enddate should be indexed)
                    if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sf_event_mgt_indexer']['modifyAdditionalFields'] ?? null)) {
                        foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sf_event_mgt_indexer']['modifyAdditionalFields'] as $_classRef) {
                            $_procObj = GeneralUtility::makeInstance($_classRef);
                            $_procObj->modifyAdditionalFields($additionalFields, $event);
                        }
                    }

                    // Hook to modify the fields 'title', 'fullContent' and 'teaser
                    if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sf_event_mgt_indexer']['modifyIndexContent'] ?? null)) {
                        foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sf_event_mgt_indexer']['modifyIndexContent'] as $_classRef) {
                            $_procObj = GeneralUtility::makeInstance($_classRef);
                            $_procObj->modifyIndexContent($title, $fullContent, $teaser, $event);
                        }
                    }

                    // ... and store the information in the index
                    $indexerObject->storeInIndex(
                        $indexerConfig['storagepid'], // storage PID
                        $title, // record title
                        'sfeventmgt', // content type
                        $indexerConfig['targetpid'], // target PID: where is the single view?
                        $fullContent, // indexed content, includes the title (linebreak after title)
                        $tags, // tags for faceted search
                        $params, // typolink params for singleview
                        $teaser, // abstract; shown in result list if not empty
                        $event['sys_language_uid'], // language uid
                        $event['starttime'], // starttime
                        $event['endtime'], // endtime
                        $event['fe_group'], // fe_group
                        false, // debug only?
                        $additionalFields // additionalFields
                    );

                    $eventCount++;
                }
                $content = '<p><b>Event Indexer "' . $indexerConfig['title'] . '":</b><br/>' . $eventCount .
                    ' Elements have been indexed.</p>';
            }
        }
        return $content;
    }

    /**
     * Returns events to be indexed
     */
    protected function getEvents(array $indexerConfig): array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE);

        $indexPids = GeneralUtility::intExplode(',', $this->getIndexerStoragePages($indexerConfig), true);

        $where = [];
        $where[] = $queryBuilder->expr()->in('pid', implode(',', $indexPids));

        // Evaluate event restriction
        if (isset($indexerConfig['index_extsfeventmgt_event_restriction'])) {
            switch ($indexerConfig['index_extsfeventmgt_event_restriction']) {
                case 1:
                    $where[] = $queryBuilder->expr()->gte('startdate', time());
                    break;
                case 2:
                    $where[] = $queryBuilder->expr()->lt('enddate', time());
                    break;
                default:
                    break;
            }
        }

        return $queryBuilder->select('*')
            ->from(self::TABLE)
            ->where(...$where)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * Returns all storage Pids for indexing
     */
    protected function getIndexerStoragePages(array $config): string
    {
        $recursivePids = PageUtility::extendPidListByChildren($config['startingpoints_recursive'], 99);
        if ($config['sysfolder']) {
            return $recursivePids . ',' . $config['sysfolder'];
        }

        return $recursivePids;
    }

    /**
     * Returns true, if event shall be indexed based on the indexer category_mode and category_selection
     */
    protected function eventHasCategoryOfIndexerConfig(int $eventUid, array $indexerConfig): bool
    {
        // If category restriction should be ignored, return true
        if ((int)$indexerConfig['index_extsfeventmgt_category_mode'] === 0) {
            return true;
        }

        // If no categories configured, the indexer might have been misconfigured, so we always return false
        if (!$indexerConfig['index_extsfeventmgt_category_selection']) {
            return false;
        }

        $includeCategoryUids = GeneralUtility::intExplode(
            ',',
            $indexerConfig['index_extsfeventmgt_category_selection']
        );
        $eventCategoryUids = $this->getEventCategoryUids($eventUid);
        foreach ($eventCategoryUids as $eventCategoryUid) {
            if (in_array($eventCategoryUid, $includeCategoryUids, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns an array of category uids assigned to the given event record
     */
    protected function getEventCategoryUids(int $eventUid): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_category')->createQueryBuilder();

        $where = [];
        $where[] = $queryBuilder->expr()->eq(
            'sys_category.uid',
            $queryBuilder->quoteIdentifier('sys_category_record_mm.uid_local')
        );
        $where[] = $queryBuilder->expr()->eq(
            self::TABLE . '.uid',
            $queryBuilder->quoteIdentifier('sys_category_record_mm.uid_foreign')
        );
        $where[] = $queryBuilder->expr()->eq(
            self::TABLE . '.uid',
            $queryBuilder->createNamedParameter($eventUid, \PDO::PARAM_INT)
        );
        $where[] = $queryBuilder->expr()->eq(
            'sys_category_record_mm.tablenames',
            $queryBuilder->createNamedParameter(self::TABLE, \PDO::PARAM_STR)
        );

        $catRes = $queryBuilder
            ->select('sys_category.uid')
            ->from('sys_category')
            ->from('sys_category_record_mm')
            ->from(self::TABLE)
            ->orderBy('sys_category_record_mm.sorting')
            ->where(...$where)
            ->executeQuery()
            ->fetchAllAssociative();

        $result = [];
        foreach ($catRes as $categoryUid) {
            $result[] = $categoryUid['uid'];
        }

        return $result;
    }
}
