<?php

/**
 * Home
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Home.php
 * @version		1.0
 * @date		01/21/2012
 * 
 * Copyright (c) 2012
 */
 
 
class Home extends MY_Controller {

		
    public function index($bssid=NULL){
        
        $data["bssid"] = $bssid;
        $this->load->view('home', $data);

    }

    public function location($bssid){
        // queries the bssid with the database 
        // and returns a location on campus

        $parsed = $this->_parse_bssid($bssid);

        $APRep  = $this->em->getRepository('models\Access_Point');

        $data = array();
        $result = $APRep->get_location($parsed); 
        
        $strLoc = "UNKNOWN";
        
        if(isset($result[0])){
            if($result[0]["isMall"]){
                $strLoc = "The Mall near " . $result[0]["block"] . $result[0]["floor"];
            } else {
                $strLoc = $result[0]["block"] . $result[0]["floor"];
            }
        }
        
        $data["location"] = $strLoc;
        
        $this->load->view('location', $data);


    }

    private function _parse_bssid($in){
        // the bssid needs to have the last two digits and last
        // semi-collon removed as these identify the SSID
        // and not the identity of the Access Point

        $in_parts = explode(":", $in);
        $parsed = "";
        $count = 0;


        foreach ($in_parts as $part){
            $count++;
            if($count < count($in_parts)){
                $parsed .= str_pad($part, 2, "0", STR_PAD_LEFT);
                $parsed .=   ":";
            }
        }

        return $parsed . "%"; // append a % for the use in the like function

    }

    public function services($bssid){


        $parsed = $this->_parse_bssid($bssid);

        $ServiceRep  = $this->em->getRepository('models\Service');
        $context = $this->get_context($parsed);

        $data = array();                  
        $data["json_data"] = json_encode($ServiceRep->get_services_in_context($context)); 

        $this->load->view('service_json', $data);

    }

    public function get_context($bssid){

        $context = array();

        // date & time context
        $context["date"] = date("Y-m-j", mktime(0,0,0,date("m"),date("j"), date("Y")));            
        $context["day"] = date("N"); // 1 = mon 7 = sun

        $context["start_time"] = date("H:i:s",strtotime("+2 hours"));
        $context["end_time"] = date("H:i:s");

        // interest context
        $context["interests"] = array();

        if($this->ion_auth->logged_in()){
            // TODO: fetch the user interest list                
        }
        
        // get the location context
        $APRep  = $this->em->getRepository('models\Access_Point');
        $result = $APRep->get_location($bssid); 
        
        $context["block"] = -1;
        $context["floor"] = -1;
        
        if(isset($result[0])){
            $context["block"] = $result[0]["block"];
            $context["floor"] = $result[0]["floor"];
        }


        return $context;

    }
    
    public function service_info($id){
        
        $data["service"]  = $this->em->getRepository('models\Service')->findById($id);
        $this->load->view('service_info', $data);
        
        
    }
        
        


}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */