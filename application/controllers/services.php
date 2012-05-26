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
    protected $image_bg;

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
        $config['max_size'] = '3072';

        $this->load->library('upload', $config);   
        
        $this->load->helper('form');
        $this->load->helper('doctrine');
        $this->load->library('form_validation');
        
    }
    
		
    public function index(){
        $data['services'] = $this->em->getRepository('models\Service')->findAll();        
        $this->load->view('dashboard/services', $data);
    }    
    
    
    public function add(){
        $data["service"] = new models\Service;
        $data["interests"] = $this->em->getRepository('models\Interest')->findAll();
        $data["locations"] = $this->em->getRepository('models\Location')->findAll();
        $data["service_interests"] = array();
        $this->load->view('dashboard/edit_service', $data);
    }
    
    public function edit($id){
        $data["service"] = $this->em->getRepository('models\Service')->find($id);
        $data["interests"] = $this->em->getRepository('models\Interest')->findAll();
        $data["locations"] = $this->em->getRepository('models\Location')->findAll();
        $data["service_interests"] = getIds($data["service"]->Interests);
        $this->load->view('dashboard/edit_service', $data);
    }
    
    public function update(){
       
        $data["locations"] = $this->em->getRepository('models\Location')->findAll();
        
        // validate the form data
        $this->form_validation->set_rules('service_name', 'Service name', 'required');
        $this->form_validation->set_rules('url', 'URL', '');
        $this->form_validation->set_rules('body', 'Body Text', '');
        $this->form_validation->set_rules('image_bg', 'Service Image', 'required|callback__check_do_upload');
        $this->form_validation->set_rules('location', 'Location', 'required');
        
        $data["service"] = $this->em->getRepository('models\Service')->find($this->input->post('id'));
        $location = $this->em->getRepository('models\Location')->find($this->input->post('location'));
        $data["service_interests"] = getIds($data["service"]->Interests);
        
        if($this->input->post('interests')){
            $ids = $this->input->post('interests');
            $ids = array_map('intval', $ids); // converts array of strings to array of ints
        } else {
            $ids = array();
        }
        
        if ($this->form_validation->run() == TRUE){
            $this->session->set_flashdata('message', "service updated");
            
            $data["service"]->name = $this->input->post('service_name');
            $data["service"]->url = $this->input->post('url');
            $data["service"]->body = $this->input->post('body');
            $data["service"]->image_bg = $this->image_bg;
            $data["service"]->Location = $location;
            
            if($this->input->post('interests')){
                $data["service"]->Interests = $this->em->getRepository('models\Interest')->get_interests($ids);
            } else {
                $data["service"]->Interests = array();
            }
            
            $this->em->flush();
            redirect('services/edit/' . $this->input->post('id') , 'refresh');
        }

        
        $this->load->view('dashboard/edit_service', $data);             


    }
    
    function _check_do_upload(){
        // check if there is a file to upload
         if(isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] == 0){
             // upload the file
            if($this->upload->do_upload('image_upload')){
                // no errors with upload
                $uploadData = $this->upload->data();
                $this->image_bg = $uploadData['file_name'];
                
                // run a function on the uploaded image to see if it is the correct size
                // if not it should be scaled to size
                $errors = $this->_image_fix($this->image_bg);
                
                if($errors == ""){
                   return true;                     
                } else {
                   $this->form_validation->set_message('_check_do_upload', $errors);
                   return false;
                }
                
            } else {
                // errors with upload return the errors
                $this->image_bg = $this->input->post('image_bg');  
                $this->form_validation->set_message('_check_do_upload', $this->upload->display_errors());
                return false;
            }
        } else {
            // no file to upload set bg_image as the current image
            if($this->input->post('image_bg') != '') {
                $this->image_bg = $this->input->post('image_bg');            
                return true;
            } else {
                $this->form_validation->set_message('_check_do_upload', "A service image must be provided");            
                return false;
            }
        }
    }
    
    public function create(){
        
         $data["locations"] = $this->em->getRepository('models\Location')->findAll();
        
        // validate the form data
        $this->form_validation->set_rules('service_name', 'Service name', 'required');
        $this->form_validation->set_rules('url', 'URL', '');
        $this->form_validation->set_rules('body', 'Body Text', '');
        $this->form_validation->set_rules('image_bg', 'Service Image', 'callback__check_do_upload');
        $this->form_validation->set_rules('location', 'Location', 'required');
        
        $data["service_interests"] = array();
        
        if ($this->form_validation->run() == TRUE){
            
            $location = $this->em->getRepository('models\Location')->find($this->input->post('location'));        
            
            if($this->input->post('interests')){
                $ids = $this->input->post('interests');
                $ids = array_map('intval', $ids); // converts array of strings to array of ints
            } else {
                $ids = array();
            }
            
            $service = new models\Service;
            $service->name = $this->input->post('service_name');
            $service->url = $this->input->post('url');
            $service->body = $this->input->post('body');
            $service->image_bg = $this->image_bg;
            $service->Location = $location;
            
            if($this->input->post('interests')){
                $service->Interests = $this->em->getRepository('models\Interest')->get_days($ids);
            } else {
                $service->Interests = array();
            }
            
            $this->em->persist($service);
            $this->em->flush();
            
            redirect('services/edit/' . $service->id, 'refresh');
            
            
        } else {
            
            $data["service"] = new models\Service;
            $data["interests"] = $this->em->getRepository('models\Interest')->findAll();
            $data["locations"] = $this->em->getRepository('models\Location')->findAll();
            $this->load->view('dashboard/edit_service', $data);
            
        }  
        
        
    }
    
    private function _image_fix($file_name){
        //perform a resize operation on the image  if it is too large
        
        $config['image_library'] = 'gd2';
        $config['source_image']	= realpath('images/services/') . '/' . $file_name;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['master_dim'] = "auto";
        $config['width']	 = 307;
        $config['height']	 = 409;
        
        $this->load->library('image_lib', $config); 
        
        if(!$this->image_lib->resize()){
            return $this->image_lib->display_errors();
        } else {
            return "";
        }
        
    }
    
    


}
/* End of file services.php */
/* Location: ./application/controllers/services.php */