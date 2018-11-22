<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tdisasteroccur_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->lang->load('form_ui', !empty($_SESSION['language']['language']) ? $_SESSION['language']['language'] : $this->config->item('language'));
        $this->lang->load('err_msg', !empty($_SESSION['language']['language']) ? $_SESSION['language']['language'] : $this->config->item('language'));
    
    }

    public function get_alldata()
    {
        $this->db->select('a.*
                        , b.Name as DisasterName
                        , c.Name as VillageName
                        , d.Name As SubcityName
                        , e.Name as CityName
                        , f.Name as ProvinceName');
        $this->db->from('t_disasteroccur a');
        $this->db->join('m_disaster b','a.DisasterId = b.Id', 'left');
        $this->db->join('m_village c', 'c.Id = a.VillageId', 'left');
        $this->db->join('m_subcity d', 'd.Id = c.SubcityId', 'left');
        $this->db->join('m_city e', 'e.Id = d.CityId', 'left');
        $this->db->join('m_province f', 'f.Id = e.ProvinceId', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_data_by_id($id)
    {
        $this->db->select('a.*
                    , b.Name as DisasterName
                    , c.Name as VillageName
                    , d.Name As SubcityName
                    , e.Name as CityName
                    , f.Name as ProvinceName');
        $this->db->from('t_disasteroccur a');
        $this->db->join('m_disaster b','a.DisasterId = b.Id', 'left');
        $this->db->join('m_village c', 'c.Id = a.VillageId', 'left');
        $this->db->join('m_subcity d', 'd.Id = c.SubcityId', 'left');
        $this->db->join('m_city e', 'e.Id = d.CityId', 'left');
        $this->db->join('m_province f', 'f.Id = e.ProvinceId', 'left');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_data_by_nodisaster($nomor)
    {
        $this->db->select('a.*
                    , b.Name as DisasterName
                    , c.Name as VillageName
                    , d.Name As SubcityName
                    , e.Name as CityName
                    , f.Name as ProvinceName');
        $this->db->from('t_disasteroccur a');
        $this->db->join('m_disaster b','a.DisasterId = b.Id', 'left');
        $this->db->join('m_village c', 'c.Id = a.VillageId', 'left');
        $this->db->join('m_subcity d', 'd.Id = c.SubcityId', 'left');
        $this->db->join('m_city e', 'e.Id = d.CityId', 'left');
        $this->db->join('m_province f', 'f.Id = e.ProvinceId', 'left');
        $this->db->where('a.NoDisaster', $nomor);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_datapages($page, $pagesize, $search = null)
    {
        
        $this->db->select('a.*
                    , b.Name as DisasterName
                    , c.Name as VillageName
                    , d.Name As SubcityName
                    , e.Name as CityName
                    , f.Name as ProvinceName');
        $this->db->from('t_disasteroccur a');
        $this->db->join('m_disaster b','a.DisasterId = b.Id', 'left');
        $this->db->join('m_village c', 'c.Id = a.VillageId', 'left');
        $this->db->join('m_subcity d', 'd.Id = c.SubcityId', 'left');
        $this->db->join('m_city e', 'e.Id = d.CityId', 'left');
        $this->db->join('m_province f', 'f.Id = e.ProvinceId', 'left');
        if(!empty($search))
        {
            $this->db->like('a.DisasterNo', $search);
            $this->db->or_like('b.Name', $search);
        }
        $this->db->order_by('a.IOn','ASC');
        $this->db->limit($pagesize, ($page-1)*$pagesize);
        $query = $this->db->get();

        return $query->result();

    }

    public function save_data($data)
    {
        $this->db->insert('t_disasteroccur', $data);
    }

    public function edit_data($data)
    {
        $this->db->where('Id', $data['id']);
        $this->db->update('t_disasteroccur', $data);
    }

    public function delete_data($id)
    {
        $this->db->where('Id', $id);
        if(!$this->db->delete('t_disasteroccur')){
            return $this->db->error();
        }
        else{
            return;
        }
    }

    public function create_object($id, $disasterid, $disastername, $nodisaster, $latitude, $longitude, 
                                        $villageid, $rt, $rw, $isneedlogistic, $description,
                                        $villagename, $subcityname, $cityname, $provincename,
                                        $ion, $iby, $uon, $uby)
    {
        $data = array(
            'id' => $id,
            'disasterid' => $disasterid,
            'disastername' => $disastername,
            'nodisaster' => $nodisaster,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'villageid' => $villageid,
            'rt' => $rt,
            'rw' => $rw,
            'villagename' => $villagename,
            'subcityname' => $subcityname,
            'cityname' => $cityname,
            'provincename' => $provincename,
            'isneedlogistic' => $isneedlogistic,
            'description' => $description,
            'ion' => $ion,
            'iby' => $iby,
            'uon' => $uon,
            'uby' => $uby,
        );

        return $data;
    }

    public function create_object_tabel($id, $disasterid, $nodisaster, $latitude, $longitude, 
                                        $villageid, $rt, $rw, $isneedlogistic, $description,
                                        $ion, $iby, $uon, $uby)
    {
        $data = array(
            'id' => $id,
            'disasterid' => $disasterid,
            'nodisaster' => $nodisaster,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'villageid' => $villageid,
            'rt' => $rt,
            'rw' => $rw,
            'isneedlogistic' => $isneedlogistic,
            'description' => $description,
            'ion' => $ion,
            'iby' => $iby,
            'uon' => $uon,
            'uby' => $uby,
        );

        return $data;
    }

    public function is_data_exist($no = null)
    {
        $exist = false;
        $this->db->select('*');
        $this->db->from('t_disasteroccur');
        $this->db->where('NoDisaster', $no);
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
            if($model['nodisaster'] != $oldmodel['nodisaster'])
            {
                $nameexist = $this->is_data_exist($model['nodisaster']);
            }
        }
        else{
            // if(!empty($model['nodisaster']))
            // {
            //     $nameexist = $this->is_data_exist($model['nodisaster']);
            // }
            // else{
            //     $warning = array_merge($warning, array(0=>$resource['res_msg_name_can_not_null']));
            // }
        }
        if($nameexist === true)
        {
            $warning = array_merge($warning, array(0=>$resource['res_err_name_exist']));
        }
        
        if(empty($model['disasterid'])){
            $warning = array_merge($warning, array(0=>$resource['res_err_disaster_can_not_null']));
        }

        if(empty($model['latitude'])){
            $warning = array_merge($warning, array(0=>$resource['res_err_latitude_can_not_null']));
        }

        if(empty($model['longitude'])){
            $warning = array_merge($warning, array(0=>$resource['res_err_longitude_can_not_null']));
        }
        
        return $warning;
    }
    
    public function set_resources()
    {
        $resource['res_disaster_occur'] = $this->lang->line('ui_disaster_occur');
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
        $resource['res_isneedlogistic'] = $this->lang->line('ui_isneedlogistic');
        $resource['res_nodisaster'] = $this->lang->line('ui_nodisaster');
        $resource['res_transaction'] = $this->lang->line('ui_transaction');
        $resource['res_disaster'] = $this->lang->line('ui_disaster');

        //error res
        $resource['res_err_name_exist'] = $this->lang->line('err_msg_name_exist');
        $resource['res_msg_name_can_not_null'] = $this->lang->line('err_msg_name_can_not_null');
        $resource['res_err_latitude_can_not_null'] = $this->lang->line('err_latitude_can_not_null');
        $resource['res_err_longitude_can_not_null'] = $this->lang->line('err_longitude_can_not_null');
        $resource['res_err_disaster_can_not_null'] = $this->lang->line('err_disaster_can_not_null');

        return $resource;
    }

}