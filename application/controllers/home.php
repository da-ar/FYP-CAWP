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

		
	public function index(){
		
            $this->load->view('home');
		
	
	}
        
        public function location($bssid){
            
            $parsed = $this->_parse_bssid($bssid);
            
            $APRep  = $this->em->getRepository('models\Access_Point');
            
            $data = array();
            $data["location"] = $APRep->get_location($parsed); 
            $this->load->view('location', $data);
            
            
        }
        
        private function _parse_bssid($in){
            
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
            
            return $parsed . "%";
            
        }
        
        


}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */