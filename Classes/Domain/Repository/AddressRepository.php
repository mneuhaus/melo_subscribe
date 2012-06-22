<?php

/***************************************************************
 *  Copyright notice
 *
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package melo_subscribe
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_MeloSubscribe_Domain_Repository_AddressRepository extends Tx_Extbase_Persistence_Repository {
	public function createQuery() {
		$query = parent::createQuery();
		$query->getQuerySettings()->setRespectEnableFields(false);
		return $query;
	}

	/**
	 * Sucht in tt_address nach $email.
	 * Normale Extbase PID Einstellungen (storagePid) greifen für tt_address Datensätze. Es kann somit nicht zu Konflikt mit anderen Extensions kommen kann die auch tt_address verwenden ...
	 * @param boolean $enableFields falls FALSE dann wird nur deleted=0 berücksichtigt (hidden wird ignoriert)
	 * @return object
	 */
	public function findEmail($email,$enableFields=TRUE,$getFirst=TRUE) {
		#$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['sni_newsletter_subscription']);
		$query = $this->createQuery();		
		$query->getQuerySettings()->setRespectEnableFields(true);
		$constraints = array();
		#if(!$extConf['checkForPid']) {
		#	$query->getQuerySettings()->setRespectStoragePage(FALSE);
		#}
		#if(!$enableFields) {
		#	$query->getQuerySettings()->setRespectEnableFields(FALSE);
		#	$constraints[] = $query->equals('deleted', 0);
		#}
		$constraints[] = $query->equals('email',$email);
		$query->matching($query->logicalAnd($constraints));
		if($getFirst) {
			return ($query->execute()->getFirst());
		}
		else {
			return ($query->execute());
		}
	}
}

?>