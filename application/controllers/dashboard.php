<?php

/**
 * Dashboard
 * 
 * Description
 * 
 * @license		GNU General Public License
 * @author		Dave Armstrong
 * @link		http://www.about.me/armstrod
 * @email		armstrong-d4@ulster.ac.uk
 * 
 * @file		dashboard.php
 * @version		1.0
 * @date		23/03/2012
 * 
 * Copyright (c) 2012
 */
 
 
class Dashboard extends MY_Controller {    
    
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
        if($this->ion_auth->is_group('service_user')){
            // service owners can only see and edit their own services
            redirect('dashboard/services', 'refresh');
        }
        $this->load->view('dashboard/index');
    }
    
    
    public function services(){
        $data['services'] = $this->em->getRepository('models\Service')->findAll();
        $this->load->view('dashboard/service', $data);
    }
    
    public function locations(){
        $data['locations'] = $this->em->getRepository('models\Location')->findAll();
        
        $this->load->view('dashboard/location', $data);
    }
    
    
    public function interests(){
        $data['interests'] = $this->em->getRepository('models\Interest')->findAll();
        
        $this->load->view('dashboard/interest', $data);
    }


}
/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */