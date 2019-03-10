<?php

namespace Derhansen\SfEventMgtIndexer\Indexer;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class EventIndexer
 */
class EventIndexer
{
    const TABLE = 'tx_sfeventmgt_domain_model_event';

    /**
     * @var ConnectionPool
     */
    protected $connectionPool = null;

    /**
     * ProductIndexer constructor.
     */
    public function __construct()
    {
        $this->connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
    }

    /**
     * Registers the indexer configuration
     *
     * @param array $params
     * @param $pObj
     */
    public function registerIndexerConfiguration(&$params, $pObj)
    {
        // add item to "type" field
        $newArray = [
            'Events (sf_event_mgt)',
            'sfeventmgt',
            GeneralUtility::getFileAbsFileName('EXT:sf_event_mgt_indexer/ext_icon.svg')
        ];
        $params['items'][] = $newArray;
    }

    /**
     * sf_event_mgt indexer for ke_search
     *
     * @param array $indexerConfig Configuration from TYPO3 Backend
     * @param array $indexerObject Reference to indexer class.
     * @return string Output.
     */
    public function customIndexer(&$indexerConfig, &$indexerObject)
    {
        $content = '';
        if ($indexerConfig['type'] === 'sfeventmgt') {
            $indexPids = $this->getPidList($indexerConfig);
            if ($indexPids === '') {
                return '<p><b>Event Indexer "' . $indexerConfig['title'] . '" failed - Error: No storage Pids configured</b></p>';
            }

            $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE);
            $events = $queryBuilder->select('*')->from(self::TABLE)->execute()->fetchAll();

            $eventCount = count($events);
            if ($eventCount) {
                foreach ($events as $event) {
                    // compile the information which should go into the index
                    // the field names depend on the table you want to index!
                    $title = strip_tags($event['title']);
                    $teaser = strip_tags($event['teaser']);
                    $content = strip_tags($event['description']);
                    $program = strip_tags($event['$program']);
                    $fullContent = $title . "\n" . $teaser . "\n" . $content . "\n" . $program;
                    $params = '&tx_sfeventmgt_pievent[action]=detail&tx_sfeventmgt_pievent[controller]=Event&tx_sfeventmgt_pievent[event]=' . $event['uid'];
                    $tags = '#event#';
                    $additionalFields = array(
                        'sortdate' => $event['crdate'],
                        'orig_uid' => $event['uid'],
                        'orig_pid' => $event['pid'],
                    );

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
                }
                $content = '<p><b>Event Indexer "' . $indexerConfig['title'] . '":</b><br/>' . $eventCount .
                    ' Elements have been indexed.</p>';
            }
        }
        return $content;
    }

    /**
     * Returns all storage Pids for indexing
     *
     * @param $config
     * @return string
     */
    protected function getPidList($config)
    {
        $recursivePids = $this->extendPidListByChildren($config['startingpoints_recursive'], 99);
        if ($config['sysfolder']) {
            return $recursivePids . ',' . $config['sysfolder'];
        } else {
            return $recursivePids;
        }
    }

    /**
     * Find all ids from given ids and level
     *
     * @param string $pidList comma separated list of ids
     * @param integer $recursive recursive levels
     * @return string comma separated list of ids
     */
    protected function extendPidListByChildren($pidList = '', $recursive = 0)
    {
        $recursive = (int)$recursive;

        if ($recursive <= 0) {
            return $pidList;
        }

        $queryGenerator = GeneralUtility::makeInstance(QueryGenerator::class);
        $recursiveStoragePids = $pidList;
        $storagePids = GeneralUtility::intExplode(',', $pidList);
        foreach ($storagePids as $startPid) {
            $pids = $queryGenerator->getTreeList($startPid, $recursive, 0, 1);
            if (strlen($pids) > 0) {
                $recursiveStoragePids .= ',' . $pids;
            }
        }
        return $recursiveStoragePids;
    }
}