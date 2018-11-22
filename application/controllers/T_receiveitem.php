<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class T_receiveitem extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Treceiveitem_model', 'Ggroupuser_model', 'Muomconvertion_model', 'Gtransactionnumber_model'));
        $this->load->library(array('paging', 'session','helpers'));
        $this->load->helper('form');
        
        $this->paging->is_session_set();
    }

    public function index()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['t_receiveitem'],'Read'))
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
            $resultdata = $this->Treceiveitem_model->get_alldata();
            $datapages = $this->Treceiveitem_model->get_datapages($page,  $pagesize['perpage'], $search);
            $rows = !empty($search) ? count($datapages) : count($resultdata);

            $resource = $this->Treceiveitem_model->set_resources();

            $data =  $this->paging->set_data_page_index($resource, $datapages, $rows, $page, $search);
            
            $this->loadview('t_receiveitem/index', $data);
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }
    }

    public function receiveitemmodal()
    {
        $page = $this->input->post("page");
        $search = $this->input->post("search");

        $pagesize = $this->paging->get_config();
        $resultdata = $this->Treceiveitem_model->get_alldata();
        $datapages = $this->Treceiveitem_model->get_datapages($page,  $pagesize['perpagemodal'], $search);
        $rows = !empty($search) ? count($datapages) : count($resultdata);

        $resource = $this->Treceiveitem_model->set_resources();

        $data =  $this->paging->set_data_page_modal($resource, $datapages, $rows, $page, $search, null, 't_receiveitem');      
        
        echo json_encode($data);
    }

    public function add()
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['t_receiveitem'],'Write'))
        {
            $resource = $this->Treceiveitem_model->set_resources();
            $model = $this->Treceiveitem_model->create_object(null, null, null, null, null, null, null, null, null);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('t_receiveitem/add', $data);
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
        $resource = $this->Treceiveitem_model->set_resources();
        $receivedate = $this->input->post('receivedate') === "" ? null : date("Y-m-d H:i:s", strtotime($this->input->post('receivedate')));
        
        $model = $this->Treceiveitem_model->create_object(null, null, $receivedate, null, null, null, null);

        $validate = $this->Treceiveitem_model->validate($model);
 
        if($validate)
        {
            $this->session->set_flashdata('add_warning_msg',$validate);
            $data =  $this->paging->set_data_page_add($resource, $model);
            $this->loadview('t_receiveitem/add', $data);   
        }
        else{
            
            $date = date("Y-m-d H:i:s");

            $receiveno = $this->Gtransactionnumber_model->getLastNumberByFormId($form['t_receiveitem'], date("Y"), date("m"));
            $newmodel = $this->Treceiveitem_model->create_object_tabel(null, $receiveno, $receivedate, $date, $_SESSION['userdata']['username'], null, null);
           
            $this->Treceiveitem_model->save_data($newmodel);
            $this->Gtransactionnumber_model->updateLastNumber($form['t_receiveitem'], date("Y"), date("m"));
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('treceiveitem');
        }
    }

    public function edit($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['t_receiveitem'],'Write'))
        {
            $resource = $this->Treceiveitem_model->set_resources();
            $edit = $this->Treceiveitem_model->get_data_by_id($id);
            $model = $this->Treceiveitem_model->create_object($edit->Id, $edit->Name, $edit->Description,$edit->UomId, $edit->UoMName, null, null, null, null);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('t_receiveitem/edit', $data);   
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    public function editsave()
    {
        $resource = $this->Treceiveitem_model->set_resources();

        $itemid = $this->input->post('itemid');
        $name = $this->input->post('named');
        $description = $this->input->post('description');
        $uomid = $this->input->post('uomid');
        $uomname = $this->input->post('uomname');

        $edit = $this->Treceiveitem_model->get_data_by_id($itemid);

        $oldmodel = $this->Treceiveitem_model->create_object($edit->Id, $edit->Name, $edit->Description, $edit->UomId, $edit->UoMName, $edit->IOn, $edit->IBy, $edit->UOn , $edit->UBy);
        $model = $this->Treceiveitem_model->create_object($edit->Id, $name, $description, $uomid, $uomname, $edit->IOn, $edit->IBy, null , null);

        $validate = $this->Treceiveitem_model->validate($model, $oldmodel);
 
        if($validate)
        {
            $this->session->set_flashdata('edit_warning_msg',$validate);
            $data =  $this->paging->set_data_page_edit($resource, $model);
            $this->loadview('t_receiveitem/edit', $data);   
        }
        else
        {
            $date = date("Y-m-d H:i:s");
            $newmodel = $this->Treceiveitem_model->create_object_tabel($edit->Id, $name, $description, $uomid, $edit->IOn, $edit->IBy, $date , $_SESSION['userdata']['username']);

            $this->Treceiveitem_model->edit_data($newmodel);
            $successmsg = $this->paging->get_success_message();
            $this->session->set_flashdata('success_msg', $successmsg);
            redirect('treceiveitem');
        }
    }

    public function delete($id)
    {
        $form = $this->paging->get_form_name_id();
        if($this->Ggroupuser_model->is_permitted($_SESSION['userdata']['groupid'],$form['t_receiveitem'],'Delete'))
        {
            $delete = $this->Treceiveitem_model->delete_data($id);
            if(isset($delete)){
                $deletemsg = $this->helpers->get_query_error_message($delete['code']);
                $this->session->set_flashdata('warning_msg', $deletemsg);
            } else {
                $deletemsg = $this->paging->get_delete_message();
                $this->session->set_flashdata('delete_msg', $deletemsg);
            }
            redirect('treceiveitem');
        }
        else
        {   
            $data['resource'] = $this->paging->set_resources_forbidden_page();
            $this->load->view('forbidden/forbidden', $data);
        }   
    }

    public function saveuomconvertion(){

        $id = $_POST['id'];
        $itemid = $_POST['itemid'];
        $fromuomid = $_POST['fromuomid'];
        $fromuomname = $_POST['fromuomname'];
        $touomid = $_POST['touomid'];
        $touomname = $_POST['touomname'];
        $qty = $_POST['qty'];
        $ordernumber = $_POST['ordernumber'];

        $model = $this->Muomconvertion_model->create_object(null, $itemid, null, $fromuomid, $fromuomname, $touomid, $touomname, $qty, $ordernumber,null, null, null, null);
        $validate = $this->Muomconvertion_model->validate($model);
        if($validate)
            echo json_encode($validate);
        else {
            
            $date = date("Y-m-d H:i:s");
            $tablemodel = $this->Muomconvertion_model->create_object_tabel(null, $itemid, $fromuomid, $touomid, $qty, $ordernumber, null, null, null, null);
            
            if(!empty($id)){
                $tablemodel['id'] = $id;
                $tablemodel['uon'] = $date;
                $tablemodel['uby'] = $_SESSION['userdata']['username'];
                $this->Muomconvertion_model->edit_data($tablemodel);
            } else {
                $tablemodel['ion'] = $date;
                $tablemodel['iby'] = $_SESSION['userdata']['username'];
                $this->Muomconvertion_model->save_data($tablemodel);
            }
            echo "success";
            //redirect('treceiveitem/edit/'.$itemid.'#uomConvertionSection');
        }
    }

    public function getuomconvertion(){
        #detail family
        $id =  $this->input->post('iditem');
        $page =  $this->input->post('page');
        $pagesize = $this->paging->get_config();
        $alldatabyitemid = $this->Muomconvertion_model->get_data_by_itemid($id);
        $modeldetail = $this->Muomconvertion_model->get_datapages($page, $pagesize['perpagemodal'], "", $id);
        $rows = count($alldatabyitemid);;//!empty($search) ? count($modeldetail) : count($alldatabyitemid);
        $detail = $this->paging->set_data_page_index("", $modeldetail, $rows, $page, "", null, $pagesize['perpagemodal']);
        echo json_encode($detail);
    }

    public function edituomconvertion(){
        $id = $_POST['id'];
        $detail = $this->Muomconvertion_model->get_data_by_id($id);
        echo json_encode($detail);
    }

    public function deleteuomconvertion()
    {
        $id = $_POST['id'];
        $this->Muomconvertion_model->delete_data($id);
        echo "success";
    }

    private function loadview($viewName, $data)
	{
		$this->paging->load_header();
		$this->load->view($viewName, $data);
		$this->paging->load_footer();
    }

   
    
    
}