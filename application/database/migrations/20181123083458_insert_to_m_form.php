<?php

class Migration_insert_to_m_form extends CI_Migration {

    private $table = 'g_form';

    public function up() {
        
        $data = [
            'FormName' => 't_deliveryitem',
            'AliasName' => 'delivery item',
            'LocalName' => 'pengiriman barang',
            'ClassName' => 'Transaction'
        ];
        $this->db->insert($this->table, $data);
    }

    public function down() {
        //$this->dbforge->drop_table('');
    }

}