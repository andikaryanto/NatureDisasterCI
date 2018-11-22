<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_village extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->database('naturevillage', TRUE);
        $this->load->model(array('Mvillage_model', 'Ggroupuser_model'));
        $this->load->library(array('paging', 'session','helpers'));
        $this->load->helper('form');
        
        $this->paging->is_session_set();
    }

    public function index()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_village'],'Read'))
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
            $resultdata = $this->Mvillage_model->get_alldata();
            $datapages = $this->Mvillage_model->get_datapages($page,  $pagesize['perpage'], $search);
            $rows = !empty($search) ? count($datapages) : count($resultdata);

            $resource = $this->Mvillage_model->set_resources();

            $data =  $this->paging->set_data_page_index($resource, $datapages, $rows, $page, $search);
            
            $this->loadview('m_village/index', $data);
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }
    }

    public function villagemodal()
    {
        $page = $this->input->post("page");
        $search = $this->input->post("search");

        $pagesize = $this->paging->get_config();
        $resultdata = $this->Mvillage_model->get_alldata();
        $datapages = $this->Mvillage_model->get_datapages($page,  $pagesize['perpagemodal'], $search);
        $rows = !empty($search) ? count($datapages) : count($resultdata);

        $resource = $this->Mvillage_model->set_resources();

        $data =  $this->paging->set_data_page_modal($resource, $datapages, $rows, $page, $search, null, 'm_village');      
        
        echo json_encode($data);
    }

    public function add()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_village'],'Write'))
        {
            $resource = $this->Mvillage_model->set_resources();
            $model = $this->Mvillage_model->create_object(null, null, null, null, null, null, null, null, null);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('m_village/add', $data);
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
        $resource = $this->Mvillage_model->set_resources();
        $name = $this->input->post('named');
        $subcityid = $this->input->post('subcityid');
        $subcityname = $this->input->post('subcityname');
        $description = $this->input->post('description');
        
        $model = $this->Mvillage_model->create_object(null, $name, $description, $subcityid, $subcityname, null, null, null, null);

        $validate = $this->Mvillage_model->validate($model);
 
        if($validate)
        {
            $this->session->set_flashdata('add_warning_msg',$validate);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('m_village/add', $data);   
        }
        else{
            $date = date("Y-m-d H:i:s");
            $newmodel = $this->Mvillage_model->create_object_tabel(null, $name, $description, $subcityid, $date, $_SESSION['userdata']['username'], null, null);
           
            $this->Mvillage_model->save_data($newmodel);
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('mvillage');
        }
    }

    public function edit($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_village'],'Write'))
        {
            $resource = $this->Mvillage_model->set_resources();
            $edit = $this->Mvillage_model->get_data_by_id($id);
            $model = $this->Mvillage_model->create_object($edit->Id, $edit->Name, $edit->Description, null, null, null, null);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('m_village/edit', $data);   
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    public function editsave()
    {
        $resource = $this->Mvillage_model->set_resources();

        $villageid = $this->input->post('idvillage');
        $name = $this->input->post('named');
        $description = $this->input->post('description');
        $subcityid = $this->input->post('subcityid');
        $subcityname = $this->input->post('subcityname');

        $edit = $this->Mvillage_model->get_data_by_id($villageid);

        $oldmodel = $this->Mvillage_model->create_object($edit->Id, $edit->Name, $edit->Description, $edit->SubcityId, $edit->SubcityName, $edit->IOn, $edit->IBy, $edit->UOn , $edit->UBy);
        $model = $this->Mvillage_model->create_object($edit->Id, $name, $description, $subcityid, $subcityname, $edit->IOn, $edit->IBy, null , null);

        $validate = $this->Mvillage_model->validate($model, $oldmodel);
 
        if($validate)
        {
            $this->session->set_flashdata('edit_warning_msg',$validate);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('m_village/edit', $data);   
        }
        else
        {
            $date = date("Y-m-d H:i:s");
            $newmodel = $this->Mvillage_model->create_object_tabel($edit->Id, $name, $description, $subcityid, $edit->IOn, $edit->IBy, $date , $_SESSION['userdata']['username']);

            $this->Mvillage_model->edit_data($newmodel);
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('mvillage');
        }
    }

    public function delete($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_village'],'Delete'))
        {
            $delete = $this->Mvillage_model->delete_data($id);
            if(isset($delete)){
                $deletemsg = $this->helpers->get_query_error_message($delete['code']);
                $this->session->set_flashdata('warning_msg', $deletemsg);
            } else {
                $deletemsg = $this->paging->get_delete_message();
                $this->session->set_flashdata('delete_msg', $deletemsg);
            }
            redirect('mvillage');
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