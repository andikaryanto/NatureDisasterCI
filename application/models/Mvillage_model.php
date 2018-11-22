<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mvillage_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->lang->load('form_ui', !empty($_SESSION['language']['language']) ? $_SESSION['language']['language'] : $this->config->item('language'));
        $this->lang->load('err_msg', !empty($_SESSION['language']['language']) ? $_SESSION['language']['language'] : $this->config->item('language'));
    }
    
    public function get_alldata()
    {
        $this->db->select('a.*, b.Name as SubcityName, c.Name as CityName, d.name as ProvinceName');
        $this->db->from('m_village a');
        $this->db->join('m_subcity b','a.SubcityId = b.Id', 'left');
        $this->db->join('m_city c','b.CityId = c.Id', 'left');
        $this->db->join('m_province d','c.ProvinceId = d.Id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_data_by_id($id)
    {
        $this->db->select('a.*, b.Name as SubcityName, c.Name as CityName, d.name as ProvinceName');
        $this->db->from('m_village a');
        $this->db->join('m_subcity b','a.SubcityId = b.Id', 'left');
        $this->db->join('m_city c','b.CityId = c.Id', 'left');
        $this->db->join('m_province d','c.ProvinceId = d.Id', 'left');
        $this->db->where('a.Id', $id);
        $query = $this->db->get();
        return $query->row(); // a single row use row() instead of result()
    }

    public function get_datapages($page, $pagesize, $search = null)
    {
        
        $this->db->select('a.*, b.Name as SubcityName, c.Name as CityName, d.name as ProvinceName');
        $this->db->from('m_village a');
        $this->db->join('m_subcity b','a.SubcityId = b.Id', 'left');
        $this->db->join('m_city c','b.CityId = c.Id', 'left');
        $this->db->join('m_province d','c.ProvinceId = d.Id', 'left');
        if(!empty($search))
        {
            $this->db->like('a.Name', $search);
            $this->db->or_like('b.Name', $search);
            $this->db->or_like('c.Name', $search);
            $this->db->or_like('d.Name', $search);
        }
        $this->db->order_by('IOn','ASC');
        $this->db->limit($pagesize, ($page-1)*$pagesize);
        $query = $this->db->get();

        return $query->result();

    }

    public function save_data($data)
    {
        $this->db->insert('m_village', $data);
    }

    public function edit_data($data)
    {
        $this->db->where('Id', $data['id']);
        $this->db->update('m_village', $data);
    }

    public function delete_data($id)
    {
        $this->db->where('Id', $id);
        if(!$this->db->delete('m_village')){
            return $this->db->error();
        }
        else{
            return;
        }
    }

    public function create_object_tabel($id, $name, $description, $subcityid, $ion, $iby, $uon, $uby)
    {
        $data = array(
            'id' => $id,
            'subcityid' => $subcityid,
            'name' => $name,
            'description' => $description,
            'ion' => $ion,
            'iby' => $iby,
            'uon' => $uon,
            'uby' => $uby,
        );

        return $data;
    }

    public function create_object($id, $name, $description, $subcityid, $subcityname, $ion, $iby, $uon, $uby)
    {
        $data = array(
            'id' => $id,
            'subcityid' => $subcityid,
            'subcityname' => $subcityname,
            'name' => $name,
            'description' => $description,
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
        $this->db->from('m_village');
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
        if(!empty($oldmodel))
        {
            if($model['name'] != $oldmodel['name'])
            {
                $nameexist = $this->is_data_exist($model['name']);
            }
        }
        else{
            if(!empty($model['name']))
            {
                $nameexist = $this->is_data_exist($model['name']);
            }
            else{
                $warning = array_merge($warning, array(0=>$resource['res_msg_name_can_not_null']));
            }
        }

        if($nameexist === true)
            $warning = array_merge($warning, array(0=>$resource['res_err_name_exist']));
        
        if(empty($model['subcityid']))
            $warning = array_merge($warning, array(0=>$resource['res_msg_subcity_can_not_null']));
        
        return $warning;
    }

    public function set_resources()
    {
        $resource['res_master_village'] = $this->lang->line('ui_master_village');
        $resource['res_village'] = $this->lang->line('ui_village');
        $resource['res_subcity'] = $this->lang->line('ui_subcity');
        $resource['res_city'] = $this->lang->line('ui_city');
        $resource['res_province'] = $this->lang->line('ui_province');
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
        $resource['res_msg_subcity_can_not_null'] = $this->lang->line('err_msg_subcity_can_not_null');

        return $resource;
    }
    
}