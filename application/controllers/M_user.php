<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->database('natureuser', TRUE);
        $this->load->model(array('Muser_model','Ggroupuser_model'));
        $this->load->library(array('paging', 'session','helpers'));
        $this->load->helper('form');
        $this->paging->is_session_set();
    }

    public function index()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_user'],'Read'))
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
            $resultdata = $this->Muser_model->get_alldata();
            $datapages = $this->Muser_model->get_datapages($page,  $pagesize['perpage'], $search);
            
            $rows = !empty($search) ? count($datapages) : count($resultdata);

            $resource = $this->Muser_model->set_resources();

            $data =  $this->paging->set_data_page_index($resource, $datapages, $rows, $page, $search);
            
            $this->loadview('m_user/index', $data);
        }
       else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }
    }

    public function add()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_user'],'Write'))
        {
            $resource = $this->Muser_model->set_resources();
            $model = $this->Muser_model->create_object(null, null,null, null, null, null, null, null, null);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('m_user/add', $data);   
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
        $resource = $this->Muser_model->set_resources();
        $groupid = $this->input->post('groupid');
        $groupname = $this->input->post('groupname');
        $username = $this->input->post('named');
        $password = $this->input->post('password');
        //echo  $username;
        $model  = $this->Muser_model->create_object(null,$groupid, $groupname, $username, $password, null, null, null, null);
        $modeltabel = $this->Muser_model->create_object_tabel(null, $groupid, $username, $password, null, null, null , null);

        $validate = $this->Muser_model->validate($model);
 
        if($validate)
        {
            $this->session->set_flashdata('add_warning_msg',$validate);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('m_user/add', $data);   
        }
        else{
            $date = date("Y-m-d H:i:s");
            $modeltabel['ion'] = $date;
            $modeltabel['iby'] = $_SESSION['userdata']['username'];
    
            $this->Muser_model->save_data($model);
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('muser');
        }
    }

    public function edit($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_user'],'Write'))
        {
            $resource = $this->Muser_model->set_resources();
            $edit = $this->Muser_model->get_data_by_id($id);
            $model = $this->Muser_model->create_object($edit->Id, $edit->GroupId, $edit->GroupName, $edit->UserName, $edit->Password, null, null, null, null);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            //echo json_encode($edit);
            $this->loadview('m_user/edit', $data);   
        }
        else{
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }
    }

    public function editsave()
    {
        $resource = $this->Muser_model->set_resources();

        $userid = $this->input->post('userid');
        $groupid = $this->input->post('groupid');
        $groupname = $this->input->post('groupname');
        $username = $this->input->post('named');
        $password = $this->input->post('password');

        $edit = $this->Muser_model->get_data_by_id($userid);
        $model = $this->Muser_model->create_object($edit->Id, $groupid, $groupname, $username,  $password, $edit->IOn, $edit->IBy, null , null);
        $oldmodel = $this->Muser_model->create_object($edit->Id, $edit->GroupId, null, $edit->UserName,  $edit->Password, $edit->IOn, $edit->IBy, $edit->UOn , $edit->UBy);
        $modeltabel = $this->Muser_model->create_object_tabel($edit->Id, $groupid, $username, $password, $edit->IOn, $edit->IBy, null , null);

        $validate = $this->Muser_model->validate($model, $oldmodel);
 
        if($validate)
        {
            $this->session->set_flashdata('edit_warning_msg',$validate);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('m_user/edit', $data);   
        }
        else
        {
            $date = date("Y-m-d H:i:s");
            $modeltabel['uon'] = $date;
            $modeltabel['uby'] = $_SESSION['userdata']['username'];

            $this->Muser_model->edit_data($modeltabel);
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('muser');
        }
    }

    public function delete($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_user'],'Delete'))
        {
            $delete = $this->Muser_model->delete_data($id);
            if(isset($delete)){
                $deletemsg = $this->helpers->get_query_error_message($delete['code']);
                $this->session->set_flashdata('warning_msg', $deletemsg);
            } else {
                $deletemsg = $this->paging->get_delete_message();
                $this->session->set_flashdata('delete_msg', $deletemsg);
            }
            redirect('muser');
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    public function activate($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_user'],'Write'))
        {
            $this->Muser_model->activate_data($id);
            redirect('muser');
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    public function changePassword(){
        $model = array(
            'oldpassword' => "",
            'newpassword' => "",
            'confirmpassword' => ""
        );

        $resource = $this->Muser_model->set_resources();
        $data =  $this->paging->set_data_page_add($resource);
        $this->loadview('m_user/changePassword', $data);    
    }

    public function saveNewPassword(){
        
        $oldpassword = $this->input->post('oldpassword');
        $newpassword = $this->input->post('newpassword');
        $confirmpassword = $this->input->post('confirmpassword');
        $model = array(
            'oldpassword' => $oldpassword,
            'newpassword' => $newpassword,
            'confirmpassword' =>  $confirmpassword
        );
        
        $resource = $this->Muser_model->set_resources();
        $validate = $this->Muser_model->validate_changepassword($_SESSION['userdata']['username'], $oldpassword, $newpassword, $confirmpassword);
        if($validate){
            $this->session->set_flashdata('warning_msg',$validate);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('m_user/changePassword', $data);    
        }
        else{
            $this->Muser_model->saveNewPassword($_SESSION['userdata']['username'], $oldpassword, $newpassword);
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('home');
        }
    }

    private function loadview($viewName, $data)
	{
		$this->paging->load_header();
		$this->load->view($viewName, $data);
		$this->paging->load_footer();
    }
    
}