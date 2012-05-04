<?php

/**
 * Interests
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		interests.php
 * @version		1.0
 * @date		30/04/2012
 * 
 * Copyright (c) 2012
 */
 
 
class Interests extends MY_Controller {    
    
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
        $data['interests'] = $this->em->getRepository('models\Interest')->findAll();        
        $this->load->view('dashboard/interest', $data);
    }    
    
    
    public function add(){
        $data["interest"] = new models\Interest;
        $this->load->view('dashboard/edit_interest', $data);
    }
    
    public function edit($id){
        $data["interest"] = $this->em->getRepository('models\Interest')->find($id);
        $this->load->view('dashboard/edit_interest', $data);
    }
    
    public function update(){
        
        // validate the form data
        $this->form_validation->set_rules('interest_name', 'Interest name', 'required');
        
        $data["interest"] = $this->em->getRepository('models\Interest')->find($this->input->post('id'));
        
        if ($this->form_validation->run() == TRUE){
            $this->session->set_flashdata('message', "interest updated");
            
            $data["interest"]->name = $this->input->post('interest_name');
            $this->em->flush();
            redirect('interests/edit/' . $this->input->post('id') , 'refresh');
        }

        
        $this->load->view('dashboard/edit_interest', $data);             


    }
    
    public function create(){
        
        // validate the form data
        $this->form_validation->set_rules('interest_name', 'Interest name', 'required');
        
        if ($this->form_validation->run() == TRUE){
            
            $this->session->set_flashdata('message', "interest created");
            
            $interest = new models\Interest;
            $interest->name = $this->input->post('interest_name');
            $this->em->persist($interest);
            $this->em->flush();
            
            redirect('interests/edit/' . $interest->id, 'refresh');
            
            
        } else {
            
            $data["interest"] = new models\Interest;
            $this->load->view('dashboard/edit_interest', $data);
            
        }  
        
        
    }
    
    
    


}
/* End of file interests.php */
/* Location: ./application/controllers/interest.php */