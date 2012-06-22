#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (
    tx_melosubscribe_regular_mail tinyint(3) DEFAULT '0' NOT NULL,
    tx_melosubscribe_branch tinytext,
    tx_melosubscribe_token tinytext,
    tx_melosubscribe_key_account tinytext,
    tx_melosubscribe_crdate tinytext,
);