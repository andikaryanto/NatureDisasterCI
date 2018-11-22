<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpserver {
    
    public function get_server_config()
    {
        $config["hostname"] = "192.168.1.122";
        $config["username"] = "Administrator";
        $config["password"] = "p@ssw0rd";
        $config['port']     = 21;
        $config['passive']  = FALSE;
        $config['debug']    = TRUE;
        return $config;
    }   

    public function get_fileconfig(){

    }
}