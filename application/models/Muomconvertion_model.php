<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Muomconvertion_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->lang->load('form_ui', !empty($_SESSION['language']['language']) ? $_SESSION['language']['language'] : $this->config->item('language'));
        $this->lang->load('err_msg', !empty($_SESSION['language']['language']) ? $_SESSION['language']['language'] : $this->config->item('language'));
    }

    public function get_alldata()
    {
        $this->db->select('f.*,
                            a.Name as ItemName, 
                            b.Name as FromUomName, 
                            c.Name as ToUomName');
        $this->db->from('m_uomconvertion f');
        $this->db->join('m_item a', 'a.Id = f.ItemId');
        $this->db->join('m_uom b', 'b.Id = a.FromUomId');
        $this->db->join('m_uom c', 'c.Id = b.ToUomId', 'left');
        $this->db->order_by('f.IOn', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    
    public function get_data_by_id($id)
    {
        
        $this->db->select('f.*,
                            a.Name as ItemName, 
                            b.Name as FromUomName, 
                            c.Name as ToUomName');
        $this->db->from('m_uomconvertion f');
        $this->db->join('m_item a', 'a.Id = f.ItemId');
        $this->db->join('m_uom b', 'b.Id = f.FromUomId');
        $this->db->join('m_uom c', 'c.Id = f.ToUomId');
        $this->db->where('f.Id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_data_by_itemid($id)
    {
        
        $this->db->select('f.*,
                a.Name as ItemName, 
                b.Name as FromUomName, 
                c.Name as ToUomName');
        $this->db->from('m_uomconvertion f');
        $this->db->join('m_item a', 'a.Id = f.ItemId');
        $this->db->join('m_uom b', 'b.Id = f.FromUomId');
        $this->db->join('m_uom c', 'c.Id = f.ToUomId');
        $this->db->where('f.ItemId', $id);
        $this->db->order_by('f.OrderNumber', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    public function get_datapages($page, $pagesize, $search = null, $itemid = null)
    {
        $this->db->select('f.*,
                a.Name as ItemName, 
                b.Name as FromUomName, 
                c.Name as ToUomName');
        $this->db->from('m_uomconvertion f');
        $this->db->join('m_item a', 'a.Id = f.ItemId');
        $this->db->join('m_uom b', 'b.Id = f.FromUomId');
        $this->db->join('m_uom c', 'c.Id = f.ToUomId');
        // if(!empty($search))
        // {
        //     $this->db->like('a.CardNo', $search);
        //     $this->db->or_like('a.HeadFamilyName', $search);
        // }
        $this->db->where('f.ItemId', $itemid);
        $this->db->order_by('f.OrderNumber', 'ASC');
        $this->db->limit($pagesize, ($page-1)*$pagesize);
        $query = $this->db->get();

        return $query->result();

    }

    public function save_data($data)
    {
        //$this->db->insert('m_uomconvertion', $data);
        if(!$this->db->insert('m_uomconvertion', $data)){
            return $this->db->error();
        }
        else{
            return;
        }
    }

    public function edit_data($data)
    {
        $this->db->where('Id', $data['id']);
        $this->db->update('m_uomconvertion', $data);
    }

    public function delete_data($id)
    {
        $this->db->where('Id', $id);
        $this->db->delete('m_uomconvertion');
    }

    public function create_object($id, $itemid, $itemname, $fromuomid, $fromuomname, 
                                        $touomid, $touomname, $qty, $ordernumber,
                                        $ion, $iby, $uon, $uby)
    {
        $data = array(
            'id' => $id,
            'itemid' => $itemid,
            'itemname' => $itemname,
            'fromuomid' => $fromuomid,
            'fromuomname' => $fromuomname,
            'touomid' => $touomid,
            'touomname' => $touomname,
            'ordernumber' => $ordernumber,
            'qty' => $qty,
            'ion' => $ion,
            'iby' => $iby,
            'uon' => $uon,
            'uby' => $uby,
        );

        return $data;
    }

    public function create_object_tabel($id, $itemid, $fromuomid, $touomid, $qty, $ordernumber,
                                        $ion = null, $iby = null, $uon = null, $uby = null)
    { 
        $data = array(
            'id' => $id,
            'itemid' => $itemid,
            'fromuomid' => $fromuomid,
            'touomid' => $touomid,
            'qty' => $qty,
            'ordernumber' => $ordernumber,
            'ion' => $ion,
            'iby' => $iby,
            'uon' => $uon,
            'uby' => $uby,
        );

        return $data;
    }

    public function is_data_exist($itemid = null, $fromuomid = null, $touomid = null)
    {
        $exist = false;
        $query = $this->db->select('*')
                    ->from('m_item a')
                    ->join('m_uomconvertion b', 'b.Id = b.ItemId')
                    ->where('a.Id', $itemid)
                    ->group_start()
                        ->where('b.fromuomid', $fromuomid)
                        ->where('b.touomid', $touomid)
                        ->or_group_start()
                            ->where('b.fromuomid',  $touomid)
                            ->where('b.touomid',$fromuomid)
                        ->group_end()
                    ->group_end()
                ->get();

        $row = $query->result();
        if(count($row) > 0){
            $exist = true;
        }
        return $exist;
    }   

    public function validate($model, $oldmodel = null)
    { 
        $exist = false;
        $warning = array();
        $resource = $this->set_resources();

        if($this->is_data_exist($model['itemid'], $model['fromuomid'], $model['touomid']))
            $warning = array_merge($warning, array(0=>$resource['res_msg_convertion_exist']));
            
        if(empty($model['fromuomid'])) 
            $warning = array_merge($warning, array(0=>$resource['res_msg_fromuom_can_not_null']));
        if(empty($model['touomid'])) 
            $warning = array_merge($warning, array(0=>$resource['res_msg_touom_can_not_null']));
        if(empty($model['qty'])) 
            $warning = array_merge($warning, array(0=>$resource['res_msg_qty_can_not_null']));
        if(empty($model['ordernumber'])) 
            $warning = array_merge($warning, array(0=>$resource['res_msg_ordernumber_can_not_null']));
        if($model['fromuomid'] == $model['touomid'])
            $warning = array_merge($warning, array(0=>$resource['res_msg_fromtouom_can_not_null']));

        
        return $warning;
    }

    public function set_resources()
    {
        $resource['res_master_item'] = $this->lang->line('ui_master_item');
        $resource['res_cardno'] = $this->lang->line('ui_cardno');
        $resource['res_address'] = $this->lang->line('ui_address');
        $resource['res_item'] = $this->lang->line('ui_item');
        $resource['res_postcode'] = $this->lang->line('ui_postcode');
        $resource['res_headfamilyname'] = $this->lang->line('ui_headfamilyname');
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
        $resource['res_msg_convertion_exist'] = $this->lang->line('err_msg_convertion_exist');
        $resource['res_msg_fromuom_can_not_null'] = $this->lang->line('err_msg_fromuom_can_not_null');
        $resource['res_msg_touom_can_not_null'] = $this->lang->line('err_msg_touom_can_not_null');
        $resource['res_msg_qty_can_not_null'] = $this->lang->line('err_msg_qty_can_not_null');
        $resource['res_msg_ordernumber_can_not_null'] = $this->lang->line('err_msg_ordernumber_can_not_null');
        $resource['res_msg_fromtouom_can_not_null'] = $this->lang->line('err_msg_fromtouom_can_not_null');

        return $resource;
    }
    
}
