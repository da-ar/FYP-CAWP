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
    
    function setup(){
        // all that needs setup for deployment
        $this->db_tool();
        $this->_locations_and_access_points();
    }
    
    function _locations_and_access_points(){
        
        //16c
        $loc1 = new models\Location();
        $loc1->set_block("16");
        $loc1->set_floor("C");
        $loc1->set_isMall(false);
        $this->em->persist($loc1);
        //16e
        $loc2 = new models\Location();
        $loc2->set_block("16");
        $loc2->set_floor("E");
        $loc2->set_isMall(false);
        $this->em->persist($loc2);
        //16g
        $loc3 = new models\Location();
        $loc3->set_block("16");
        $loc3->set_floor("G");
        $loc3->set_isMall(false);
        $this->em->persist($loc3);
        //16j
        $loc4 = new models\Location();
        $loc4->set_block("16");
        $loc4->set_floor("J");
        $loc4->set_isMall(false);
        $this->em->persist($loc4);
        
        //mall near 15G
        $loc5 = new models\Location();
        $loc5->set_block("15");
        $loc5->set_floor("G");
        $loc5->set_isMall(true);
        $this->em->persist($loc5);
        
        //mall near Mezzanine
        $loc6 = new models\Location();
        $loc6->set_block("8");
        $loc6->set_floor("G");
        $loc6->set_isMall(true);
        $this->em->persist($loc6);
        
        //mall near block 2
        $loc7 = new models\Location();
        $loc7->set_block("2");
        $loc7->set_floor("G");
        $loc7->set_isMall(true);
        $this->em->persist($loc7);
        
        //mall near Block 11
        $loc8 = new models\Location();
        $loc8->set_block("11");
        $loc8->set_floor("G");
        $loc8->set_isMall(true);
        $this->em->persist($loc8);
        
        //mall near Block 5
        $loc9 = new models\Location();
        $loc9->set_block("5");
        $loc9->set_floor("G");
        $loc9->set_isMall(true);
        $this->em->persist($loc9);
        
        
        // J_16C_1                              
        $ap1 = new models\Access_Point();
        $ap1->set_Location($loc1);
        $ap1->set_bssid("00:0b:0e:32:9b:80");
        $this->em->persist($ap1);
        
        // J_16C_2              
        $ap2 = new models\Access_Point();
        $ap2->set_Location($loc1);
        $ap2->set_bssid("00:0b:0e:32:c5:40");
        $this->em->persist($ap2);
        
        // J_16C_lab_1
        $ap3 = new models\Access_Point();
        $ap3->set_Location($loc1);
        $ap3->set_bssid("00:0b:0e:61:69:40");
        $this->em->persist($ap3);
        
        // J_16C_lab_2
        $ap4 = new models\Access_Point();
        $ap4->set_Location($loc1);
        $ap4->set_bssid("00:0b:0e:60:dd:c0");
        $this->em->persist($ap4);
        
        // J_16E_1
        $ap5 = new models\Access_Point();
        $ap5->set_Location($loc2);
        $ap5->set_bssid("00:0b:0e:13:a6:40");
        $this->em->persist($ap5);
        
        // J_16E_2
        $ap6 = new models\Access_Point();
        $ap6->set_Location($loc2);
        $ap6->set_bssid("00:0b:0e:61:92:40");
        $this->em->persist($ap6);
        
        // J_16E_3
        $ap7 = new models\Access_Point();
        $ap7->set_Location($loc2);
        $ap7->set_bssid("00:0b:0e:61:76:40");
        $this->em->persist($ap7);
        
        // J_16G_1
        $ap8 = new models\Access_Point();
        $ap8->set_Location($loc3);
        $ap8->set_bssid("00:0b:0e:12:5f:c0");
        $this->em->persist($ap8);
        
        // J_16G_2
        $ap9 = new models\Access_Point();
        $ap9->set_Location($loc3);
        $ap9->set_bssid("00:0b:0e:12:64:80");
        $this->em->persist($ap9);
        
        // J_16J_1
        $ap10 = new models\Access_Point();
        $ap10->set_Location($loc4);
        $ap10->set_bssid("00:0b:0e:13:8f:40");
        $this->em->persist($ap10);
        
        // J_16J_2
        $ap11 = new models\Access_Point();
        $ap11->set_Location($loc4);
        $ap11->set_bssid("00:0b:0e:61:a4:00");
        $this->em->persist($ap11);
        
        // J_16G LT
        $ap12 = new models\Access_Point();
        $ap12->set_Location($loc3);
        $ap12->set_bssid("00:0b:0e:13:8d:00");
        $this->em->persist($ap12);
 
        // J_mall_15_scr
        $ap13 = new models\Access_Point();
        $ap13->set_Location($loc5);
        $ap13->set_bssid("00:0b:0e:32:ac:80");
        $this->em->persist($ap13);
        
        // J_mall_canteen-A
        $ap14 = new models\Access_Point();
        $ap14->set_Location($loc8);
        $ap14->set_bssid("00:0b:0e:32:b4:40");
        $this->em->persist($ap14);
        
        // J_mall_canteen-B
        $ap15 = new models\Access_Point();
        $ap15->set_Location($loc8);
        $ap15->set_bssid("00:0b:0e:32:bb:c0");
        $this->em->persist($ap15);
        
        // J_8_Mezzanine
        $ap16 = new models\Access_Point();
        $ap16->set_Location($loc6);
        $ap16->set_bssid("00:0b:0e:13:92:c0");
        $this->em->persist($ap16);

        // J_mall_Blk2
        $ap17 = new models\Access_Point();
        $ap17->set_Location($loc7);
        $ap17->set_bssid("00:0b:0e:3b:d2:80");
        $this->em->persist($ap17);
        
        // J_mall_Blk5
        $ap18 = new models\Access_Point();
        $ap18->set_Location($loc9);
        $ap18->set_bssid("00:0b:0e:38:1c:40");
        $this->em->persist($ap18);
        
        // J_11H_ S.Union
        $ap18 = new models\Access_Point();
        $ap18->set_Location($loc8);
        $ap18->set_bssid("00:0b:0e:32:5f:40");
        $this->em->persist($ap18);
     
        // commits the changes
        $this->em->flush();
        
        
    }
   
}

/* End of file Fixtures.php */
/* Location: ./application/controllers/Fixtures.php */
