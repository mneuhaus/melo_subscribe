<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Georg Schönweger <georg.schoenweger@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
class Tx_MeloSubscribe_Domain_Repository_CategoryRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Findet alle Kategorien innerhalb $pid
	 * @param Array $pid
	 */
	public function findByPid(Array $pids) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setStoragePageIds($pids);
		return ($query->execute());
	} 

	public function findByUids($uidArray) {
		if(is_array($uidArray)) {
			$query = $this->createQuery();
			$query->getQuerySettings()->setRespectStoragePage(FALSE);			
			$inArr = Array();
			foreach ($uidArray as $key => $uid) {
				if($uid > 0) {
					$inArr[] = $uid;
				}
			}
			if(count($inArr) > 0) {
				$query->matching($query->in('uid',$inArr));
				return ($query->execute());
			}
		}
		return (NULL);
	}

}
?>
