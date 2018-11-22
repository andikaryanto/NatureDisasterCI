<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class T_disasteroccur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Tdisasteroccur_model', 'Ggroupuser_model', 'Gtransactionnumber_model'));
        $this->load->library(array('paging', 'session','helpers'));
        $this->load->helper('form');
        
        $this->paging->is_session_set();
    }

    public function index()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['t_disasteroccur'],'Read'))
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
            $resultdata = $this->Tdisasteroccur_model->get_alldata();
            $datapages = $this->Tdisasteroccur_model->get_datapages($page,  $pagesize['perpage'], $search);
            $rows = !empty($search) ? count($datapages) : count($resultdata);

            $resource = $this->Tdisasteroccur_model->set_resources();

            $data =  $this->paging->set_data_page_index($resource, $datapages, $rows, $page, $search);
            
            $this->loadview('t_disasteroccur/index', $data);
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }
    }

    public function getalldata(){
        $resultdata = $this->Tdisasteroccur_model->get_alldata();
        echo json_encode($resultdata);
    }

    public function add()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['t_disasteroccur'],'Write'))
        {
            $resource = $this->Tdisasteroccur_model->set_resources();
            $model = $this->Tdisasteroccur_model->create_object(null, null, null, null, null, 
                                                                null, null, null, null, null, 
                                                                null, null, null, null, null,
                                                                null, null, null, null);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('t_disasteroccur/add', $data);
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
        
        $form = $this->paging->get_form_name_id();
        $warning = array();
        $err_exist = false;
        $resource = $this->Tdisasteroccur_model->set_resources();
        $disasterid = $this->input->post('disasterid');
        $disastername = $this->input->post('disastername');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        $villageid = $this->input->post('villageid');
        $villagename = $this->input->post('villagename');
        $rt = $this->input->post('rt');
        $rw = $this->input->post('rw');
        $isneedlogistic = $this->input->post('isneedlogistic');
        if(empty($isneedlogistic)){
            $isneedlogistic = 0;
        }
        $description = $this->input->post('description');
        

        $model = $this->Tdisasteroccur_model->create_object(null, $disasterid, $disastername, null, $latitude, $longitude, 
                                                                $villageid, $rt, $rw, $isneedlogistic, $description, 
                                                                $villagename, null, null, null, 
                                                                null, null, null, null);

        $validate = $this->Tdisasteroccur_model->validate($model);
 
        if($validate)
        {
            $this->session->set_flashdata('add_warning_msg',$validate);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('t_disasteroccur/add', $data);   
        }
        else{
            

            $date = date("Y-m-d H:i:s");
            $transNo = $this->Gtransactionnumber_model->getLastNumberByFormId($form['t_disasteroccur'], date("Y"), date("m"));
            $newModel = $this->Tdisasteroccur_model->create_object_tabel(null, $disasterid, $transNo, $latitude, $longitude, 
                                                                    $villageid, $rt, $rw, $isneedlogistic, $description, 
                                                                    $date, $_SESSION['userdata']['username'], null, null);
            $this->Tdisasteroccur_model->save_data($newModel);
            $this->Gtransactionnumber_model->updateLastNumber($form['t_disasteroccur'], date("Y"), date("m"));
            $insertedData = $this->Tdisasteroccur_model->get_data_by_nodisaster($transNo);

            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);

            redirect('tdisasteroccur/edit/'.$insertedData->Id);
        }
    }

    public function edit($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['t_disasteroccur'],'Write'))
        {
            $resource = $this->Tdisasteroccur_model->set_resources();
            $edit = $this->Tdisasteroccur_model->get_data_by_id($id);
            $model = $this->Tdisasteroccur_model->create_object($edit->Id,$edit->DisasterId,$edit->DisasterName, $edit->NoDisaster, 
                                                                    $edit->Latitude, $edit->Longitude, $edit->VillageId, 
                                                                    $edit->RT, $edit->RW, $edit->IsNeedLogistic, $edit->Description,
                                                                    $edit->VillageName, $edit->SubcityName, $edit->CityName, $edit->ProvinceName,
                                                                    $edit->IOn, $edit->IBy, $edit->UOn, $edit->UBy);
            //echo json_encode($model);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('t_disasteroccur/edit', $data);   
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    public function editsave()
    {
        $resource = $this->Tdisasteroccur_model->set_resources();

        $disasteroccurid = $this->input->post('disasteroccurid');
        $disasterid = $this->input->post('disasterid');
        $disastername = $this->input->post('disastername');
        $nodisaster = $this->input->post('nodisaster');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        $villageid = $this->input->post('villageid');
        $villagename = $this->input->post('villagename');
        $rt = $this->input->post('rt');
        $rw = $this->input->post('rw');
        $isneedlogistic = $this->input->post('isneedlogistic');
        if(empty($isneedlogistic)){
            $isneedlogistic = 0;
        }
        $description = $this->input->post('description');
        //echo $isneedlogistic;
        $edit = $this->Tdisasteroccur_model->get_data_by_id($disasteroccurid);

        $oldmodel = $this->Tdisasteroccur_model->create_object($edit->Id,$edit->DisasterId,$edit->DisaserName, $edit->NoDisaster, 
                                                                $edit->Latitude, $edit->Longitude, $edit->VillageId, 
                                                                $edit->RT, $edit->RW, $edit->IsNeedLogistic, $edit->Description,
                                                                $edit->VillageName, $edit->SubcityName, $edit->CityName, $edit->Provincename,
                                                                $edit->IOn, $edit->IBy, $edit->UOn, $edit->UBy);

        
        $model = $this->Tdisasteroccur_model->create_object(null, $disasterid, $disastername, $nodisaster, $latitude, $longitude, 
                                                                $villageid, $rt, $rw, $isneedlogistic, $description, 
                                                                $villagename, null, null, null, 
                                                                null, null, null, null);
        
        
        $validate = $this->Tdisasteroccur_model->validate($model, $oldmodel);
 
        if($validate)
        {
            $this->session->set_flashdata('add_warning_msg',$validate);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('t_disasteroccur/edit', $data);   
        }
        else
        {
            $date = date("Y-m-d H:i:s");
            
            $newModel = $this->Tdisasteroccur_model->create_object_tabel($edit->Id, $disasterid, $edit->NoDisaster, $latitude, $longitude, 
                                                                    $villageid, $rt, $rw, $isneedlogistic, $description, 
                                                                    $edit->IOn, $edit->IBy, $date, $_SESSION['userdata']['username']);

            $this->Tdisasteroccur_model->edit_data($newModel);
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('tdisasteroccur');
        }
    }

    public function delete($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['t_disasteroccur'],'Delete'))
        {
            $delete = $this->Tdisasteroccur_model->delete_data($id);
            if(isset($delete)){
                $deletemsg = $this->helpers->get_query_error_message($delete['code']);
                $this->session->set_flashdata('warning_msg', $deletemsg);
            } else {
                $deletemsg = $this->paging->get_delete_message();
                $this->session->set_flashdata('delete_msg', $deletemsg);
            }
            redirect('tdisasteroccur');
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