<?php

/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */
class Tx_MeloSubscribe_ViewHelpers_MailViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractConditionViewHelper {
	/**
	 * Initialize arguments
	 */
	public function initializeArguments() {
		$this->registerArgument('subject', 'string', 'Subject for the E-Mail', TRUE);
		$this->registerArgument('fromName', 'string', '', FALSE, NULL);
		$this->registerArgument('fromEmail', 'string', '', FALSE, NULL);
		$this->registerArgument('receipientName', 'string', '', FALSE, NULL);
		$this->registerArgument('receipientEmail', 'string', '', FALSE, NULL);
	}

	/**
	 *
	 * @return string the rendered string
	 * @api
	 */
	public function render() {
		$GLOBALS["Tx_MeloSubscribe_ViewHelpers_MailViewHelper"] = array();
		$keys = array("subject", "fromName", "fromEmail", "receipientName", "receipientEmail");
		foreach ($keys as $key) {
			$value = $this->arguments[$key];
			if(!is_null($value))
				$GLOBALS["Tx_MeloSubscribe_ViewHelpers_MailViewHelper"][$key] = $value;
		}
	}
}
?>
