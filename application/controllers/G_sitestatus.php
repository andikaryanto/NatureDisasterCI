<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class G_sitestatus extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Genum_model', 'Ggroupuser_model', 'Gsitestatus_model'));
        $this->load->library(array('paging', 'session','helpers'));

        $this->paging->is_session_set();
    }

    public function index(){
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_animal'],'Read'))
        {
            $object = $this->Gsitestatus_model->get_alldata();
            $model = $this->Gsitestatus_model->create_object($object->Id, $object->Status);
            $enum =  $this->paging->get_enum_name();
            $resource = $this->Gsitestatus_model->set_resources();
            $enums['sitestatusenum'] = $this->Genum_model->get_data_by_id($enum['sitestatus']);
            $data =  $this->paging->set_data_page_add($resource, $model, $enums);
            $this->loadview('g_sitestatus/index', $data);
        }
    }

    public function editsave(){
        
        $status = $this->input->post('status');
        //$model = $this->Gsitestatus_model->create_object(null, $status);
        $this->Gsitestatus_model->edit_data($status);
        $successmsg = $this->paging->get_success_message();
        $this->session->set_flashdata('success_msg', $successmsg);
        redirect('sitestatus');
    }

    public function maintenance(){
        $this->load->view('forbidden/maintenance');
    }

    private function loadview($viewName, $data)
	{
		$this->paging->load_header();
		$this->load->view($viewName, $data);
		$this->paging->load_footer();
    }

}