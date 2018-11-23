<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_maintenance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('paging', 'session','helpers'));
    }

    public function index(){
        //echo json_encode($_SESSION);
        if($_SESSION['userdata']['username'] !== "superadmin"){
        
            $data['resource'] = $this->paging->set_resources_maintenance_page();
            $this->load->view('forbidden/maintenance', $data);
        }
        else
            redirect('home');
    }
}