<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gsitestatus_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_alldata()
    {
        $query = $this->db->get('g_sitestatus');
        return $query->row();
    }

    public function edit_data($status){
        $this->db->set('Status', $status);
        $this->db->update('g_sitestatus');
    }

    public function create_object($id, $status)
    {
        $data = array(
            'id' => $id,
            'status' => $status
        );

        return $data;
    }


    public function set_resources()
    {
        $resource['res_live'] = $this->lang->line('ui_live');
        $resource['res_maintenance'] = $this->lang->line('ui_maintenance');
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

        return $resource;
    }
}