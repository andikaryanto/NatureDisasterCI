<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Muser_model extends CI_Model {
    public $id;
    public $name;
    public $description;
    public $ion;
    public $iby;
    public $uon;
    public $uby;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Ggroupuser_model');
        $this->lang->load('form_ui', !empty($_SESSION['language']['language']) ? $_SESSION['language']['language'] : $this->config->item('language'));
        $this->lang->load('err_msg', !empty($_SESSION['language']['language']) ? $_SESSION['language']['language'] : $this->config->item('language'));
    }
    
    public function get_alldata()
    {
        $query = $this->db->get('m_user');
        return $query->result();
    }

    public function get_data_by_id($id)
    {
        $this->db->select('a.*, b.GroupName');
        $this->db->from('m_user as a');
        $this->db->join('g_groupuser as b', 'a.GroupId = b.Id', 'left');
        $this->db->where('a.Id', $id);
        $query = $this->db->get();
        return $query->row(); // a single row use row() instead of result()
    }
    
    public function get_sigle_data_user($username, $password)
    {
        $md5pass = md5("ND".$username.$password);
        $this->db->select('a.*, b.GroupName');
        $this->db->from('m_user as a');
        $this->db->join('g_groupuser as b', 'a.GroupId = b.Id', 'left');
        $this->db->where('UserName', $username);
        $this->db->where('Password', $md5pass);
        $this->db->where('IsActive', 1);
        //$this->db->where('IsLoggedIn', 0);
        $query = $this->db->get();
        return $query->row(); // a single row use row() instead of result()
    }

    public function get_datapages($page, $pagesize, $search = null)
    {
        $this->db->select('a.*, b.GroupName');
        $this->db->from('m_user as a');
        $this->db->join('g_groupuser as b', 'a.GroupId = b.Id', 'left');
        //$this->db->where('IsActive', 1);
        $this->db->where_not_in('UserName', 'superadmin');
        if(!empty($search))
        {
            $this->db->like('UserName', $search);
        }
        
        $this->db->order_by('a.IsActive','DESC');
        $this->db->order_by('a.UserName','ASC');
        $this->db->limit($pagesize, ($page-1)*$pagesize);
        $query = $this->db->get();

        return $query->result();

    }

    public function set_loggedin($username){
        $this->db->set('IsLoggedIn', 1);
        $this->db->where('Username', $username);
        $this->db->update('m_user');
    }

    public function set_logout($username){
        $this->db->set('IsLoggedIn', 0);
        $this->db->where('Username', $username);
        $this->db->update('m_user');
    }

    public function save_data($data)
    {
        $this->db->insert('m_user', $data);
    }

    public function edit_data($data)
    {
        $this->db->where('Id', $data['id']);
        $this->db->update('m_user', $data);
    }

    public function delete_data($id)
    {
        $this->db->set('IsActive', 0);
        $this->db->set('GroupId', null);
        $this->db->where('Id', $id);
        $this->db->update('m_user');
    }

    public function activate_data($id)
    {
        $this->db->set('IsActive', 1);
        $this->db->where('Id', $id);
        $this->db->update('m_user');
    }

    public function saveNewPassword($username, $password, $newPassword){
        
        $md5pass = md5("ND".$username.$password);
        $newmd5pass = md5("ND".$username.$newPassword);
        $this->db->set('Password', $newmd5pass);
        $this->db->where('Password', $md5pass);
        $this->db->update('m_user');
    }

    public function changeLanguage($username,$language){
        $this->db->set('Language', $language);
        $this->db->where('Username', $username);
        $this->db->update('m_user');
    }

    public function create_object($id, $groupuserid, $groupname, $username, $password, $ion, $iby, $uon, $uby)
    {
        $md5pass = null;
        if(!empty($password))
            $md5pass = md5("ND".$username.$password);

        $data = array(
            'id' => $id,
            'groupid' => $groupuserid,
            'groupname' => $groupname,
            'username' => $username,
            'password' => $md5pass,
            'ion' => $ion,
            'iby' => $iby,
            'uon' => $uon,
            'uby' => $uby,
        );

        return $data;
    }

    public function create_object_tabel($id, $groupuserid,$username, $password, $ion, $iby, $uon, $uby)
    {
        $md5pass = null;
        if(!empty($password))
            $md5pass = md5("ND".$username.$password);

        $data = array(
            'id' => $id,
            'groupid' => $groupuserid,
            'username' => $username,
            'password' => $md5pass,
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
        $this->db->from('m_user');
        $this->db->where('UserName', $name);
        $query = $this->db->get();

        $row = $query->result();
        if(count($row) > 0){
            $exist = true;
        }
        return $exist;
    }

    public function validate($model, $oldmodel= null)
    {
        $nameexist = false;
        $warning = array();
        $resource = $this->set_resources();

        if(!empty($oldmodel))
        {
            if($model['username'] != $oldmodel['username'])
            {
                $nameexist = $this->is_data_exist($model['username']);
            }
        }
        else{
            if(!empty($model['username']))
            {
                $nameexist = $this->is_data_exist($model['username']);
            }
            else{
                $warning = array_merge($warning, array(0=>$resource['res_msg_name_can_not_null']));
            }
        }

        if($nameexist)
            $warning = array_merge($warning, array(0=>$resource['res_err_name_exist']));

        if(empty($model['groupid']))
            $warning = array_merge($warning, array(0=>$resource['res_groupuser_can_not_null']));

        if(empty($model['password']))
            $warning = array_merge($warning, array(0=>$resource['res_password_can_not_null']));

        
        return $warning;
    }

    public function validate_changepassword($username, $oldpassword, $newpassword, $confirmpassword){
        $warning = array();
        $resource = $this->set_resources();
        $datauser = $this->get_sigle_data_user($username, $oldpassword);
        if($datauser){
            if($newpassword != $confirmpassword){
                $warning = array_merge($warning, array(0=>$resource['res_wrong_confirmed_password']));
            }
        } else {
            $warning = array_merge($warning, array(0=>$resource['res_wrong_password']));
        }
        return $warning;

    }

    public function set_resources()
    {
        $resource['res_master_user'] = $this->lang->line('ui_master_user');
        $resource['res_user'] = $this->lang->line('ui_user');
        $resource['res_group_user'] = $this->lang->line('ui_group_user');
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
        $resource['res_changepassword'] = $this->lang->line('ui_changepassword');
        $resource['res_password'] = $this->lang->line('ui_password');
        $resource['res_oldpassword'] = $this->lang->line('ui_oldpassword');
        $resource['res_newpassword'] = $this->lang->line('ui_newpassword');
        $resource['res_confirmpassword'] = $this->lang->line('ui_confirmpassword');
        $resource['res_isactive'] = $this->lang->line('ui_isactive');
        $resource['res_deactivate'] = $this->lang->line('ui_deactivate');
        $resource['res_activate'] = $this->lang->line('ui_activate');   

        $resource['res_err_name_exist'] = $this->lang->line('err_msg_name_exist');
        $resource['res_msg_name_can_not_null'] = $this->lang->line('err_msg_name_can_not_null');
        $resource['res_wrong_password'] = $this->lang->line('err_wrong_password');
        $resource['res_wrong_confirmed_password'] = $this->lang->line('err_wrong_confirmed_password');
        $resource['res_groupuser_can_not_null'] = $this->lang->line('err_msg_groupuser_can_not_null');
        $resource['res_password_can_not_null'] = $this->lang->line('err_msg_password_can_not_null');

        return $resource;
    }
    
}