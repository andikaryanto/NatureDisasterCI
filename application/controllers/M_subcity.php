<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_subcity extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->database('naturesubcity', TRUE);
        $this->load->model(array('Msubcity_model', 'Ggroupuser_model'));
        $this->load->library(array('paging', 'session','helpers'));
        $this->load->helper('form');
        
        $this->paging->is_session_set();
    }

    public function index()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_subcity'],'Read'))
        {
            $page = 1;
            $search = "";
            if(!empty($_GET["page"]))
            {
                $page = $_GET["page"];
            }
            if(!empty($_GET["search"]))
            {
                $search = $_GET["search"];
            }

            $pagesize = $this->paging->get_config();
            $resultdata = $this->Msubcity_model->get_alldata();
            $datapages = $this->Msubcity_model->get_datapages($page,  $pagesize['perpage'], $search);
            $rows = !empty($search) ? count($datapages) : count($resultdata);

            $resource = $this->Msubcity_model->set_resources();

            $data =  $this->paging->set_data_page_index($resource, $datapages, $rows, $page, $search);
            
            $this->loadview('m_subcity/index', $data);
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }
    }

    public function subcitymodal()
    {
        $page = $this->input->post("page");
        $search = $this->input->post("search");

        $pagesize = $this->paging->get_config();
        $resultdata = $this->Msubcity_model->get_alldata();
        $datapages = $this->Msubcity_model->get_datapages($page,  $pagesize['perpagemodal'], $search);
        $rows = !empty($search) ? count($datapages) : count($resultdata);

        $resource = $this->Msubcity_model->set_resources();

        $data =  $this->paging->set_data_page_modal($resource, $datapages, $rows, $page, $search, null, 'm_subcity');      
        
        echo json_encode($data);
    }

    public function add()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_subcity'],'Write'))
        {
            $resource = $this->Msubcity_model->set_resources();
            $model = $this->Msubcity_model->create_object(null, null, null, null, null, null, null, null, null);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('m_subcity/add', $data);
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    public function addsave()
    {
        //$date = new DateTime();
        $warning = array();
        $err_exist = false;
        $resource = $this->Msubcity_model->set_resources();
        $name = $this->input->post('named');
        $cityid = $this->input->post('cityid');
        $cityname = $this->input->post('cityname');
        $description = $this->input->post('description');
        
        $model = $this->Msubcity_model->create_object(null, $name, $description, $cityid, $cityname, null, null, null, null);

        $validate = $this->Msubcity_model->validate($model);
 
        if($validate)
        {
            $this->session->set_flashdata('add_warning_msg',$validate);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('m_subcity/add', $data);   
        }
        else{
            $date = date("Y-m-d H:i:s");
            $newmodel = $this->Msubcity_model->create_object_tabel(null, $name, $description, $cityid, $date, $_SESSION['userdata']['username'], null, null);
           
            $this->Msubcity_model->save_data($newmodel);
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('msubcity');
        }
    }

    public function edit($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_subcity'],'Write'))
        {
            $resource = $this->Msubcity_model->set_resources();
            $edit = $this->Msubcity_model->get_data_by_id($id);
            $model = $this->Msubcity_model->create_object($edit->Id, $edit->Name, $edit->Description, null, null, null, null);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('m_subcity/edit', $data);   
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    public function editsave()
    {
        $resource = $this->Msubcity_model->set_resources();

        $subcityid = $this->input->post('idsubcity');
        $name = $this->input->post('named');
        $description = $this->input->post('description');
        $cityid = $this->input->post('cityid');
        $cityname = $this->input->post('cityname');

        $edit = $this->Msubcity_model->get_data_by_id($subcityid);

        $oldmodel = $this->Msubcity_model->create_object($edit->Id, $edit->Name, $edit->Description, $edit->CityId, $edit->CityName, $edit->IOn, $edit->IBy, $edit->UOn , $edit->UBy);
        $model = $this->Msubcity_model->create_object($edit->Id, $name, $description, $cityid, $cityname, $edit->IOn, $edit->IBy, null , null);

        $validate = $this->Msubcity_model->validate($model, $oldmodel);
 
        if($validate)
        {
            $this->session->set_flashdata('edit_warning_msg',$validate);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('m_subcity/edit', $data);   
        }
        else
        {
            $date = date("Y-m-d H:i:s");
            $newmodel = $this->Msubcity_model->create_object_tabel($edit->Id, $name, $description, $cityid, $edit->IOn, $edit->IBy, $date , $_SESSION['userdata']['username']);

            $this->Msubcity_model->edit_data($newmodel);
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('msubcity');
        }
    }

    public function delete($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_subcity'],'Delete'))
        {
            $delete = $this->Msubcity_model->delete_data($id);
            if(isset($delete)){
                $deletemsg = $this->helpers->get_query_error_message($delete['code']);
                $this->session->set_flashdata('warning_msg', $deletemsg);
            } else {
                $deletemsg = $this->paging->get_delete_message();
                $this->session->set_flashdata('delete_msg', $deletemsg);
            }
            redirect('msubcity');
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    private function loadview($viewName, $data)
	{
		$this->paging->load_header();
		$this->load->view($viewName, $data);
		$this->paging->load_footer();
    }

   
    
    
}