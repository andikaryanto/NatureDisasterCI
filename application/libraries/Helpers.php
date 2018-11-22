<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helpers {

    public function rename_file($file, $date){
        $split = explode(".",$file);
        $i = 0;
        $newname = "";
        foreach($split as $value){
            $newname = $newname.$value;
            if($i == count($split) - 2)
                $newname = $newname."_".$date.".";
            
            ++$i;
        }

        return $newname;
    }

    public function queryErrorCode(){
        $code['datainrefenrence'] = 1451;
        return $code;
    }

    public function get_query_error_message($code){
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->lang->load('form_ui', $_SESSION['language']['language']);

        $msg = array();

        if($code == $this->queryErrorCode()['datainrefenrence']){
            $msg = array_merge($msg, array(0=>$CI->lang->line('ui_datainreference')));
        }

        return $msg;
    }
}   