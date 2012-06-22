<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Patrick Lobacher <patrick.lobacher@typovision.de>
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
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_MeloSubscribe_Controller_SubscribeController extends Tx_Extbase_MVC_Controller_ActionController {

    /**
     * @var Tx_MeloSubscribe_Service_Email
     */
    protected $emailService;
     
    /**
     * @param Tx_MeloSubscribe_Service_Email $emailService
     */
    public function injectEmailService(Tx_MeloSubscribe_Service_Email $emailService) {
        $this->emailService = $emailService;
    }

    /**
     * @var Tx_MeloSubscribe_Domain_Repository_AddressRepository
     */
    protected $addressRepository;
     
    /**
     * @param Tx_MeloSubscribe_Domain_Repository_AddressRepository $addressRepository
     */
    public function injectAddressRepository(Tx_MeloSubscribe_Domain_Repository_AddressRepository $addressRepository) {
        $this->addressRepository = $addressRepository;
    }
    
    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction() {
        $this->emailService->setSettings($this->settings["mail"]);
        $this->emailService->setExtensionName($this->extensionName);
    }
    
    /**
     * Index action for this controller.
     *
     * @param Tx_MeloSubscribe_Domain_Model_Address $address
     * @return string The rendered view
     * @dontvalidate $address
     */
    public function indexAction(Tx_MeloSubscribe_Domain_Model_Address $address = null) {
        switch ($this->settings["defaultAction"]) {
            case 'Abmelden': $this->forward("unsubscribe"); break;
            case 'Manueller Eintrag': $this->forward("manual"); break;
        }

        $address = t3lib_div::makeInstance("Tx_MeloSubscribe_Domain_Model_Address");
        $this->view->assign("address", $address);
        $dmailCategoryRepository = t3lib_div::makeInstance('Tx_MeloSubscribe_Domain_Repository_CategoryRepository');
        $categories = $dmailCategoryRepository->findByPid(explode(',', $this->settings['module_sys_dmail_category_PIDLIST']));
        #foreach ($categories as $category) {
        #    $category->setChecked(true);
        #}
        $this->view->assign("categories", $categories);

        $categories = $dmailCategoryRepository->findByPid(explode(',', $this->settings['module_sys_dmail_language_category_PIDLIST']));
        foreach ($categories as $key => $category) {
            if($GLOBALS['TSFE']->sys_language_uid == 0 && $category->getCategory() == "Deutsch")
                $category->setChecked(true);
            
            if($GLOBALS['TSFE']->sys_language_uid == 1 && $category->getCategory() == "English")
                $category->setChecked(true);
        }
        $this->view->assign("languageCategories", $categories);

        if(!is_null($address)){
            $this->view->assign($address);
        }
    }

    public function manualAction() {
        $address = t3lib_div::makeInstance("Tx_MeloSubscribe_Domain_Model_Address");
        $this->view->assign("address", $address);
        $dmailCategoryRepository = t3lib_div::makeInstance('Tx_MeloSubscribe_Domain_Repository_CategoryRepository');
        $categories = $dmailCategoryRepository->findByPid(explode(',', $this->settings['module_sys_dmail_category_PIDLIST']));
        $this->view->assign("categories", $categories);

        $categories = $dmailCategoryRepository->findByPid(explode(',', $this->settings['module_sys_dmail_language_category_PIDLIST']));
        foreach ($categories as $key => $category) {
            if($GLOBALS['TSFE']->sys_language_uid == 0 && $category->getCategory() == "Deutsch")
                $category->setChecked(true);
            
            if($GLOBALS['TSFE']->sys_language_uid == 1 && $category->getCategory() == "English")
                $category->setChecked(true);
        }
        $this->view->assign("languageCategories", $categories);
    }
    
    /**
     *
     * @param Tx_MeloSubscribe_Domain_Model_Address $address
     * @param boolean $doubleOptInOverride
     * @return string The rendered view
     */
    public function subscribeAction(Tx_MeloSubscribe_Domain_Model_Address $address, $doubleOptInOverride = false) {
        if(is_object($this->addressRepository->findEmail((string) $address->getEmail()))){
            $this->forward("alreadySubscribed");
        }

        $this->view->assign("doubleOptInOverride", $doubleOptInOverride);

        $this->addressRepository->add($address);
        if(!$doubleOptInOverride)
            $address->setHidden(true);
        $address->getToken();
        $address->setName($address->getFirstName() . " " . $address->getLastName());
        $persistenceManager = Tx_Extbase_Dispatcher::getPersistenceManager();
        $persistenceManager->persistAll();

        if($this->request->hasArgument("moduleSysDmailCategory")){
            $dmailCategoryRepository = t3lib_div::makeInstance('Tx_MeloSubscribe_Domain_Repository_CategoryRepository');
            $categories = $dmailCategoryRepository->findByUids($this->request->getArgument("moduleSysDmailCategory"));
            if(count($categories) > 0) {
                $address->addAllModuleSysDmailCategory($categories);
            }
        }
        $this->view->assign("address", $address);

        $lang = $GLOBALS['TSFE']->config['config']['language'];
        foreach ($categories as $category) {
            #if($category->getCategory() == "Deutsch")
            #    $GLOBALS['TSFE']->config['config']['language'] = 0;
            
            if($category->getCategory() == "English")
                $GLOBALS['TSFE']->config['config']['language'] = 1;
        }

        if(!$doubleOptInOverride){
            $this->emailService->sendFluidMail("Subscribe", array(
               "address" => $address,
               "language" => $GLOBALS['TSFE']->config['config']['language']
            ));
        } else{
            $this->emailService->sendFluidMail("Activate", array(
               "address" => $address,
               "language" => $GLOBALS['TSFE']->config['config']['language']
            ));
        }
        if(!$doubleOptInOverride){
            $this->emailService->sendFluidMail("SubscribeAdmin", array(
               "address" => $address,
               "receipient" => $this->settings["adminEmail"],
               "language" => $GLOBALS['TSFE']->config['config']['language']
            ));
        } else {
            $this->emailService->sendFluidMail("ManualAdmin", array(
               "address" => $address,
               "receipient" => $this->settings["adminEmail"],
               "language" => $GLOBALS['TSFE']->config['config']['language']
            ));
        }
        $GLOBALS['TSFE']->config['config']['language'] = $lang;
    }

    /**
     *
     * @param string $email
     * @param boolean $confirm
     * @return string The rendered view
     */
    public function unsubscribeAction($email = null, $confirm = false) {
        if(!is_null($email)){
            $this->view->assign("email", $email);
            $address = $this->addressRepository->findOneByEmail($email);
            
            // $lang = $GLOBALS['TSFE']->config['config']['language'];
            // foreach ($address->getModuleSysDmailCategory as $category) {
            //     if($category->getCategory() == "Deutsch")
            //         $GLOBALS['TSFE']->config['config']['language'] = 0;
                
            //     if($category->getCategory() == "English")
            //         $GLOBALS['TSFE']->config['config']['language'] = 1;
            // }
            
            if(is_object($address)){
                $this->emailService->sendFluidMail("Edit", array(
                   "address" => $address
                ));
                $this->view->assign("address", $address);
            }else{
                $this->flashMessageContainer->add('Die E-Mail "' . $email . '" wurde nicht gefunden');
            }
        }
    }
    
    /**
     *
     * @return string The rendered view
     */
    public function unsubscribedAction() {
    }

    /**
     *
     * @param integer $address
     * @param string $token
     * @return string The rendered view
     */
    public function cancelAction($address, $token) {
        $address = $this->addressRepository->findByUid($address);
        if($address->getToken() == $token){
            $this->view->assign("address", $address);
            $address->setHidden(true);
            $this->addressRepository->remove($address);
        }
    }

    /**
     *
     * @param integer $address
     * @param string $token
     * @return string The rendered view
     */
    public function editAction($address, $token) {
        $address = $this->addressRepository->findByUid($address);
        if($address->getToken() == $token){
            $this->view->assign("address", $address);
        }
    }

    /**
     *
     * @param Tx_MeloSubscribe_Domain_Model_Address $address
     * @return string The rendered view
     */
    public function saveAction(Tx_MeloSubscribe_Domain_Model_Address $address) {
        $this->addressRepository->update($address);
    }

    /**
     *
     * @param integer $address
     * @param string $token
     * @return string The rendered view
     */
    public function activateAction($address, $token) {
        $address = $this->addressRepository->findByUid($address);
        if($address->getToken() == $token){
            $address->setHidden(false);
            $this->addressRepository->update($address);
        }
        $this->view->assign("address", $address);

        $this->emailService->sendFluidMail("Activate", array(
           "address" => $address
        ));

        $this->emailService->sendFluidMail("ActivateAdmin", array(
           "address" => $address,
           "receipient" => $this->settings["adminEmail"]
        ));
    }

    /**
     * @return string The rendered view
     */
    public function alreadySubscribedAction() {
        
    }
}

?>