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
        $this->_interests();
        $this->_generate_services();
    }
    
    // fixtures for all locations and 
    // access points for the purposes of the application
    function _locations_and_access_points(){
        
        // Locations ----------------------------
        
        //16cx
        $loc1 = new models\Location();
        $loc1->block = "16";
        $loc1->floor ="C";
        $loc1->isMall = false;
        $this->em->persist($loc1);
        //16e
        $loc2 = new models\Location();
        $loc2->block = "16";
        $loc2->floor = "E";
        $loc2->isMall = false;
        $this->em->persist($loc2);
        //16g
        $loc3 = new models\Location();
        $loc3->block = "16";
        $loc3->floor = "G";
        $loc3->isMall = false;
        $this->em->persist($loc3);
        //16j
        $loc4 = new models\Location();
        $loc4->block = "16";
        $loc4->floor = "J";
        $loc4->isMall = false;
        $this->em->persist($loc4);
        
        //mall near 15G
        $loc5 = new models\Location();
        $loc5->block = "15";
        $loc5->floor = "G";
        $loc5->isMall = true;
        $this->em->persist($loc5);
        
        //mall near Mezzanine
        $loc6 = new models\Location();
        $loc6->block = "8";
        $loc6->floor = "G";
        $loc6->isMall = true;
        $this->em->persist($loc6);
        
        //mall near block 2
        $loc7 = new models\Location();
        $loc7->block = "2";
        $loc7->floor = "G";
        $loc7->isMall = true;
        $this->em->persist($loc7);
        
        //mall near Block 11
        $loc8 = new models\Location();
        $loc8->block = "11";
        $loc8->floor = "G";
        $loc8->isMall = true;
        $this->em->persist($loc8);
        
        //mall near Block 5
        $loc9 = new models\Location();
        $loc9->block = "5";
        $loc9->floor = "G";
        $loc9->isMall = true;
        $this->em->persist($loc9);
        
        
        // ACCESS POINTS ----------------------------
        
        // J_16C_1                              
        $ap1 = new models\Access_Point();
        $ap1->Location = $loc1;
        $ap1->bssid = "00:0b:0e:32:9b:80";
        $this->em->persist($ap1);
        
        // J_16C_2              
        $ap2 = new models\Access_Point();
        $ap2->Location = $loc1;
        $ap2->bssid = "00:0b:0e:32:c5:40";
        $this->em->persist($ap2);
        
        // J_16C_lab_1
        $ap3 = new models\Access_Point();
        $ap3->Location = $loc1;
        $ap3->bssid = "00:0b:0e:61:69:40";
        $this->em->persist($ap3);
        
        // J_16C_lab_2
        $ap4 = new models\Access_Point();
        $ap4->Location = $loc1;
        $ap4->bssid = "00:0b:0e:60:dd:c0";
        $this->em->persist($ap4);
        
        // J_16E_1
        $ap5 = new models\Access_Point();
        $ap5->Location = $loc2;
        $ap5->bssid = "00:0b:0e:13:a6:40";
        $this->em->persist($ap5);
        
        // J_16E_2
        $ap6 = new models\Access_Point();
        $ap6->Location = $loc2;
        $ap6->bssid = "00:0b:0e:61:92:40";
        $this->em->persist($ap6);
        
        // J_16E_3
        $ap7 = new models\Access_Point();
        $ap7->Location = $loc2;
        $ap7->bssid = "00:0b:0e:61:76:40";
        $this->em->persist($ap7);
        
        // J_16G_1
        $ap8 = new models\Access_Point();
        $ap8->Location = $loc3;
        $ap8->bssid = "00:0b:0e:12:5f:c0";
        $this->em->persist($ap8);
        
        // J_16G_2
        $ap9 = new models\Access_Point();
        $ap9->Location = $loc3;
        $ap9->bssid = "00:0b:0e:12:64:80";
        $this->em->persist($ap9);
        
        // J_16J_1
        $ap10 = new models\Access_Point();
        $ap10->Location = $loc4;
        $ap10->bssid = "00:0b:0e:13:8f:40";
        $this->em->persist($ap10);
        
        // J_16J_2
        $ap11 = new models\Access_Point();
        $ap11->Location = $loc4;
        $ap11->bssid = "00:0b:0e:61:a4:00";
        $this->em->persist($ap11);
        
        // J_16G LT
        $ap12 = new models\Access_Point();
        $ap12->Location = $loc3;
        $ap12->bssid = "00:0b:0e:13:8d:00";
        $this->em->persist($ap12);
 
        // J_mall_15_scr
        $ap13 = new models\Access_Point();
        $ap13->Location = $loc5;
        $ap13->bssid = "00:0b:0e:32:ac:80";
        $this->em->persist($ap13);
        
        // J_mall_canteen-A
        $ap14 = new models\Access_Point();
        $ap14->Location = $loc8;
        $ap14->bssid = "00:0b:0e:32:b4:40";
        $this->em->persist($ap14);
        
        // J_mall_canteen-B
        $ap15 = new models\Access_Point();
        $ap15->Location = $loc8;
        $ap15->bssid = "00:0b:0e:32:bb:c0";
        $this->em->persist($ap15);
        
        // J_8_Mezzanine
        $ap16 = new models\Access_Point();
        $ap16->Location = $loc6;
        $ap16->bssid = "00:0b:0e:13:92:c0";
        $this->em->persist($ap16);

        // J_mall_Blk2
        $ap17 = new models\Access_Point();
        $ap17->Location = $loc7;
        $ap17->bssid = "00:0b:0e:3b:d2:80";
        $this->em->persist($ap17);
        
        // J_mall_Blk5
        $ap18 = new models\Access_Point();
        $ap18->Location = $loc9;
        $ap18->bssid = "00:0b:0e:38:1c:40";
        $this->em->persist($ap18);
        
        // J_11H_ S.Union
        $ap18 = new models\Access_Point();
        $ap18->Location = $loc8;
        $ap18->bssid = "00:0b:0e:32:5f:40";
        $this->em->persist($ap18);
     
        // commits the changes
        $this->em->flush();
 
   }
   
   function _interests(){
       
       /*
        * 
        *  Generic list of interests that can be associated with 
        *  services or users
        * 
        */
       
       $interest1 = new models\Interest();
       $interest1->name = "Computing";
       $this->em->persist($interest1);
       
       $interest2 = new models\Interest();
       $interest2->name = "Socialising";
       $this->em->persist($interest2);
       
       $interest3 = new models\Interest();
       $interest3->name = "Self Improvement";
       $this->em->persist($interest3);
       
       $interest4 = new models\Interest();
       $interest4->name = "Special Offers";
       $this->em->persist($interest4);
       
       $interest5 = new models\Interest();
       $interest5->name = "Sports - Ball Games";
       $this->em->persist($interest5);
       
       $interest6 = new models\Interest();
       $interest6->name = "Sports - Raquet Sports";
       $this->em->persist($interest6);
       
       $interest7 = new models\Interest();
       $interest7->name = "Sports - Cricket";
       $this->em->persist($interest7);
       
       $interest8 = new models\Interest();
       $interest8->name = "Sports - Cue Sports";
       $this->em->persist($interest8);
       
       $interest9 = new models\Interest();
       $interest9->name = "Sports - Gaelic Sports";
       $this->em->persist($interest9);
       
       $interest10 = new models\Interest();
       $interest10->name = "Sports - Golf";
       $this->em->persist($interest10);
       
       $interest11 = new models\Interest();
       $interest11->name = "Sports - Hockey";
       $this->em->persist($interest11);
       
       $interest12 = new models\Interest();
       $interest12->name = "Sports - Martial Arts";
       $this->em->persist($interest12);
       
       $interest13 = new models\Interest();
       $interest13->name = "Sports - Fitness";
       $this->em->persist($interest13);
       
       $interest14 = new models\Interest();
       $interest14->name = "Religion";
       $this->em->persist($interest14);
       
       $interest15 = new models\Interest();
       $interest15->name = "Volunteering";
       $this->em->persist($interest15);
       
       
       // commits the changes
        $this->em->flush();
       
   }
   
   
   function _generate_services(){
       /**
        *
        * dynamically create fixtures for every 
        * location stored in the database.
        *  
        */
       
       
       $locations = $this->em->getRepository('models\Location')->findAll();
       $randCount = 0;
       
       foreach($locations as $loc){
           
           // for each location create a random number
           // of services located in that area
           $randCount = rand(1,5);
           
           for($i=0;$i<=$randCount;$i++){
               
                $myService = new models\Service();
                $myService->Location = $loc;
                
                // make us a service name which describes the location
                $service_name = "";
                if($loc->isMall){
                    $service_name = "Mall near " . $loc->block . $loc->floor;
                } else {
                    $service_name = "Service located at " . $loc->block . $loc->floor;
                }
                
                // use one of the example images available , padding ensures numbers are generated like 001, 002 etc
                $randImage = "Service" . str_pad(rand(1, 17), 3, "0", STR_PAD_LEFT) . ".jpg";               
                
                $myService->name = $service_name;
                $myService->body = $this->lorem();
                $myService->url = "http://news.bbc.co.uk";
                $myService->isSpecial = rand(0,1);
                $myService->image_bg = $randImage;
                $myService->Interests = $this->create_interest();

                $this->em->persist($myService);
               
           }
          
           
       }
       
       $this->em->flush();
       
       
   }
   
   function lorem(){
       
       return "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras posuere, justo vel blandit lacinia, diam mauris varius leo, et ullamcorper purus ipsum at tellus. In hac habitasse platea dictumst. In hac habitasse platea dictumst. Praesent sapien enim, sagittis vel lobortis eget, facilisis non ligula. Sed aliquet eros a sem tempor eget rhoncus sem adipiscing. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus ac ipsum libero. Nullam orci ipsum, fermentum id convallis vitae, vehicula eget risus. Curabitur in mauris nunc, non mollis elit. Maecenas lobortis molestie arcu, ac placerat velit lacinia in. Cras ac neque elit, non sodales purus. Nulla facilisi. Sed sagittis magna vel felis fringilla et suscipit justo rutrum. Phasellus sapien est, congue at tincidunt eu, accumsan non turpis.

Etiam elementum magna at dui vulputate malesuada. Integer sed lectus eu velit ornare tempus. Maecenas adipiscing odio at ligula auctor tempor id ut est. Ut elit diam, commodo a ornare nec, vestibulum sed mi. Proin non viverra nunc. Ut elit diam, ultricies sed consequat sed, interdum vel magna. Nulla purus eros, posuere quis tristique non, sollicitudin quis nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

Vestibulum convallis ullamcorper scelerisque. Donec vitae mi in nulla aliquet condimentum. Donec dapibus mi sollicitudin velit mollis laoreet. Suspendisse mollis condimentum purus at rhoncus. Mauris faucibus bibendum enim in placerat. Etiam lacinia mi sed nulla pretium vulputate. Integer sit amet orci ut ante aliquam vestibulum.

In quis tellus magna. Nam tempus dolor sit amet mauris tristique sit amet faucibus lectus pharetra. Vestibulum luctus dolor nec orci semper nec rutrum libero ornare. Nunc commodo massa at metus sollicitudin iaculis. Etiam sagittis sapien at neque tristique commodo. Curabitur egestas felis sit amet erat luctus vitae imperdiet odio viverra. In eget nisl et nulla accumsan ornare vitae ac dui. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla nisl urna, tempor varius aliquam vitae, ornare eget est. Nullam sed ligula non ipsum viverra imperdiet eu sit amet elit. Curabitur in ultrices elit. Cras condimentum iaculis massa sit amet dictum. Duis vitae arcu eros, vestibulum aliquet nisi. Mauris porta magna quis neque ullamcorper rutrum.

Aliquam erat volutpat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Quisque sem orci, tempor sit amet facilisis quis, vehicula eu augue. Sed lobortis, risus vel mollis faucibus, justo quam lobortis massa, id porttitor dolor massa quis lorem. Phasellus volutpat gravida metus vulputate tincidunt. Etiam congue dolor nec nisl laoreet bibendum. Proin ac turpis mi, vitae imperdiet risus.

";
       
   }
   
   private function create_interest(){
       /**
        * returns an array of random interest objects
        */
       $interests = $this->em->getRepository('models\Interest')->findAll();
       
       $randNum = rand(2,5);
       $randoms = array_rand($interests, $randNum);
       
       $rtnArr = array();
       foreach($randoms as $key){
            array_push($rtnArr, $interests[$key]); 
       }
       
       return $rtnArr;
       
       
   }
        
        
   
}


//Doctrine\Common\Util\Debug::dump()

/* End of file Fixtures.php */
/* Location: ./application/controllers/Fixtures.php */
