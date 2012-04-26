<?php

/**
 * Profile
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		Profile.php
 * @version		1.0
 * @date		04/01/2012
 * 
 * Copyright (c) 2012
 */
 
 
class Profile extends MY_Controller {
    
    protected $user;
    
    public function __construct(){
        parent::__construct();
        
        if (!$this->ion_auth->logged_in()){
                redirect('auth/login', 'refresh');
        }
        if($this->user == null){
            // dont want to work with normal CI models.. get the doctrine object instead
            $this->user = $this->em->find('models\Auth_User', $this->ion_auth->get_user()->id);
        }
        
        
         $this->load->helper('form');
         $this->load->helper('doctrine');
         $this->load->library('form_validation');
        
    }
    
    private function _getDisplayDataArr(){
        
        $data["email"] = $this->user->email;
        $data["group_name"] = $this->user->Auth_Group->name;
        $data["group_desc"] = $this->user->Auth_Group->description;
        $data["name"] = $this->user->Auth_Meta->name;
        $data["rfid"] = $this->user->Auth_Meta->rfid_token;
        $data["course"] = $this->user->Auth_Meta->course;
        $data["timetable"] = $this->user->Auth_Meta->timetable;
        $data["isOwner"] = $this->user->Auth_Meta->isServiceOwner;
        $data["user_interests"] = getIds($this->user->Auth_Meta->Interests);
        $data["user_services"] = getIds($this->user->Auth_Meta->Services);
        $data["interests"] = $this->em->getRepository('models\Interest')->findAll();
        
        
        return $data;
        
    }
    
		
    public function index(){
        $this->load->view('profile/index', $this->_getDisplayDataArr());
    }
    
    public function timetable(){
        $this->load->view('profile/timetable');
    }
    
    public function update(){
        
        // validate the form data
        
        $this->form_validation->set_rules('name', 'your Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('interests[]', 'Your interests', '');
        
        
        // check if there were any issues
        if ($this->form_validation->run() == TRUE){
          // no dramas so update the data     
           
            $ids = $this->input->post('interests');
            $ids = array_map('intval', $ids); // converts array of strings to array of ints
                        
            $this->user->Auth_Meta->name = $this->input->post('name');
            $this->user->email = $this->input->post('email');
            $this->user->Auth_Meta->Interests = $this->em->getRepository('models\Interest')->get_interests($ids);
            
            $this->em->persist($this->user);
            $this->em->flush();
            
            
        }
        
       $this->load->view('profile/index', $this->_getDisplayDataArr());
        
        
        
    }


}
/* End of file profile.php */
/* Location: ./application/controllers/profile.php */