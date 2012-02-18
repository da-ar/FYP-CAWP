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


}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */