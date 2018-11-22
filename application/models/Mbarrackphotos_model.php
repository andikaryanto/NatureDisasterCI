<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mbarrackphotos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_alldata()
    {
        $query = $this->db->get('m_barrackphotos');
        return $query->result();
    }

    public function get_data_by_barrackid($barrackid)
    {
        $this->db->select('*');
        $this->db->from('m_barrackphotos');
        $this->db->where('BarrackId', $barrackid);
        $query = $this->db->get();
        return $query->row(); // a single row use row() instead of result()
    }

    public function save_data($data)
    {
        $this->db->insert('m_barrackphotos', $data);
    }

    public function delete_data($barrackid)
    {
        $this->db->where('BarrackId', $barrackid);
        $this->db->delete('m_barrackphotos');
    }

    public function create_object($id, $barrackid, $filename, $type, $url, $ion, $iby, $uon, $uby)
    {
        $data = array(
            'id' => $id,
            'barrackid' => $barrackid,
            'filename' => $filename,
            'type' => $type,
            'url' => $url,
            'ion' => $ion,
            'iby' => $iby,
            'uon' => $uon,
            'uby' => $uby,
        );

        return $data;
    }
}