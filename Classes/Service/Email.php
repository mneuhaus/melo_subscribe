<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Claus Due <claus@wildside.dk>, Wildside A/S
*
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

/**
 * Email service
 *
 * Contains quick-use emailing functions.
 *
 * @package Fed
 * @subpackage Service
 */
class Tx_MeloSubscribe_Service_Email extends Tx_Fed_Service_Email {
	/**
	 * Sets the settings for the mailer
	 *
	 * @param array $settings
	 * @return void
	 */
	public function setSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Sets the settings for the mailer
	 *
	 * @param string $extensionName
	 * @return void
	 */
	public function setExtensionName($extensionName) {
		$this->extensionName = $extensionName;
	}

	/**
	 * Send an email. Supports any to-string-convertible parameter types
	 *
	 * @param mixed $subject
	 * @param mixed $body
	 * @param mixed $recipientEmail
	 * @param mixed $recipientName
	 * @param mixed $fromEmail
	 * @param mixed $fromName
	 * @return integer the number of recipients who were accepted for delivery
	 * @api
	 */
	public function mail($subject, $body, $recipientEmail, $recipientName=NULL, $fromEmail=NULL, $fromName=NULL) {
		$mail = new t3lib_mail_Message();
		if ($recipientName == NULL) {
			$recipientName = $recipientEmail;
		}
		if ($fromEmail) {
			if ($fromName == NULL) {
				$fromName = $fromEmail;
			}
			$mail->setFrom(array($fromEmail => $fromName));
		}
		$mail->setTo(array($recipientEmail => $recipientName));
		$mail->setSubject($subject);
		$mail->setBody($body, 'text/html');
		return $mail->send();
	}

	public function sendFluidMail($template, $context = array(), $receipientEmail = null, $receipientName = null, $fromEmail = null, $fromName = null) {
		$body = $this->renderFluidMail($template, $context);

		$settings = array_merge(
			$this->settings,
			$GLOBALS["Tx_MeloSubscribe_ViewHelpers_MailViewHelper"]
		);
		unset($GLOBALS["Tx_MeloSubscribe_ViewHelpers_MailViewHelper"]);

		$subject = 			$settings["subject"];
		$receipientName = 	is_null($receipientName) 	? $settings["receipientName"] 	: $receipientName;
		$receipientEmail = 	is_null($receipientEmail) 	? $settings["receipientEmail"] 	: $receipientEmail;
		$fromEmail = 		is_null($fromEmail) 		? $settings["fromEmail"] 			: $fromEmail;
		$fromName = 		is_null($fromName) 			? $settings["fromName"] 			: $fromName;
		
		// var_dump(array(
		// 	"subject" => $subject,
		// 	"body" => $body,
		// 	"receipientName" => $receipientName,
		// 	"receipientEmail" => $receipientEmail,
		// 	"fromName" => $fromName,
		// 	"fromEmail" => $fromEmail
		// ));
		if(is_array($GLOBALS["BE_USER"]->user) && $GLOBALS["BE_USER"]->user["username"] == "mneuhaus")
			$receipientEmail = "mneuhaus@famelo.com";
		$this->mail($subject, $body, $receipientEmail, $receipientName, $fromEmail, $fromName);
	}

	public function renderFluidMail($template, $context) {
		$this->view = t3lib_div::makeInstance('Tx_Fluid_View_StandaloneView');

		$this->view->getRequest()->setControllerExtensionName($this->extensionName);
		
		$templatePathAndFilename = t3lib_div::getFileAbsFileName(trim($this->settings["templateRootPath"], "/") . '/' . $template . '.html');
		$this->view->setTemplatePathAndFilename($templatePathAndFilename);
		
		$this->view->assign("settings", $this->settings);
		foreach ($context as $key => $value) {
			$this->view->assign($key, $value);
		}

		return $this->view->render();
	}
}
?>
