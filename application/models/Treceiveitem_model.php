<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Treceiveitem_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->lang->load('form_ui', !empty($_SESSION['language']['language']) ? $_SESSION['language']['language'] : $this->config->item('language'));
        $this->lang->load('err_msg', !empty($_SESSION['language']['language']) ? $_SESSION['language']['language'] : $this->config->item('language'));
    }
    
    public function get_alldata()
    {
        $query = $this->db->get('t_receiveitem');
        return $query->result();
    }

    public function get_data_by_id($id)
    {
        $this->db->select('a.*');
        $this->db->from('t_receiveitem a');
        $this->db->where('a.Id', $id);
        $query = $this->db->get();
        return $query->row(); // a single row use row() instead of result()
    }

    public function get_datapages($page, $pagesize, $search = null)
    {
        $this->db->select('a.*');
        $this->db->from('t_receiveitem a');
        if(!empty($search))
        {
            $this->db->like('a.Name', $search);
        }
        $this->db->order_by('a.IOn','ASC');
        $this->db->limit($pagesize, ($page-1)*$pagesize);
        $query = $this->db->get();

        return $query->result();

    }

    public function save_data($data)
    {
        $this->db->insert('t_receiveitem', $data);
    }

    public function edit_data($data)
    {
        $this->db->where('Id', $data['id']);
        $this->db->update('t_receiveitem', $data);
    }

    public function delete_data($id)
    {
        $this->db->where('Id', $id);
        if(!$this->db->delete('t_receiveitem')){
            return $this->db->error();
        }
        else{
            return;
        }
    }

    public function create_object_tabel($id, $receiveno, $receivedate, $ion, $iby, $uon, $uby)
    {
        $data = array(
            'id' => $id,
            'receiveno' => $receiveno,
            'receivedate' => $receivedate,
            'ion' => $ion,
            'iby' => $iby,
            'uon' => $uon,
            'uby' => $uby,
        );

        return $data;
    }

    public function create_object($id, $receiveno, $receivedate, $ion, $iby, $uon, $uby)
    {
        $data = array(
            'id' => $id,
            'receiveno' => $receiveno,
            'receivedate' => $receivedate,
            'ion' => $ion,
            'iby' => $iby,
            'uon' => $uon,
            'uby' => $uby,
        );

        return $data;
    }

    public function is_data_exist($name = null)
    {
        $exist = false;
        $this->db->select('*');
        $this->db->from('t_receiveitem');
        $this->db->where('Name', $name);
        $query = $this->db->get();

        $row = $query->result();
        if(count($row) > 0){
            $exist = true;
        }
        return $exist;
    }   

    public function validate($model, $oldmodel = null)
    { 
        $nameexist = false;
        $warning = array();
        $resource = $this->set_resources();

        if(empty($model['receivedate']))
            $warning = array_merge($warning, array(0=>$resource['res_msg_receivedate_cannot_null']));
        
        return $warning;
    }

    public function set_resources()
    {
        $resource['res_receiveitem'] = $this->lang->line('ui_receiveitem');
        $resource['res_receiveno'] = $this->lang->line('ui_receiveno');
        $resource['res_receivedate'] = $this->lang->line('ui_receivedate');
        $resource['res_uom'] = $this->lang->line('ui_uom');
        $resource['res_item'] = $this->lang->line('ui_item');
        $resource['res_qty'] = $this->lang->line('ui_qty');
        $resource['res_warehouse'] = $this->lang->line('ui_warehouse');
        $resource['res_data'] =  $this->lang->line('ui_data');
        $resource['res_add'] =  $this->lang->line('ui_add');
        $resource['res_name'] =$this->lang->line('ui_name');
        $resource['res_description'] = $this->lang->line('ui_description');
        $resource['res_edit'] = $this->lang->line('ui_edit');
        $resource['res_delete'] =$this->lang->line('ui_delete');
        $resource['res_search'] = $this->lang->line('ui_search');
        $resource['res_save'] = $this->lang->line('ui_save');
        $resource['res_add_data'] = $this->lang->line('ui_add_data');
        $resource['res_edit_data'] = $this->lang->line('ui_edit_data');

        $resource['res_err_name_exist'] = $this->lang->line('err_msg_name_exist');
        $resource['res_msg_name_can_not_null'] = $this->lang->line('err_msg_name_can_not_null');
        $resource['res_msg_uom_can_not_null'] = $this->lang->line('err_msg_uom_can_not_null');
        $resource['res_msg_receivedate_cannot_null'] = $this->lang->line('err_msg_receivedate_cannot_null');

        return $resource;
    }
    
}