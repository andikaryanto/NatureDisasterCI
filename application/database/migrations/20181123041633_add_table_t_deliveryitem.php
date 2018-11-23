<?php

class Migration_add_table_t_deliveryitem extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'Id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'DeliveryNo' => array(
                'type' => 'VARCHAR',
                'constraint' => 20
            ),
            'ReceiveDate' => array(
                'type' => 'DATETIME'
            ),
            'IOn' => array(
                'type' => 'DATETIME',
                'null' => true
            ),
            'IBy' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ),
            'UOn' => array(
                'type' => 'DATETIME',
                'null' => true
            ),
            'UBy' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            )
        ));
        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('t_deliveryitem');
    }

    public function down() {
        $this->dbforge->drop_table('t_deliveryitem');
    }

}