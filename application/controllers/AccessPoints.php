<?php

/**
 * AccessPoints
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		AccessPoints.php
 * @version		1.0
 * @date		30/04/2012
 * 
 * Copyright (c) 2012
 */
 
 
class AccessPoints extends MY_Controller {    
    
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
    
		
    public function index($id){
        $location = $this->em->getRepository('models\Location')->find($id);
        $data['id'] = $id;
        $data['location'] = $location->getLocationString();
        $data['aps'] = $location->Access_Points;
        $this->load->view('dashboard/access_points', $data);
    }    
    
    
    public function add($locationId){
        $data["ap"] = new models\Access_Point;
        $data["location"] = $locationId;
        $this->load->view('dashboard/edit_ap', $data);
    }
    
    public function edit($id){
        $data["ap"] = $this->em->getRepository('models\Access_Point')->find($id);
        $data["location"] = $data["ap"]->Location->id;
        $this->load->view('dashboard/edit_ap', $data);
    }
    
    public function update(){
        
        // validate the form data
        $this->form_validation->set_rules('bssid', 'BSSID', 'required, callback__checkBSSID');
        
        $data["ap"] = $this->em->getRepository('models\Access_Point')->find($this->input->post('id'));
        $data["location"] = $data["ap"]->Location->id;
        
        if ($this->form_validation->run() == TRUE){
            $this->session->set_flashdata('message', "Access Point updated");
            
            $data["ap"]->bssid = $this->input->post('bssid');
            $this->em->flush();
            redirect('AccessPoints/edit/' . $this->input->post('id') , 'refresh');
        }

        
        $this->load->view('dashboard/edit_ap', $data);             


    }
    
    public function _checkBSSID($val){
        if (preg_match('/^[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}$/i',$val))
        {
            return true;
        } else {
             $this->form_validation->set_message('_checkBSSID','You have entered an invalid BSSID');    
            return false;
        }
    }
    
    public function create(){
        
        // validate the form data
        $this->form_validation->set_rules('bssid', 'BSSID', 'required, callback__checkBSSID');
        
        if ($this->form_validation->run() == TRUE){
            
            $this->session->set_flashdata('message', "Access Point created");
            
            $location = $this->em->getRepository('models\Location')->find($this->input->post('location'));
            
            $ap = new models\Access_Point;
            $ap->bssid = $this->input->post('bssid');
            $ap->Location = $location;
            $this->em->persist($ap);
            $this->em->flush();
            
            redirect('AccessPoints/edit/' . $ap->id, 'refresh');
            
            
        } else {
            
            $data["ap"] = new models\Access_Point;
            $data["location"] = $this->input->post('location');
            $this->load->view('dashboard/edit_ap', $data);
            
        }  
        
        
    }
    
    
    


}
/* End of file AccessPoints.php */
/* Location: ./application/controllers/AccessPoints.php */