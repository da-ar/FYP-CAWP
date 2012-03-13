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
    
    public function get_id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function get_name() {
        return $this->name;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function get_description() {
        return $this->description;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    public function get_Auth_User() {
        return $this->auth_user;
    }

    public function set_Auth_User($auth_user) {
        $this->auth_user = $auth_user;
    }
    
    public function add_Auth_User(Auth_User $Auth_User){
        $this->Auth_Users[] = $Auth_User;
    }
    
    public function get_Auth_Users(){
        return $this->Auth_Users->toArray();
    }

    
}

/* End of file Auth_Group.php */
/* Location: ./application/models/Auth_Group.php */
