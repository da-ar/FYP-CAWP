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
 * @Entity(repositoryClass="Repositories\Day_Repository")
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

namespace Repositories;
use Doctrine\ORM\EntityRepository;

class Day_Repository extends EntityRepository
{
    public function get_days($ids)
    {
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('i')
                ->from('models\Day', 'i')
                ->where($qb->expr()->in('i.id', $ids));
        $query = $qb->getQuery()->getResult();
        
        return $query;
        
        
    }
    
}

/* End of file Day.php */
/* Location: ./application/models/Day.php */
