<?php

/**
 * Auth_User
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Auth_User.php
 * @version		1.0
 * @date		01/03/2012
 * 
 * Copyright (c) 2012
 */

namespace models;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Repositories\Auth_User_Repository")
 * @Table(name="auth_users",indexes={@index(name="email_idx", columns={"email"})})
 * 
 */

class Auth_User {
    
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO")
     *  
     */
    private $id;
    
    /**
     * @Column(type="integer", nullable=false)
     */
    private $group_id;
    
    /**
    * @Column(type="string", length=16, nullable=true)
    */
    private $ip_address;
    
    /**
    * @Column(type="string", length=15, nullable=false)
    */
    private $username;
    
    /**
    * @Column(type="string", length=40, nullable=true)
    */
    private $password;
    
    /**
    * @Column(type="string", length=40, nullable=true)
    */
    private $salt;
    
    /**
    * @Column(type="string", length=254, nullable=false)
    */
    private $email;
    
    /**
    * @Column(type="string", length=40, nullable=true)
    */
    private $activation_code;
    
    /**
    * @Column(type="string", length=40, nullable=true)
    */
    private $forgotten_password_code;
    
    /**
    * @Column(type="string", length=40, nullable=true)
    */
    private $remember_code;
    
    /**
    * @Column(type="integer", nullable=false)
    */
    private $created_on;
    
    /**
    * @Column(type="integer", nullable=true)
    */
    private $last_login;
    
    /**
    * @Column(type="smallint", nullable=true)
    */
    private $active;
    
    /**
     * @ManyToOne(targetEntity="Auth_Group")
     * @JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $Auth_Group;
    
    /**
     * @ManyToOne(targetEntity="Auth_Meta")
     * @JoinColumn(name="meta_id", referencedColumnName="id")
     */
    private $Auth_Meta;
    
    public function get_id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function get_group_id() {
        return $this->group_id;
    }

    public function set_group_id($group_id) {
        $this->group_id = $group_id;
    }

    public function get_ip_address() {
        return $this->ip_address;
    }

    public function set_ip_address($ip_address) {
        $this->ip_address = $ip_address;
    }

    public function get_username() {
        return $this->username;
    }

    public function set_username($username) {
        $this->username = $username;
    }

    public function get_password() {
        return $this->password;
    }

    public function set_password($password) {
        $this->password = $password;
    }

    public function get_salt() {
        return $this->salt;
    }

    public function set_salt($salt) {
        $this->salt = $salt;
    }

    public function get_email() {
        return $this->email;
    }

    public function set_email($email) {
        $this->email = $email;
    }

    public function get_activation_code() {
        return $this->activation_code;
    }

    public function set_activation_code($activation_code) {
        $this->activation_code = $activation_code;
    }

    public function get_forgotten_password_code() {
        return $this->forgotten_password_code;
    }

    public function set_forgotten_password_code($forgotten_password_code) {
        $this->forgotten_password_code = $forgotten_password_code;
    }

    public function get_remember_code() {
        return $this->remember_code;
    }

    public function set_remember_code($remember_code) {
        $this->remember_code = $remember_code;
    }

    public function get_created_on() {
        return $this->created_on;
    }

    public function set_created_on($created_on) {
        $this->created_on = $created_on;
    }

    public function get_last_login() {
        return $this->last_login;
    }

    public function set_last_login($last_login) {
        $this->last_login = $last_login;
    }

    public function get_active() {
        return $this->active;
    }

    public function set_active($active) {
        $this->active = $active;
    }

    public function get_Auth_Group() {
        return $this->Auth_Group;
    }

    public function set_Auth_Group($Auth_Group) {
        $this->Auth_Group = $Auth_Group;
    }

    public function get_Auth_Meta() {
        return $this->Auth_Meta;
    }

    public function set_Auth_Meta($Auth_Meta) {
        $this->Auth_Meta = $Auth_Meta;
    }
   
}

namespace Repositories;
use Doctrine\ORM\EntityRepository;

class Auth_User_Repository extends EntityRepository
{
    public function get_Admin_Users()
    {
        return $this->_em->createQuery("SELECT u.email, u.id FROM models\Auth_User u JOIN
                                                      u.Auth_Group g
                                        WHERE g.name = 'admin'")->getResult();
    }
    
    public function get_Branch_Users()
    {
        return $this->_em->createQuery("SELECT u.email, u.id FROM models\Auth_User u JOIN
                                                      u.Auth_Group g
                                            WHERE g.name = 'branch'")->getResult();
    }
    
}

/* End of file Auth_User.php */
/* Location: ./application/models/Auth_User.php */
