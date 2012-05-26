<?php

/**
 * Schedules
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
 * @date		1/05/2012
 * 
 * Copyright (c) 2012
 */
 
 
class Schedules extends MY_Controller {    
    
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
         $this->load->helper('doctrine');
         $this->load->library('form_validation');
        
    }
    
		
    public function index($serviceId){
        $data['service'] = $this->em->getRepository('models\Service')->find($serviceId);        
        $this->load->view('dashboard/schedule', $data);
    }    
    
    
    public function add($serviceId){
        $data['service'] = $this->em->getRepository('models\Service')->find($serviceId);
        $data["days"] = $this->em->getRepository('models\Day')->findAll();
        $data["schedule"] = new models\Schedule;
        $data["scheduled_days"] = array();
        $this->load->view('dashboard/edit_schedule', $data);
    }
    
    public function edit($id){
        $data["schedule"] = $this->em->getRepository('models\Schedule')->find($id);
        $data["days"] = $this->em->getRepository('models\Day')->findAll();
        $data['service'] = $data["schedule"]->Service;
        $data["scheduled_days"] = getIds($data["schedule"]->Days);
        
        $this->load->view('dashboard/edit_schedule', $data);
    }
    
    public function update(){
        
        // validate the form data
        $start_date = base64_encode(serialize($this->input->post('start_date')));
        $recurring = serialize((bool)$this->input->post('isRecurring'));

        
        $this->form_validation->set_rules('start_date[]', 'Start Date', '');
        $this->form_validation->set_rules('start_date', 'Start Date', 'callback__check_date');
        $this->form_validation->set_rules('end_date[]', 'End Date', '');
        $this->form_validation->set_rules('end_date', 'End Date', "callback__check_date|callback__check_range[' . $start_date . ']");
        $this->form_validation->set_rules('start_time[]', 'Start Time', '');
        $this->form_validation->set_rules('start_time', 'Start Time', '');
        $this->form_validation->set_rules('end_time[]', 'End Time', '');
        $this->form_validation->set_rules('end_time', 'End Time', '');
        $this->form_validation->set_rules('null_end', '', '');
        $this->form_validation->set_rules('isRecurring', 'Recurring Daily', '');
        $this->form_validation->set_rules('days[]', 'Days', '');
        $this->form_validation->set_rules('days', 'Days', 'callback__check_days[' . $recurring . ']');
        
        $data["schedule"] = $this->em->getRepository('models\Schedule')->find($this->input->post('id'));
        $data["service"] = $data["schedule"]->Service;
        $data["days"] = $this->em->getRepository('models\Day')->findAll();
       
        
        $data["scheduled_days"] = getIds($data["schedule"]->Days);
        
        if ($this->form_validation->run() == TRUE){
            $this->session->set_flashdata('message', "Schedule updated");
            
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $start_time = $this->input->post('start_time');
            $end_time = $this->input->post('end_time');
            
            if($this->input->post('days')){
                $ids = $this->input->post('days');
                $ids = array_map('intval', $ids); // converts array of strings to array of ints
            } else {
                $ids = array();
            }
            
            
            $data["schedule"]->start_date = new DateTime(date('c', mktime(0,0,0,$start_date[1],$start_date[0],$start_date[2])));
            if($this->input->post('null_end')){
                $data["schedule"]->end_date = null;
            } else {
                $data["schedule"]->end_date = new DateTime(date('c', mktime(0,0,0,$end_date[1],$end_date[0],$end_date[2])));
            }
            $data["schedule"]->start_time = new DateTime(date('c', mktime($start_time[0],$start_time[1],0,1,1,2000)));
            $data["schedule"]->end_time = new DateTime(date('c', mktime($end_time[0],$end_time[1],0,1,1,2000)));            
            $data["schedule"]->isRecurring = (bool)$this->input->post('isRecurring');
            
            if($this->input->post('days')){
                $data["schedule"]->Days = $this->em->getRepository('models\Day')->get_days($ids);
            } else {
                $data["schedule"]->Days = array();
            }
            
            $this->em->flush();
            redirect('schedules/edit/' . $this->input->post('id') , 'refresh');
        }

        
        $this->load->view('dashboard/edit_schedule', $data);


    }
    
    function _check_date($dateArr){        
        // function takes date array and confirms that it is a valid date
        if(checkdate((int)$dateArr[1],(int)$dateArr[0],(int)$dateArr[2])){
            // valid  
            return true;
        } else {
            // invalid
            $this->form_validation->set_message('_check_date', "%s is not a valid date");
            return false;
        }
    }
    
    function _check_range($end, $start){
        // function takes two date arrays and 
        // confirms the end date, happens on or after the start date
        
        if(!$this->input->post("null_end")){
            $start = unserialize(base64_decode($start));

            $s_date = mktime(0,0,0,$start[1],$start[0],$start[2]);
            $e_date = mktime(0,0,0,$end[1],$end[0],$end[2]);

            if($e_date >= $s_date){
                // valid range
                return true;
            } else {
                //invalid range
                $this->form_validation->set_message('_check_range', "The start date must occur before or on the end date");
                return false;            
            }    
        } else {
            return true;
        }
        
        
        
    }
    
    function _check_days($days,$isRecurring){
        
        $isRecurring = unserialize($isRecurring);
                
        if($isRecurring === true){            
            if(count($days) > 0){                
                // at least one day has been checked
                return true;
            } else {
                $this->form_validation->set_message('_check_days', "Recurring services must have at least one day selected");
                return false;
            }
            
        } else {
            // not a recurring service, nothing to check
            return true;
        }
        
        
    }
    
    public function create($serviceId){
        
        // validate the form data
        $start_date = base64_encode(serialize($this->input->post('start_date')));
        $recurring = serialize((bool)$this->input->post('isRecurring'));

        
        $this->form_validation->set_rules('start_date[]', 'Start Date', '');
        $this->form_validation->set_rules('start_date', 'Start Date', 'callback__check_date');
        $this->form_validation->set_rules('end_date[]', 'End Date', '');
        $this->form_validation->set_rules('end_date', 'End Date', "callback__check_date|callback__check_range[' . $start_date . ']");
        $this->form_validation->set_rules('start_time[]', 'Start Time', '');
        $this->form_validation->set_rules('start_time', 'Start Time', '');
        $this->form_validation->set_rules('end_time[]', 'End Time', '');
        $this->form_validation->set_rules('end_time', 'End Time', '');
        $this->form_validation->set_rules('null_end', '', '');
        $this->form_validation->set_rules('isRecurring', 'Recurring Daily', '');
        $this->form_validation->set_rules('days[]', 'Days', '');
        $this->form_validation->set_rules('days', 'Days', 'callback__check_days[' . $recurring . ']');
        
        if ($this->form_validation->run() == TRUE){
            $this->session->set_flashdata('message', "Schedule Created");
            
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $start_time = $this->input->post('start_time');
            $end_time = $this->input->post('end_time');
            
            if($this->input->post('days')){
                $ids = $this->input->post('days');
                $ids = array_map('intval', $ids); // converts array of strings to array of ints
            } else {
                $ids = array();
            }
            
            $schedule = new models\Schedule;
            $schedule->start_date = new DateTime(date('c', mktime(0,0,0,$start_date[1],$start_date[0],$start_date[2])));
            if($this->input->post('null_end')){
                $schedule->end_date = null;
            } else {
                $schedule->end_date = new DateTime(date('c', mktime(0,0,0,$end_date[1],$end_date[0],$end_date[2])));
            }
            $schedule->start_time = new DateTime(date('c', mktime($start_time[0],$start_time[1],0,1,1,2000)));
            $schedule->end_time = new DateTime(date('c', mktime($end_time[0],$end_time[1],0,1,1,2000)));
            $schedule->end_time = new DateTime(date('c', mktime($end_time[0],$end_time[1],0,1,1,2000)));            
            $schedule->isRecurring = (bool)$this->input->post('isRecurring');
            $schedule->Service = $this->em->getRepository('models\Service')->find($serviceId);
            
            if($this->input->post('days')){
                $schedule->Days = $this->em->getRepository('models\Day')->get_days($ids);
            } else {
                $schedule->Days = array();
            }
            
            $this->em->persist($schedule);
            $this->em->flush();
            redirect('schedules/edit/' . $schedule->id , 'refresh');
        } else {
            
            $data['service'] = $this->em->getRepository('models\Service')->find($serviceId);
            $data["days"] = $this->em->getRepository('models\Day')->findAll();
            $data["schedule"] = new models\Schedule;
            $data["scheduled_days"] = array();
            $this->load->view('dashboard/edit_schedule', $data);
            
        }

        
        
        
        
    }
    
    
    


}
/* End of file locations.php */
/* Location: ./application/controllers/locations.php */