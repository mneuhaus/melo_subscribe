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
class Tx_MeloSubscribe_Domain_Model_Address extends Tx_Extbase_DomainObject_AbstractEntity {
    /**
     * My awesome Address
     *
     * @var string
     **/
    protected $address;
    
    /**
     * My awesome Branch
     *
     * @var string
     **/
    protected $branch;
    
    /**
     * My awesome City
     *
     * @var string
     **/
    protected $city;
    
    /**
     * My awesome Company
     *
     * @var string
     **/
    protected $company;
    
    /**
     * My awesome Email
     *
     * @var string
     * @validate EmailAddress
     **/
    protected $email;
    
    /**
     * My awesome FirstName
     *
     * @var string
     **/
    protected $firstName;
    
    /**
     * My awesome Gender
     *
     * @var string
     **/
    protected $gender;
    
    /**
     * My awesome Hidden
     *
     * @var boolean
     **/
    protected $hidden = false;

    /**
     * My awesome Deleted
     *
     * @var boolean
     **/
    protected $deleted = false;
    
    /**
     * My awesome LastName
     *
     * @var string
     **/
    protected $lastName;
    
    /**
     * My awesome Name
     *
     * @var string
     **/
    protected $name;
    
    /**
     * My awesome Phone
     *
     * @var string
     **/
    protected $phone;
    
    /**
     * My awesome RegularMail
     *
     * @var boolean
     **/
    protected $regularMail = false;
    
    /**
     * My awesome Token
     *
     * @var string
     **/
    protected $token;
    
    /**
     * My awesome Zip
     *
     * @var string
     **/
    protected $zip;

    /**
     * @var Tx_Extbase_Persistence_ObjectStorage<Tx_MeloSubscribe_Domain_Model_Category>
     * @lazy
     */
    protected $moduleSysDmailCategory;
    
    public function __construct() {
        $this->setModuleSysDmailCategory(new Tx_Extbase_Persistence_ObjectStorage);
        $this->crdate = date("d.m.y H:i:s");
    }

    /**
     * Getter for address
     *
     * @return string
     **/
    public function getAddress() {
        return $this->address;
    } 
    
    /**
     * Getter for branch
     *
     * @return string
     **/
    public function getBranch() {
        return $this->branch;
    } 
    
    /**
     * Getter for city
     *
     * @return string
     **/
    public function getCity() {
        return $this->city;
    } 
    
    /**
     * Getter for company
     *
     * @return string
     **/
    public function getCompany() {
        return $this->company;
    } 
    
    /**
     * Getter for email
     *
     * @return string
     **/
    public function getEmail() {
        return $this->email;
    } 
    
    /**
     * Getter for firstName
     *
     * @return string
     **/
    public function getFirstName() {
        return $this->firstName;
    } 
    
    /**
     * Getter for gender
     *
     * @return string
     **/
    public function getGender() {
        return $this->gender;
    } 
    
    /**
     * Getter for hidden
     *
     * @return boolean
     **/
    public function getHidden() {
        return $this->hidden;
    } 

    /**
     * Getter for deleted
     *
     * @return boolean
     **/
    public function getDeleted() {
        return $this->deleted;
    } 
    
    /**
     * Getter for lastName
     *
     * @return string
     **/
    public function getLastName() {
        return $this->lastName;
    } 
    
    /**
     * Getter for name
     *
     * @return string
     **/
    public function getName() {
        return $this->name;
    } 
    
    /**
     * Getter for phone
     *
     * @return string
     **/
    public function getPhone() {
        return $this->phone;
    } 
    
    /**
     * Getter for regularMail
     *
     * @return boolean
     **/
    public function getRegularMail() {
        return $this->regularMail;
    } 
    
    /**
     * Getter for token
     *
     * @return string
     **/
    public function getToken() {
        if(empty($this->token))
            $this->token = sha1($this->uid . time() . $GLOBALS["TYPO3_CONF_VARS"]['SYS']['encryptionKey']);
        return $this->token;
    } 
    
    /**
     * Getter for zip
     *
     * @return string
     **/
    public function getZip() {
        return $this->zip;
    } 
    
    /**
     * Setter for address
     *
     * @param string $address
     **/
    public function setAddress($address) {
        $this->address = $address;
    } 
    
    /**
     * Setter for branch
     *
     * @param string $branch
     **/
    public function setBranch($branch) {
        $this->branch = $branch;
    } 
    
    /**
     * Setter for city
     *
     * @param string $city
     **/
    public function setCity($city) {
        $this->city = $city;
    } 
    
    /**
     * Setter for company
     *
     * @param string $company
     **/
    public function setCompany($company) {
        $this->company = $company;
    } 
    
    /**
     * Setter for email
     *
     * @param string $email
     **/
    public function setEmail($email) {
        $this->email = $email;
    } 
    
    /**
     * Setter for firstName
     *
     * @param string $firstName
     **/
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    } 
    
    /**
     * Setter for gender
     *
     * @param string $gender
     **/
    public function setGender($gender) {
        $this->gender = $gender;
    } 
    
    /**
     * Setter for hidden
     *
     * @param boolean $hidden
     **/
    public function setHidden($hidden) {
        $this->hidden = $hidden;
    } 

    /**
     * Setter for deleted
     *
     * @param boolean $deleted
     **/
    public function setDeleted($deleted) {
        $this->deleted = $deleted;
    } 
    
    /**
     * Setter for lastName
     *
     * @param string $lastName
     **/
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    } 
    
    /**
     * Setter for name
     *
     * @param string $name
     **/
    public function setName($name) {
        $this->name = $name;
    } 
    
    /**
     * Setter for phone
     *
     * @param string $phone
     **/
    public function setPhone($phone) {
        $this->phone = $phone;
    } 
    
    /**
     * Setter for regularMail
     *
     * @param boolean $regularMail
     **/
    public function setRegularMail($regularMail) {
        $this->regularMail = $regularMail;
    } 
    
    /**
     * Setter for token
     *
     * @param string $token
     **/
    public function setToken($token) {
        $this->token = $token;
    } 
    
    /**
     * Setter for zip
     *
     * @param string $zip
     **/
    public function setZip($zip) {
        $this->zip = $zip;
    }

    /**
     * @return Tx_Extbase_Persistence_ObjectStorage<Tx_MeloSubscribe_Domain_Model_Category>
     */
    public function getModuleSysDmailCategory() {
        return clone $this->moduleSysDmailCategory;
    }

    /**
     * @param Tx_Extbase_Persistence_ObjectStorage<Tx_MeloSubscribe_Domain_Model_Category> $moduleSysDmailCategory
     */
    public function setModuleSysDmailCategory(Tx_Extbase_Persistence_ObjectStorage $moduleSysDmailCategory) {
        $this->moduleSysDmailCategory = $moduleSysDmailCategory;
    }

    /**
     * Adds a category
     *
     * @param Tx_SjrOffers_Domain_Model_Category The category to be added
     * @return void
     */
    public function addModuleSysDmailCategory(Tx_MeloSubscribe_Domain_Model_Category $moduleSysDmailCategory) {
        $this->moduleSysDmailCategory->attach($moduleSysDmailCategory);
    }

    /**
     * Remove a category from the offer
     *
     * @param Tx_SjrOffers_Domain_Model_Category The category to be removed
     * @return void
     */
    public function removeModuleSysDmailCategory(Tx_MeloSubscribe_Domain_Model_Category $moduleSysDmailCategory) {
        $this->moduleSysDmailCategory->detach($moduleSysDmailCategory);
    }

    /**
     * Removes all Categorys from current record
     */
    public function removeAllModuleSysDmailCategory() {
        // ACHTUNG: Schleife funkt nur da clone $categories --> siehe http://forge.typo3.org/issues/13147
        foreach ($this->getModuleSysDmailCategory() as $item) {
            $this->removeModuleSysDmailCategory($item);
        }
    }

    /**
     * Fügt alle Category-Objekte welche QueryResult beinhaltet hinzu
     * @param Tx_Extbase_Persistence_QueryResult $categories
     */
    public function addAllModuleSysDmailCategory(Tx_Extbase_Persistence_QueryResult $categories) {
        foreach ($categories as $category) {
            $this->addModuleSysDmailCategory($category);
        }
    }

    public function getCategoryList() {
        $categories = array();
        foreach ($this->moduleSysDmailCategory as $category) {
            $categories[]= $category->getCategory();
        }
        return implode(",", $categories);
    }

    /**
     * The keyAccount
     * 
     * @var string
     */
    protected $keyAccount;
    
    /**
     * @param string $keyAccount
     */
    public function setKeyAccount($keyAccount) {
        $this->keyAccount = $keyAccount;
    }
    
    /**
     * @return string
     */
    public function getKeyAccount() {
        return $this->keyAccount;
    }

    /**
     * The crdate
     * 
     * @var string
     */
    protected $crdate;
    
    /**
     * @param string $crdate
     */
    public function setCrdate($crdate) {
        $this->crdate = $crdate;
    }
    
    /**
     * @return string
     */
    public function getCrdate() {
        return $this->crdate;
    }
}
?>