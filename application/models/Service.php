<?php

/**
 * Service
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Service.php
 * @version		1.0
 * @date		01/03/2012
 * 
 * Copyright (c) 2012
 */

namespace models;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Repositories\Service_Repository")
 * @Table(name="services",indexes={@index(name="special_idx", columns={"isSpecial"})})
 * 
 */

class Service {
    
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO")
     *  
     */
    private $id;
    
    /**
    * @Column(type="string", length=75, nullable=false)
    */
    private $name;
    
    /**
    * @Column(type="string", length=255, nullable=true)
    */
    private $body;
    
    /**
    * @Column(type="string", length=255, nullable=true)
    */
    private $url;

    /**
    * @Column(type="string", length=255, nullable=true)
    */
    private $image_bg;
    
    /**
    * @Column(type="boolean")
    */
    private $isSpecial;
    
    /**
     * @ManyToOne(targetEntity="Location")
     * @JoinColumn(name="location_id", referencedColumnName="id")
     */
    private $Location;
    
    /**
     * @ManyToMany(targetEntity="Interest", inversedBy="Service")
     * @JoinTable(name="services_vs_interests")
     */
    private $Interests;
    
    
    function  __construct()  {
        // default values
        $this->set_isSpecial(FALSE);
        
        $this->Interests = new ArrayCollection();
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

    public function get_body() {
        return $this->body;
    }

    public function set_body($body) {
        $this->body = $body;
    }

    public function get_url() {
        return $this->url;
    }

    public function set_url($url) {
        $this->url = $url;
    }

    public function get_image_bg() {
        return $this->image_bg;
    }

    public function set_image_bg($image_bg) {
        $this->image_bg = $image_bg;
    }

    public function get_isSpecial() {
        return $this->isSpecial;
    }

    public function set_isSpecial($isSpecial) {
        $this->isSpecial = $isSpecial;
    }

    public function get_Location() {
        return $this->Location;
    }

    public function set_Location($Location) {
        $this->Location = $Location;
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

   
   
}

namespace Repositories;
use Doctrine\ORM\EntityRepository;

class Service_Repository extends EntityRepository
{
    public function get_Specials()
    {
        return $this->_em->createQuery("SELECT s.* FROM models\Service s
                                        WHERE isSpecial = true")->getResult();
    }
    
}

/* End of file Service.php */
/* Location: ./application/models/Service.php */
