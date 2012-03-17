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
     * @ManyToMany(targetEntity="Interest", inversedBy="Service", cascade={"persist,remove"})
     */
    private $Interests;
    
   /**
     * @OneToMany(targetEntity="Schedule", mappedBy="Service", cascade={"persist"})  
     * @var Schedule[]
     */
    private $Schedule;
    
    
    function  __construct()  {
        // default values
        $this->isSpecial = FALSE;
        
        $this->Interests = new ArrayCollection();
        $this->Schedule = new ArrayCollection();
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
