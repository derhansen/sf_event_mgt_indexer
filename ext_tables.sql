#
# Table structure for table 'tx_kesearch_indexerconfig'
#
CREATE TABLE tx_kesearch_indexerconfig (
	index_extsfeventmgt_event_restriction tinyint(4) DEFAULT '0' NOT NULL,
	index_extsfeventmgt_category_mode tinyint(4) DEFAULT '0' NOT NULL,
	index_extsfeventmgt_category_selection text,
);
