<?php

/**
 * Schedule
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Schedule.php
 * @version		1.0
 * @date		01/03/2012
 * 
 * Copyright (c) 2012
 */

namespace models;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="schedules")
 * 
 */

class Schedule {
    
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO")
     *  
     */
    private $id;
    
    /**
    * @Column(type="date")
    */
    private $start_date;
    
    /**
    * @Column(type="date", nullable=true)
    */
    private $end_date;
    
    /**
    * @Column(type="time")
    */
    private $start_time;
    
    /**
    * @Column(type="time")
    */
    private $end_time;
    
    /**
    * @Column(type="boolean")
    */
    private $mon;
    
    /**
    * @Column(type="boolean")
    */
    private $tues;
    
    /**
    * @Column(type="boolean")
    */
    private $weds;
    
    /**
    * @Column(type="boolean")
    */
    private $thurs;
    
    /**
    * @Column(type="boolean")
    */
    private $fri;
    
    /**
    * @Column(type="boolean")
    */
    private $sat;
    
    /**
    * @Column(type="boolean")
    */
    private $sun;
    
    /**
    * @Column(type="boolean")
    */
    private $isRecuring;
    
    /**
     * @ManyToOne(targetEntity="Service", cascade={"persist"})
     * @JoinColumn(name="service_id", referencedColumnName="id")
     *   
     */
    private $Service;
    
    
    public function __construct(){
      $this->Service = new ArrayCollection();
      // default values
      $this->mon = false;
      $this->tues = false;
      $this->weds = false;
      $this->thurs = false;
      $this->fri = false;
      $this->sat = false;
      $this->sun = false;
      
    }
    
    public function __get($property){
        return $this->$property;
    }  
    
    public function __set($property,$value){
        $this->$property = $value;
    }


   
   
}

/* End of file Location.php */
/* Location: ./application/models/Location.php */
