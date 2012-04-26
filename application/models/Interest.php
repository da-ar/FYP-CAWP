<?php

/**
 * Interest
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Interest.php
 * @version		1.0
 * @date		01/03/2012
 * 
 * Copyright (c) 2012
 */

namespace models;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Repositories\Interest_Repository")
 * @Table(name="interests")
 * 
 */

class Interest {
    
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
     * @ManyToMany(targetEntity="Service", mappedBy="Interests")
     */
    private $Services;
    
     /**
     * @ManyToMany(targetEntity="Auth_Meta", mappedBy="Interests")
     */
    private $Auth_Meta;

    
    public function __get($property){
        return $this->$property;
    }  
    
    public function __set($property,$value){
        $this->$property = $value;
    }
   
}

namespace Repositories;
use Doctrine\ORM\EntityRepository;

class Interest_Repository extends EntityRepository
{
    public function get_interests($ids)
    {
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('i')
                ->from('models\Interest', 'i')
                ->where($qb->expr()->in('i.id', $ids));
        $query = $qb->getQuery()->getResult();
        
        return $query;
        
        
    }
    
}

/* End of file Interest.php */
/* Location: ./application/models/Interest.php */
