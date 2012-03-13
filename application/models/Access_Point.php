<?php

/**
 * Access_Point
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Access_Point.php
 * @version		1.0
 * @date		01/03/2012
 * 
 * Copyright (c) 2012
 */

namespace models;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="access_points",indexes={@index(name="bssid_idx", columns={"bssid"})})
 */

class Access_Point {
    
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
    private $bssid;
    
    /**
     * @ManyToOne(targetEntity="Location")
     * @JoinColumn(name="location_id", referencedColumnName="id")
     */
    private $Location;
    
    
    public function get_id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function get_bssid() {
        return $this->bssid;
    }

    public function set_bssid($bssid) {
        $this->bssid = $bssid;
    }

    public function get_Location() {
        return $this->Location;
    }

    public function set_Location($Location) {
        $this->Location = $Location;
    }   
    
   
}

/* End of file Access_Point.php */
/* Location: ./application/models/Access_Point.php */
