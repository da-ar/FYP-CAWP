<?php

/**
 * Services
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		services.php
 * @version		1.0
 * @date		30/04/2012
 * 
 * Copyright (c) 2012
 */
 
 
class Services extends MY_Controller {    
    
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
        
        $config['upload_path'] = realpath('images/services/');
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '100';
        $config['max_width']  = '307';
        $config['max_height']  = '768';

        $this->load->library('upload', $config);   
        
        
         $this->load->helper('form');
         $this->load->library('form_validation');
        
    }
    
		
    public function index(){
        $data['services'] = $this->em->getRepository('models\Service')->findAll();        
        $this->load->view('dashboard/services', $data);
    }    
    
    
    public function add(){
        $data["service"] = new models\Service;
        $data["locations"] = $this->em->getRepository('models\Location')->findAll();
        $this->load->view('dashboard/edit_service', $data);
    }
    
    public function edit($id){
        $data["service"] = $this->em->getRepository('models\Service')->find($id);
        $data["locations"] = $this->em->getRepository('models\Location')->findAll();
        $this->load->view('dashboard/edit_service', $data);
    }
    
    public function update(){
        
        if($this->input->post('image_upload')){        
            if($this->upload->do_upload('image_upload')){
                $uploadData = $this->upload->data();
                $image_bg = $uploadData['file_name'];
            }
        } else {
            $image_bg = $this->input->post('image_bg');            
        }
        
        // validate the form data
        $this->form_validation->set_rules('service_name', 'Service name', 'required');
        $this->form_validation->set_rules('url', 'URL', '');
        $this->form_validation->set_rules('body', 'Body Text', '');
        $this->form_validation->set_rules('image_bg', 'Service Image', '');
        $this->form_validation->set_rules('location', 'Location', 'required');
        
        $data["service"] = $this->em->getRepository('models\Service')->find($this->input->post('id'));
        $location = $this->em->getRepository('models\Location')->find($this->input->post('location'));
        
        if ($this->form_validation->run() == TRUE){
            $this->session->set_flashdata('message', "service updated");
            
            $data["service"]->name = $this->input->post('service_name');
            $data["service"]->url = $this->input->post('url');
            $data["service"]->body = $this->input->post('body');
            $data["service"]->image_bg = $image_bg;
            $data["service"]->Location = $location;
            $this->em->flush();
            redirect('services/edit/' . $this->input->post('id') , 'refresh');
        }

        
        $this->load->view('dashboard/edit_service', $data);             


    }
    
    public function create(){
        
        if($this->input->post('image_upload')){        
            if($this->upload->do_upload('image_upload')){
                $uploadData = $this->upload->data();
                $image_bg = $uploadData['file_name'];
            }
        } else {
            $image_bg = $this->input->post('image_bg');            
        }
        
        // validate the form data
        $this->form_validation->set_rules('service_name', 'Service name', 'required');
        $this->form_validation->set_rules('url', 'URL', '');
        $this->form_validation->set_rules('body', 'Body Text', '');
        $this->form_validation->set_rules('image_bg', 'Service Image', '');
        $this->form_validation->set_rules('location', 'Location', 'required');
        
        if ($this->form_validation->run() == TRUE){
            
            $this->session->set_flashdata('message', "location created");
            $location = $this->em->getRepository('models\Location')->find($this->input->post('location'));        
            
            $service = new models\Service;
            $service->name = $this->input->post('service_name');
            $service->url = $this->input->post('url');
            $service->body = $this->input->post('body');
            $service->image_bg = $image_bg;
            $service->Location = $location;
            $this->em->persist($service);
            $this->em->flush();
            
            redirect('services/edit/' . $service->id, 'refresh');
            
            
        } else {
            
            $data["service"] = new models\Service;
            $data["locations"] = $this->em->getRepository('models\Location')->findAll();
            $this->load->view('dashboard/edit_service', $data);
            
        }  
        
        
    }
    
    
    


}
/* End of file services.php */
/* Location: ./application/controllers/services.php */