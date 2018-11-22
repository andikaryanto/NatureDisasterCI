<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gtransactionnumber_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function getLastNumberByFormId($formId, $year, $month){
        $this->db->select('*');
        $this->db->from('g_transactionnumber');
        $this->db->where('FormId', $formId);
        $this->db->where('Year', $year);
        $this->db->where('Month', $month);
        $query = $this->db->get();
        if($query->num_rows() == 0){
            $insert = $this->insertNewFormNumber($formId, $year, $month);
            if($insert)
                return $this->getLastNumberByFormId($formId, $year, $month);
        }

        $result = $query->row();
        $formatedNumber = $result->Format;
        //$code = explode("-",$formatedNumber)[0];
        $newNumber = str_replace("#","0",explode("-",$formatedNumber)[2]);
        $newNumberLen = strlen($newNumber);
        $newNumber = $newNumber . (string)($result->LastNumber + 1);
        $newNumber = substr($newNumber, strlen($newNumber)-$newNumberLen,$newNumberLen);

        
        $formatedNumber = str_replace("{yyyy}",(string)$year, $formatedNumber);
        $formatedNumber = str_replace("{mm}",(string)$month, $formatedNumber);
        $formatedNumber = str_replace("######",$newNumber, $formatedNumber);

        return $formatedNumber;
    }

    public function insertNewFormNumber($formId, $year, $month){
        $transactionCode ="";
        if($formId == 11){
            $transactionCode = "DO";
        } else if($formId == 15) {
            $transactionCode = "RC";
        }

        $data = array(
            'format' => $transactionCode."-{yyyy}{mm}-######",
            'year' => $year,
            'month' => $month,
            'lastnumber' => 0,
            'formid' => $formId
        );

        return $this->db->insert('g_transactionnumber', $data);
    }

    public function updateLastNumber($formId, $year, $month){
        $this->db->set('LastNumber', 'LastNumber+1', FALSE);
        $this->db->where('FormId', $formId);
        $this->db->where('Year', $year);
        $this->db->where('Month', $month);
        $this->db->update('g_transactionnumber');
    }


}