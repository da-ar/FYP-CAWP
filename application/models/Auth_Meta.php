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
     * @JoinTable(name="users_vs_interests")
     */
    private $Interests;
    
    /**
     * @ManyToMany(targetEntity="Service", inversedBy="Auth_Meta")
     * @JoinTable(name="users_vs_services")
     */
    private $Services;
    
    
    public function __construct() {
        $this->Interests = new ArrayCollection();
        $this->Services = new ArrayCollection();
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

    public function get_rfid_token() {
        return $this->rfid_token;
    }

    public function set_rfid_token($rfid_token) {
        $this->rfid_token = $rfid_token;
    }

    public function get_course() {
        return $this->course;
    }

    public function set_course($course) {
        $this->course = $course;
    }

    public function get_timetable() {
        return $this->timetable;
    }

    public function set_timetable($timetable) {
        $this->timetable = $timetable;
    }

    public function get_isAdmin() {
        return $this->isAdmin;
    }

    public function set_isAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }

    public function get_isServiceOwner() {
        return $this->isServiceOwner;
    }

    public function set_isServiceOwner($isServiceOwner) {
        $this->isServiceOwner = $isServiceOwner;
    }
    
    public function get_Interests() {
        return $this->Interests;
    }

    public function set_Interests($Interests) {
        $this->Interests = $Interests;
    }
    
    public function add_Interests(Interest $Interest){
        $this->Interests[] = $Interest;
    }

    public function get_Services() {
        return $this->Services;
    }

    public function set_Services($Services) {
        $this->Services = $Services;
    }
    
    public function add_Services(Service $Services){
        $this->Services[] = $Services;
    }


    
}

/* End of file Auth_Meta.php */
/* Location: ./application/models/Auth_Meta.php */
