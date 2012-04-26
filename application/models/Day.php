<?php

/**
 * Day
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Day.php
 * @version		1.0
 * @date		01/03/2012
 * 
 * Copyright (c) 2012
 */

namespace models;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="sch_Days")
 * 
 */

class Day {
    
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO")
     *  
     */
    private $id;
    
    /**
    * @Column(type="string", length=50, nullable=false)
    */
    private $name;
    
    /**
     * @ManyToMany(targetEntity="Schedule", mappedBy="Days")
     */
    private $Schedules;
    
    public function __construct(){
    }
    
    public function __get($property){
        return $this->$property;
    }  
    
    public function __set($property,$value){
        $this->$property = $value;
    }


   
   
}

/* End of file Day.php */
/* Location: ./application/models/Day.php */
