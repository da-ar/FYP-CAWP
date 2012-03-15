<?php

/**
 * Auth_Group
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Auth_Group.php
 * @version		1.0
 * @date		01/03/2012
 * 
 * Copyright (c) 2012
 */

namespace models;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity
 * @Table(name="auth_groups")
 * 
 */
class Auth_Group {
    
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO")
     *  
     */
    private $id;
    
    /**
     * @Column(type="string", length=20, nullable=false)
     */
    private $name;
    
    /**
     * @Column(type="string", length=100, nullable=false)
     */
    private $description;
    
    /**
     * @OneToMany(targetEntity="Auth_User", mappedBy="Auth_Group")  
     * 
     */
    private $Auth_Users;
    
    public function __construct(){
      $this->Auth_Users = new ArrayCollection();
    }
    
    public function __get($property){
        return $this->$property;
    }  
    
    public function __set($property,$value){
        $this->$property = $value;
    }

    
}

/* End of file Auth_Group.php */
/* Location: ./application/models/Auth_Group.php */
