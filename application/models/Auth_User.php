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
     * @ManyToOne(targetEntity="Auth_Group", cascade={"persist"})
     * @JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $Auth_Group;
    
    /**
     * @ManyToOne(targetEntity="Auth_Meta", cascade={"persist"})
     * @JoinColumn(name="meta_id", referencedColumnName="id")
     */
    private $Auth_Meta;
    
    public function __construct() {
    }    
    
    public function __get($property){
        return $this->$property;
    }  
    
    public function __set($property,$value){
        $this->$property = $value;
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
    
    public function get_Service_Users()
    {
        return $this->_em->createQuery("SELECT u.email, u.id FROM models\Auth_User u JOIN
                                                      u.Auth_Group g
                                            WHERE g.name = 'service_user'")->getResult();
    }
    
    public function get_Users()
    {
        return $this->_em->createQuery("SELECT u.email, u.id FROM models\Auth_User u JOIN
                                                      u.Auth_Group g
                                            WHERE g.name = 'student_user'")->getResult();
    }
    
}

/* End of file Auth_User.php */
/* Location: ./application/models/Auth_User.php */
