<?php

/**
 * Users
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Users.php
 * @version		1.0
 * @date		01/24/2012
 * 
 * Copyright (c) 2012
 */
 
 namespace models;

 use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="user")
 */

class User {

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
     * @Column(type="string", length=10, nullable=false)
     */
    private $student_number;

    /**
     * @Column(type="string", length=10, nullable=false)
     */
    private $rfid_token;

    
 
}
/* End of file Users.php */
/* Location: ./application/models/Users.php */