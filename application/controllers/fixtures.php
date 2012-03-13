<?php
/**
 * fixtures
 * 
 * Description
 * provides a means with which to populate the database tables
 * with dummy data to test the system
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		fixtures.php
 * @version		1.0
 * @date		01/03/2012
 * 
 * Copyright (c) 2012
 */

class Fixtures extends MY_Controller  {
    
    function  __construct()  {
	parent::__construct();
        
        $this->load->helper('ion_password');
    }
    
    
    function db_tool(){
        // SET UP THE DATABASE
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
        

        $classes = array(
            $this->em->getClassMetadata('models\Location'),
            $this->em->getClassMetadata('models\Interest'),
            $this->em->getClassMetadata('models\Access_Point'),
            $this->em->getClassMetadata('models\Service'),
            $this->em->getClassMetadata('models\Auth_Group'),
            $this->em->getClassMetadata('models\Auth_User'),
            $this->em->getClassMetadata('models\Auth_Meta')
        );
        $tool->dropDatabase();  // drops all the tables in the database!!!!!!! 
                                // DO NOT USE if you've modified the db outside 
                                // of this application
        $tool->createSchema($classes);  // creates the tables from the models 

        $this->em->flush();      
        
    }
   
}

/* End of file Fixtures.php */
/* Location: ./application/controllers/Fixtures.php */
