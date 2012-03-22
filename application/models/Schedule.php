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
     * @ManyToMany(targetEntity="Day", inversedBy="Schedule")
     * @JoinTable(name="schedule_day",
     *      joinColumns={@JoinColumn(name="schedule_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="day_id", referencedColumnName="id")})
     */
    private $Days;
    
    /**
    * @Column(type="boolean")
    */
    private $isRecurring;
    
    /**
     * @ManyToOne(targetEntity="Service", cascade={"persist"})
     * @JoinColumn(name="service_id", referencedColumnName="id")
     *   
     */
    private $Service;
    
    
    public function __construct(){
      $this->Service = new ArrayCollection();
      $this->Days = new ArrayCollection();
      // default values
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
