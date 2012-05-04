<?php

/**
 * Locations
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		locations.php
 * @version		1.0
 * @date		30/04/2012
 * 
 * Copyright (c) 2012
 */
 
 
class Locations extends MY_Controller {    
    
    protected $user;

    public function __construct(){
        parent::__construct();
        
        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !$this->ion_auth->is_group('service_user'))){
                redirect('auth/login', 'refresh');
        }
        if($this->user == null){
            // dont want to work with normal CI models.. get the doctrine object instead
            $this->user = $this->em->find('models\Auth_User', $this->ion_auth->get_user()->id);
        }
        
        
         $this->load->helper('form');
         $this->load->library('form_validation');
        
    }
    
		
    public function index(){
        $data['locations'] = $this->em->getRepository('models\Location')->findAll();        
        $this->load->view('dashboard/locations', $data);
    }    
    
    
    public function add(){
        $data["location"] = new models\Location;
        $this->load->view('dashboard/edit_location', $data);
    }
    
    public function edit($id){
        $data["location"] = $this->em->getRepository('models\Location')->find($id);
        $this->load->view('dashboard/edit_location', $data);
    }
    
    public function update(){
        
        // validate the form data
        $this->form_validation->set_rules('block', 'Block', 'required');
        $this->form_validation->set_rules('floor', 'Floor', 'required');
        
        $data["location"] = $this->em->getRepository('models\Location')->find($this->input->post('id'));
        
        if ($this->form_validation->run() == TRUE){
            $this->session->set_flashdata('message', "location updated");
            
            $data["location"]->block = $this->input->post('block');
            $data["location"]->floor = $this->input->post('floor');
            $data["location"]->isMall = (bool)$this->input->post('isMall');
            $this->em->flush();
            redirect('locations/edit/' . $this->input->post('id') , 'refresh');
        }

        
        $this->load->view('dashboard/edit_locations', $data);             


    }
    
    public function create(){
        
        // validate the form data
        $this->form_validation->set_rules('block', 'Block', 'required');
        $this->form_validation->set_rules('floor', 'Floor', 'required');
        
        if ($this->form_validation->run() == TRUE){
            
            $this->session->set_flashdata('message', "location created");
            
            $location = new models\Location;
            $location->block = $this->input->post('block');
            $location->floor = $this->input->post('floor');
            $location->isMall = (bool)$this->input->post('isMall');
            $this->em->persist($location);
            $this->em->flush();
            
            redirect('locations/edit/' . $location->id, 'refresh');
            
            
        } else {
            
            $data["location"] = new models\location;
            $this->load->view('dashboard/edit_location', $data);
            
        }  
        
        
    }
    
    
    


}
/* End of file locations.php */
/* Location: ./application/controllers/locations.php */