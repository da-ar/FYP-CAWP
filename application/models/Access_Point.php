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
 * @Entity(repositoryClass="Repositories\Access_Point_Repository")
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
    
    
    public function __construct(){
      $this->Location = new ArrayCollection();
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

class Access_Point_Repository extends EntityRepository {
    
    
    public function get_Location($bssid)
    {
   
        $loc = $this->_em->createQuery("SELECT l.block, l.floor, l.isMall FROM models\Access_Point ap JOIN
                                                      ap.Location l
                                        WHERE ap.bssid like ?1");
        $loc->setParameter(1, $bssid);
        
        return $loc->getResult();
        
    }
    
}


/* End of file Access_Point.php */
/* Location: ./application/models/Access_Point.php */
