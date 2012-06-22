<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
t3lib_extMgm::addStaticFile($_EXTKEY,'Configuration/TypoScript/', 'Subscribe');

Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY,'Subscribe','Subscribe');


// require_once(t3lib_extMgm::extPath("flux") . "/Classes/Core.php");
// require_once(t3lib_extMgm::extPath("flux") . "/Classes/Configuration/ConfigurationManager.php");
// require_once(t3lib_extMgm::extPath("flux") . "/Classes/Service/FlexForm.php");

$TCA['tt_content']['types']['list']['subtypes_addlist']['melosubscribe_subscribe'] = 'pi_flexform';
Tx_Flux_Core::registerFluidFlexFormPlugin(
    $_EXTKEY,
    'melosubscribe_subscribe',
    'EXT:melo_subscribe/Configuration/FlexForm/Subscribe.xml',
    array('section' => 'Configuration'), 
    'variable:section'
);

$tempColumns = array (
    'tx_melosubscribe_regular_mail' => array (        
        'exclude' => 0,        
        'label' => 'Werbung per Post',        
        'config' => array (
            'type' => 'check',
        )
    ),
    'tx_melosubscribe_branch' => array (        
        'exclude' => 0,        
        'label' => 'Branche',        
        'config' => array (
            'type' => 'input',    
            'size' => '30',
        )
    ),
    'tx_melosubscribe_token' => array (        
        'exclude' => 0,        
        'label' => 'Token',
        'config' => array (
            'type' => 'none',
        )
    ),
    'tx_melosubscribe_key_account' => array (        
        'exclude' => 0,        
        'label' => 'Key Account Manager',
        'config' => array (
            'type' => 'input',    
            'size' => '30',
        )
    ),
    'tx_melosubscribe_crdate' => array(        
        'exclude' => 0,        
        'label' => 'Erstellt am',
        'config' => array(
            'type' => 'none',
            'default' => date("d.m.y H:i:s"),
        )
    ),
);


t3lib_div::loadTCA('tt_address');
t3lib_extMgm::addTCAcolumns('tt_address',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('tt_address','tx_melosubscribe_regular_mail;;;;1-1-1, tx_melosubscribe_key_account, tx_melosubscribe_branch, tx_melosubscribe_token, tx_melosubscribe_crdate');


unset($GLOBALS['TCA']['tt_address']['ctrl']['enablecolumns']['hidden']);
unset($GLOBALS['TCA']['tt_address']['ctrl']['hidden']);


?>