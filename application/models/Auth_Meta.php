<?php


/**
 * Auth_Meta
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Auth_Meta.php
 * @version		1.0
 * @date		01/03/2012
 * 
 * Copyright (c) 2012
 */

namespace models;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity
 * @Table(name="auth_meta")
 * 
 */

class Auth_Meta {
    
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO")
     *  
     */
    private $id;
    
    /**
    * @Column(type="string", length=50, nullable=true)
    */
    private $name;
    
    /**
    * @Column(type="string", length=50, nullable=true)
    */
    private $rfid_token;
    
    /**
    * @Column(type="string", length=255, nullable=true)
    */
    private $course;
    
    /**
    * @Column(type="string", length=255, nullable=true)
    */
    private $timetable;
    
    /**
    * @Column(type="boolean")
    */
    private $isAdmin;
    
    /**
    * @Column(type="boolean")
    */
    private $isServiceOwner;
    
    /**
     * @ManyToMany(targetEntity="Interest", inversedBy="Auth_Meta")
     */
    private $Interests;
    
    /**
     * @ManyToMany(targetEntity="Service", inversedBy="Auth_Meta")
     */
    private $Services;
    
    
    public function __construct() {
        $this->Interests = new ArrayCollection();
        $this->Services = new ArrayCollection();
    }
    
    
    public function __get($property){
        return $this->$property;
    }  
    
    public function __set($property,$value){
        $this->$property = $value;
    }


    
}

/* End of file Auth_Meta.php */
/* Location: ./application/models/Auth_Meta.php */
