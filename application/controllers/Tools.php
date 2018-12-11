<?php

class Tools extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // can only be called from the command line
        if (!$this->input->is_cli_request()) {
            exit('Direct access is not allowed. This is a command line tool, use the terminal');
        }

        $this->load->dbforge();

        // initiate faker
        $this->faker = Faker\Factory::create();
    }

    public function message($to = 'World') {
        echo "Hello {$to}!" . PHP_EOL;
    }

    public function help() {
        $result = "The following are the available command line interface commands\n\n";
        $result .= "php index.php tools migration \"file_name\"         Create new migration file\n";
        $result .= "php index.php tools migrate [\"version_number\"]    Run all migrations. The version number is optional.\n";
        $result .= "php index.php tools seeder \"file_name\"            Creates a new seed file.\n";
        $result .= "php index.php tools seed \"file_name\"              Run the specified seed file.\n";
        $result .= "php index.php tools controller \"file_name\"        Creates a new controller file.\n";
        $result .= "php index.php tools model \"file_name\"             Creates a new model file.\n";

        echo $result . PHP_EOL;
    }

    public function migration($name) {
        $this->make_migration_file($name);
    }

    public function migrate($version = null) {
        $this->load->library('migration');
        $this->create_version_history();
        $versions = $this->read_version();
        $prevVersion = "";
        $countMigrate = 0;
        foreach($versions as $ver){
            
            if($this->is_exist_version_history($ver) < 1){
                if($this->must_downgrade_version($ver) > 0){
                    $this->downgrade_version($prevVersion);
                }

                if ($this->migration->version($ver) === FALSE) {
                    show_error($this->migration->error_string());
                } else {
                    echo "Migrations run successfully " . $ver . PHP_EOL;
                    
                    $migrationVersion = array("Version" => $ver);
                    $this->db->insert("g_versionhistory", $migrationVersion);
                }
                $countMigrate++;
            }
            $prevVersion = $ver;
        }
        echo "Migrations count (" . $countMigrate .")" . PHP_EOL;



        // if ($version != null) {
        //     if ($this->migration->version($version) === FALSE) {
        //         show_error($this->migration->error_string());
        //     } else {
        //         echo "Migrations run successfully" . PHP_EOL;
        //     }

        //     return;
        // }

        // if ($this->migration->latest() === FALSE) {
        //     show_error($this->migration->error_string());
        // } else {
        //     echo "Migrations run successfully" . PHP_EOL;
        // }
    }

    public function seeder($name) {
        $this->make_seed_file($name);
    }

    public function seed($name) {
        $seeder = new Seeder();

        $seeder->call($name);
    }

    public function controller($name){
        $this->make_controller_file($name);
    }

    public function model($name){
        $this->make_model_file($name);
    }

    protected function make_migration_file($name) {
        $date = new DateTime();
        $timestamp = $date->format('YmdHis');

        $newname = $name.$timestamp;

        $table_name = strtolower($newname);

        $path = APPPATH . "database/migrations/$timestamp" . "_" . "$newname.php";

        $my_migration = fopen($path, "w") or die("Unable to create migration file!");
        

        $migration_template = "<?php

class Migration_$newname extends CI_Migration {

    public function up() {
        \$this->load->helper('db_helper');
        \$this->dbforge->add_field(array(
            'Id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            )
        ));
        \$this->dbforge->add_key('Id', TRUE);
        \$this->dbforge->create_table('$table_name');
    }

    public function down() {
        \$this->dbforge->drop_table('$table_name');
    }

}";

        fwrite($my_migration, $migration_template);

        fclose($my_migration);

        echo "$path migration has successfully been created." . PHP_EOL;
    }

    protected function make_seed_file($name) {
        $path = APPPATH . "database/seeds/$name.php";

        $my_seed = fopen($path, "w") or die("Unable to create seed file!");

        $seed_template = "<?php

class $name extends Seeder {

    private \$table = 'users';

    public function run() {
        //\$this->db->truncate(\$this->table);

        //seed records manually
        \$data = [
            'user_name' => 'admin',
            'password' => '9871'
        ];
        \$this->db->insert(\$this->table, \$data);

        //seed many records using faker
        \$limit = 33;
        echo \"seeding \$limit user accounts\";

        for (\$i = 0; \$i < \$limit; \$i++) {
            echo \".\";

            \$data = array(
                'user_name' => \$this->faker->unique()->userName,
                'password' => '1234',
            );

            \$this->db->insert(\$this->table, \$data);
        }

        echo PHP_EOL;
    }
}
";

        fwrite($my_seed, $seed_template);

        fclose($my_seed);

        echo "$path seeder has successfully been created." . PHP_EOL;
    }

    protected function make_controller_file($name){

        $id = '$id';
        $loadviewparam = '$viewName, $data';
        $loadviewcontent = '$this->paging->load_header();
		$this->load->view($viewName, $data);
        $this->paging->load_footer();';
        
        $path = APPPATH . "controllers/$name.php";

        $my_controller = fopen($path, "w") or die("Unable to create model file!");

        $controller_template = "<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class $name extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // your index goes here
    }

    public function add()
    {   
        // your add method goes here
    }

    public function addsave()
    {   
        // your addsave method goes here
    }

    public function edit($id)
    {   
        // your edit method goes here
    }

    public function editsave()
    {   
        // your editsave method goes here
    }

    public function delete($id){
        // your delete method goes here

    }

    private function loadview($loadviewparam)
	{
        // your load view method goes here
		$loadviewcontent
    } 

}";

        fwrite($my_controller, $controller_template);

        fclose($my_controller);

        echo "$path controller has successfully been created." . PHP_EOL;
    }

    protected function make_model_file($name){

        $id = '$id';
        $data = '$data';

        $arrayobject = '$data = array(
        );
        return $data;';

        $validateparam = '$model, $oldmodel = null';

        $pagesparam = '$page, $pagesize, $search = null';

        $loadviewcontent = '$this->paging->load_header();
		$this->load->view($viewName, $data);
        $this->paging->load_footer();';
        
        $path = APPPATH . "models/$name.php";

        $my_model = fopen($path, "w") or die("Unable to create model file!");

        $model_template = "<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class $name extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_alldata(){
        // get all data
    }

    public function get_data_by_id($id){  
        // get data by primary key
    }

    public function get_datapages($pagesparam){  
        // your datapages
    }

    public function save_data($data){  
        // your save data
    }

    public function edit_data($data){  
        // your edit data
    }

    public function delete_data($id){
        // delete data
    }

    public function create_object(){
        // create object goes here
        $arrayobject
    }

    public function create_object_tabel(){
        //create object goes here
        $arrayobject
    }

    public function validate($validateparam){
        //validate goes here
    }

    public function set_resources(){
        // resource language goes here
    }

}";

        fwrite($my_model, $model_template);

        fclose($my_model);

        echo "$path model has successfully been created." . PHP_EOL;
    }

    public function read_version(){
        $path = APPPATH . "database/migrations/";
        $version = array();
        if ($handle = opendir($path)) {

            while (false !== ($entry = readdir($handle))) {
        
                if ($entry != "." && $entry != "..") {
                    array_push($version, explode("_", $entry)[0]);
                }
            }
        
            closedir($handle);
        }
        return $version;
    }

    protected function must_downgrade_version($version){
        $query = $this->db->get("migrations")->row();
        if($query->version > $version){
            $this->delete_version_history($version);
            return true;
        }
        return false;
    }

    protected function downgrade_version($version){
        $this->db->set('version', $version);
        $this->db->update('migrations');
    }

    protected function delete_version_history($version){
        $this->db->where('Version > ', $version);
        $this->db->delete('g_versionhistory');
    }

    public function is_exist_version_history($version){
        $isExist = false;
        
        if($version == "20181126000000"){
            $isExist = true;
        } else {
            $this->db->select('*');
            $this->db->from('g_versionhistory');
            $this->db->where('Version', $version);
            $query = $this->db->get()->row();
            if($query){
                $isExist = true;
            }
        }
        return $isExist;
    }

    protected function is_exist_data_version_hitory(){        
        $this->db->select('*');
        $this->db->from('g_versionhistory');
        $query = $this->db->get()->result();
        if($query){
            return true;
        }
        return false;
    }

    protected function create_version_history(){
        if (!$this->db->table_exists('g_versionhistory') )
        {
            $this->load->helper('db_helper');
            $this->dbforge->add_field(array(
                'Id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => TRUE
                ),
                'Version' => array(
                    'type' => 'varchar',
                    'constraint' => 100
                )
    
            ));
            $this->dbforge->add_key('Id', TRUE);
            $this->dbforge->create_table('g_versionhistory');
        }
    }

}