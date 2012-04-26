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
     * @ManyToOne(targetEntity="Location", inversedBy="Service")
     * @JoinColumn(name="location_id", referencedColumnName="id")
     */
    private $Location;
    
    /**
     * @ManyToMany(targetEntity="Interest", inversedBy="Services", cascade={"persist,remove"})
     * @JoinTable(name="service_interest",
     *      joinColumns={@JoinColumn(name="service_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="interest_id", referencedColumnName="id")})
     */
    private $Interests;
    
   /**
     * @OneToMany(targetEntity="Schedule", mappedBy="Service", cascade={"persist"})  
     * @var Schedule[]
     */
    private $Schedule;
    
     /**
     * @ManyToMany(targetEntity="Auth_Meta", mappedBy="Services")
     */
    private $Auth_Meta;
    
    
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
    
    public function get_services_in_context($context){
        
        // this query finds all services that are recurring and thus happening today
        // or one off events and are due to be running today
        // service events should be occuring within the next few hours
        
       $query = "
            SELECT  s, i, sc, l
            FROM    models\Service s 
                    JOIN s.Interests i
                    JOIN s.Schedule sc
                    JOIN s.Location l
                    JOIN sc.Days d
            WHERE   ((   sc.isRecurring = 1 AND
                        (sc.start_date <= ?1 AND
                        (sc.end_date >= ?1 OR
                        sc.end_date IS NULL)) 
                        AND  d.id = ?2) 
                     OR 
                    (   sc.isRecurring = 0 AND
                        (sc.start_date <= ?1 AND
                        sc.end_date >= ?1)
                    ))";
        
        $services = $this->_em->createQuery($query);
        
        $services->setParameter(1, $context["date"]);
        $services->setParameter(2, $context["day"]);
        
        return $this->sort_services($services->getResult(), $context);
        
    }
    
    private function sort_services($result, $context){
       
       $minWeight = 3; // this is the minimum weight that a service should have to make it to the list
       $sorted_array = array();
       
       foreach($result as $service){
           $weighted = $this->weight($service, $context);
           
           if($weighted >= $minWeight){
            $service_item = array();

            // manually extract the parts we need from the service
            // there is no easy way to do this
            // needs to be extracted out for serialisation
            $objArr = array();
            $objArr["id"] = $service->id;
            $objArr["name"] = $service->name;
            $objArr["url"] = $service->url;
            $objArr["body"] = $service->body;
            $objArr["url"] = $service->url;
            $objArr["image"] = $service->image_bg;
            $objArr["interests"] = array();
            foreach($service->Interests as $interest){
                    $objArr["interests"][] = $interest->name;    
            }
            
            $service_item["id"] = $service->id;
            $service_item["service"] = $objArr;
            $service_item["weight"] = $weighted;
            array_push($sorted_array, $service_item);
           }
       } 
       
       usort($sorted_array, array($this, "sort_service_array"));
       
       return $sorted_array;
        
    }
    
    private function sort_service_array($a,$b) {
         if ($a["weight"] == $b["weight"]) {
            return 0;
        }
        return ($a["weight"] > $b["weight"]) ? -1 : 1;
    }
    
    private function weight($service, $context){
        // once the object exists we can call this function.
        // it will create a weighting based on the items that match the context
        $location_block_weight = 5;
        $location_floor_weight = 2;
        $interest_weight = 1;
        $time_weight = 3;
        $total_weight = 0;
        
        // check to see if the service is located with the current block
        if ($service->Location->block == $context["block"]){
            
            $total_weight = $total_weight + $location_block_weight;
            
            // check if the service is within the current floor
            if ($service->Location->floor == $context["floor"]){
                $total_weight = $total_weight + $location_floor_weight;    
            }
            
        }
        // loop throught the associated interests of the service
        foreach($service->Interests as $interest){
            // check to see if the interest is part of the context
            if(array_search($interest->id, $context["interests"])){
                $total_weight = $total_weight + $interest_weight;
            }
        }
        
        foreach($service->Interests as $interest){
            // check to see if the interest is part of the context
            if(array_search($interest->id, $context["interests"])){
                $total_weight = $total_weight + $interest_weight;
            }
        }
        
        $now = strtotime("now");
        foreach($service->Schedule as $sch){
            
            $days = array();
            foreach($sch->Days as $day){
                $days[] = $day->id;    
            }
            
            if(($sch->isRecurring && array_search(date("N"), $days)) ||
                    (!$sch->isRecurring && ($sch->start_date->getTimestamp() <= $now &&
                            ($sch->end_date == NULL || $sch->end_date >= $now)))){
                // check to see if the schedule  is a good match
                if($now >= $sch->start_time->getTimestamp() && $now <= $sch->end_time->getTimestamp()){
                    $total_weight = $total_weight + $time_weight;
                }
            }
            
        }
        
        return $total_weight;
        
    }
    
}

/* End of file Service.php */
/* Location: ./application/models/Service.php */
