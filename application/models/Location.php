<?php

/**
 * Location
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Location.php
 * @version		1.0
 * @date		01/03/2012
 * 
 * Copyright (c) 2012
 */

namespace models;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Repositories\Location_Repository")
 * @Table(name="locations",indexes={
 *      @index(name="block_idx", columns={"block"}),
 *      @index(name="floor_idx", columns={"floor"})
 * })
 * 
 */

class Location {
    
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO")
     *  
     */
    private $id;
    
    /**
    * @Column(type="string", length=10, nullable=false)
    */
    private $block;
    
    /**
    * @Column(type="string", length=10, nullable=false)
    */
    private $floor;
    
     /**
     * @OneToMany(targetEntity="Service", mappedBy="Location")  
     * @var Service[]
     */
    private $Service;
    
    
    public function __construct(){
      $this->Service = new ArrayCollection();
    }
    
    public function get_id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function get_block() {
        return $this->block;
    }

    public function set_block($block) {
        $this->block = $block;
    }

    public function get_floor() {
        return $this->floor;
    }

    public function set_floor($floor) {
        $this->floor = $floor;
    }

    public function get_Service() {
        return $this->Service;
    }

    public function set_Service($Service) {
        $this->Service = $Service;
    }

     public function add_Service(Service $Service){
        $this->Service[] = $Service;        
    }


   
   
}

namespace Repositories;
use Doctrine\ORM\EntityRepository;

class Location_Repository extends EntityRepository
{
    public function get_Services($id)
    {
        $services = $this->_em->createQuery("SELECT service FROM models\Location WHERE id = ?1");
        $services->setParameter(1, $id);
        return $services->getResult();
    }
    
}

/* End of file Location.php */
/* Location: ./application/models/Location.php */
