<?php

class insert_to_m_form extends Seeder {

    private $table = 'g_form';

    public function run() {
        //$this->db->truncate($this->table);

        //seed records manually
        $data = [
            'FormName' => 't_deliveryitem',
            'AliasName' => 'delivery item',
            'LocalName' => 'pengiriman barang',
            'AliasName' => 'Transaction'
        ];
        $this->db->insert($this->table, $data);

        //seed many records using faker
        // $limit = 33;
        // echo "seeding $limit user accounts";

        // for ($i = 0; $i < $limit; $i++) {
        //     echo ".";

        //     $data = array(
        //         'user_name' => $this->faker->unique()->userName,
        //         'password' => '1234',
        //     );

        //     $this->db->insert($this->table, $data);
        // }

        echo PHP_EOL;
    }
}
