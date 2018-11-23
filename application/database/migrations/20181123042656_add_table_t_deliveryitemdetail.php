<?php

class Migration_add_table_t_deliveryitemdetail extends CI_Migration {
    public function up() {
        
        $this->load->helper('db_helper');

        $this->dbforge->add_field(array(
            'Id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'ItemDeliveryId' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'ItemId' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'UomId' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'WarehouseId' => array(
                'type' => 'INT',
                'constraint' => 11,
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
        $this->dbforge->create_table('t_deliveryitemdetail');
        $this->db->query(add_foreign_key('t_deliveryitemdetail', 'ItemDeliveryId', 't_deliveryitem(Id)', 'CASCADE', 'CASCADE'));
        $this->db->query(add_foreign_key('t_deliveryitemdetail', 'ItemId', 'm_item(Id)', 'RESTRICT', 'CASCADE'));
        $this->db->query(add_foreign_key('t_deliveryitemdetail', 'UomId', 'm_uom(Id)', 'RESTRICT', 'CASCADE'));
        $this->db->query(add_foreign_key('t_deliveryitemdetail', 'WarehouseId', 'm_warehouse(Id)', 'RESTRICT', 'CASCADE'));
        
    }

    public function down() {
        $this->dbforge->drop_table('t_deliveryitemdetail');
    }

}