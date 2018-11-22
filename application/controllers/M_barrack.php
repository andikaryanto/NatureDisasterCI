<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_barrack extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->database('naturebarrack', TRUE);
        $this->load->model(array('Mbarrack_model', 'Mbarrackphotos_model', 'Ggroupuser_model'));
        $this->load->library(array('paging','session', 'ftp','ftpserver', 'helpers'));
        $this->load->helper(array('form'));
        
        $this->paging->is_session_set();
    }

    public function index()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_barrack'],'Read'))
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
            $resultdata = $this->Mbarrack_model->get_alldata();
            $datapages = $this->Mbarrack_model->get_datapages($page,  $pagesize['perpage'], $search);
            $rows = !empty($search) ? count($datapages) : count($resultdata);

            $resource = $this->Mbarrack_model->set_resources();

            $data =  $this->paging->set_data_page_index($resource, $datapages, $rows, $page, $search);
            
            $this->loadview('m_barrack/index', $data);
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
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_barrack'],'Write'))
        {
            $resource = $this->Mbarrack_model->set_resources();
            $model = $this->Mbarrack_model->create_object(null, null, null, null, null, null, null);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('m_barrack/add', $data);
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
        $resource = $this->Mbarrack_model->set_resources();
        $name = $this->input->post('named');
        $description = $this->input->post('description');

        $model = $this->Mbarrack_model->create_object(null, $name, $description, null, null, null, null);

        $validate = $this->Mbarrack_model->validate($model);
 
        if($validate)
        {
            $this->session->set_flashdata('add_warning_msg',$validate);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('m_barrack/add', $data);   
        }
        else{
            $date = date("Y-m-d H:i:s");
            $model['ion'] = $date;
            $model['iby'] = $_SESSION['userdata']['username'];
    
            $this->Mbarrack_model->save_data($model);
            $newdata = $this->Mbarrack_model->get_data_by_name($model['name']);

            if(isset($_FILES))
            {
                foreach($_FILES[ 'file' ][ 'name' ] as $index => $filename )
                {
                    $tempname = $_FILES['file']['tmp_name'][$index];
                    $type = (string)$_FILES['file']['type'][$index];
                    $barackphotosmodel = $this->Mbarrackphotos_model->create_object(null, $newdata->Id, (string)$filename, $type, "/Stills/MyOwn",  $date, $_SESSION['userdata']['username'], null, null);
                    $this->Mbarrackphotos_model->save_data($barackphotosmodel);
                    $this->doUpload($tempname, $this->helpers->rename_file($filename, (string)$date));
                    //echo $this->helpers->rename_file($filename, (string)$date);

                }
            }
            
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('mbarrack');
        }
    }

    public function edit($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_barrack'],'Write'))
        {
            $resource = $this->Mbarrack_model->set_resources();
            $edit = $this->Mbarrack_model->get_data_by_id($id);
            $model = $this->Mbarrack_model->create_object($edit->Id, $edit->Name, $edit->Description, null, null, null, null);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('m_barrack/edit', $data);   
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    public function editsave()
    {
        $resource = $this->Mbarrack_model->set_resources();

        $barrackid = $this->input->post('idbarrack');
        $name = $this->input->post('named');
        $description = $this->input->post('description');

        $edit = $this->Mbarrack_model->get_data_by_id($barrackid);

        $oldmodel = $this->Mbarrack_model->create_object($edit->Id, $edit->Name, $edit->Description, $edit->IOn, $edit->IBy, $edit->UOn , $edit->UBy);
        $model = $this->Mbarrack_model->create_object($edit->Id, $name, $description, $edit->IOn, $edit->IBy, null , null);

        $validate = $this->Mbarrack_model->validate($model, $oldmodel);
 
        if($validate)
        {
            $this->session->set_flashdata('edit_warning_msg',$validate);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('m_barrack/edit', $data);   
        }
        else
        {
            $date = date("Y-m-d H:i:s");
            $model['uon'] = $date;
            $model['uby'] = $_SESSION['userdata']['username'];

            $this->Mbarrack_model->edit_data($model);
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('mbarrack');
        }
    }

    public function delete($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['m_barrack'],'Delete'))
        {
            $delete = $this->Mbarrack_model->delete_data($id);
            if(isset($delete)){
                $deletemsg = $this->helpers->get_query_error_message($delete['code']);
                $this->session->set_flashdata('warning_msg', $deletemsg);
            } else {
                $deletemsg = $this->paging->get_delete_message();
                $this->session->set_flashdata('delete_msg', $deletemsg);
            }
            redirect('mbarrack');
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    private function doUpload($localpath, $name){
        $config = $this->ftpserver->get_server_config();
        $this->ftp->connect($config);
        $this->ftp->upload($localpath, '/Stills/MyOwn/'.$name, 'ascii', 0775);
        $this->ftp->close();
    }

    private function loadview($viewName, $data)
	{
		$this->paging->load_header();
		$this->load->view($viewName, $data);
		$this->paging->load_footer();
    }

   
    
    
}