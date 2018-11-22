warning: LF will be replaced by CRLF in application/config/routes.php.
The file will have its original line endings in your working directory.
[1mdiff --git a/application/config/routes.php b/application/config/routes.php[m
[1mindex 66fac62..c92cac0 100644[m
[1m--- a/application/config/routes.php[m
[1m+++ b/application/config/routes.php[m
[36m@@ -181,6 +181,9 @@[m [m$route['treceiveitem/addsave'] = 't_receiveitem/addsave';[m
 $route['treceiveitem/edit/(:num)'] = 't_receiveitem/edit/$1';[m
 $route['treceiveitem/editsave'] = 't_receiveitem/editsave';[m
 $route['treceiveitem/delete/(:num)'] = 't_receiveitem/delete/$1';[m
[32m+[m
[32m+[m
[32m+[m[32m$route['sitestatus'] = 'g_sitestatus';[m
 //API[m
 $route['api/mdisaster']['GET'] = 'api_mdisaster/get_disaster';[m
 $route['api/mdisaster/(:any)/(:any)'] = 'api_mdisaster/get_disaster/$1/$2';[m
[1mdiff --git a/application/controllers/Api_mdisaster.php b/application/controllers/Api_mdisaster.php[m
[1mindex d7b4294..dc9e5f1 100644[m
[1m--- a/application/controllers/Api_mdisaster.php[m
[1m+++ b/application/controllers/Api_mdisaster.php[m
[36m@@ -1,4 +1,3 @@[m
[31m-[m
 <?php[m
 defined('BASEPATH') OR exit('No direct script access allowed');[m
 require(APPPATH.'libraries/REST_Controller.php');[m
[36m@@ -41,28 +40,28 @@[m [mclass Api_mdisaster extends REST_Controller{[m
     public function save_disaster_post()[m
     {[m
        [m
[31m-        // $request = $this->request->body;[m
[31m-        // $date = date("Y-m-d H:i:s");[m
[32m+[m[32m        $request = $this->request->body;[m
[32m+[m[32m        $date = date("Y-m-d H:i:s");[m
 [m
[31m-        // $data = array('id' => null,[m
[31m-        //    'name' => $request['name'],[m
[31m-        //    'description' => $request['description'],[m
[31m-        //    'ion' => $date,[m
[31m-        //    'iby' => 'android',[m
[31m-        //    'uon' => null,[m
[31m-        //    'uby' => null[m
[31m-        //    );[m
[31m-        // $this->Mdisaster_model->save_data($data);[m
[32m+[m[32m        $data = array('id' => null,[m
[32m+[m[32m           'name' => $request['name'],[m
[32m+[m[32m           'description' => $request['description'],[m
[32m+[m[32m           'ion' => $date,[m
[32m+[m[32m           'iby' => 'android',[m
[32m+[m[32m           'uon' => null,[m
[32m+[m[32m           'uby' => null[m
[32m+[m[32m           );[m
[32m+[m[32m        $this->Mdisaster_model->save_data($data);[m
 [m
[31m-        // $response = array([m
[31m-        //     'success' => 'succesfully inserted'  [m
[31m-        //     //'totalPages' => ceil($this->Mahasiswa->getCountMahasiswa() / $size)[m
[31m-        // );[m
[31m-        // $this->output[m
[31m-        //     ->set_status_header(200)[m
[31m-        //     ->set_content_type('application/json', 'utf-8')[m
[31m-        //     ->set_output(json_encode($response, JSON_PRETTY_PRINT))[m
[31m-        //     ->_display();[m
[31m-        //     exit;[m
[32m+[m[32m        $response = array([m
[32m+[m[32m            'success' => 'succesfully inserted'[m[41m  [m
[32m+[m[32m            //'totalPages' => ceil($this->Mahasiswa->getCountMahasiswa() / $size)[m
[32m+[m[32m        );[m
[32m+[m[32m        $this->output[m
[32m+[m[32m            ->set_status_header(200)[m
[32m+[m[32m            ->set_content_type('application/json', 'utf-8')[m
[32m+[m[32m            ->set_output(json_encode($response, JSON_PRETTY_PRINT))[m
[32m+[m[32m            ->_display();[m
[32m+[m[32m            exit;[m
     }[m
 }[m
\ No newline at end of file[m
[1mdiff --git a/application/language/english/form_ui_lang.php b/application/language/english/form_ui_lang.php[m
[1mindex b28a4fe..e5bcc5a 100644[m
[1m--- a/application/language/english/form_ui_lang.php[m
[1m+++ b/application/language/english/form_ui_lang.php[m
[36m@@ -104,6 +104,9 @@[m [m$lang['ui_warehouse'] = "Warehouse";[m
 $lang['ui_receiveitem'] = "Receive Item";[m
 $lang['ui_receivedate'] = "Receive Date";[m
 $lang['ui_receiveno'] = "Receive No.";[m
[32m+[m[32m$lang['ui_sitestatus'] = "Site Status";[m
[32m+[m[32m$lang['ui_live'] = "Live";[m
[32m+[m[32m$lang['ui_maintenance'] = "Maintenance";[m
 [m
 [m
 $lang['msg_orderuomconvertion'] = "Please order Unit Convertion from biggest to smallest unit. for example : Box to Pack (order number = 1), Pack to Pcs (order number = 2) and go on";[m
[1mdiff --git a/application/language/indonesia/form_ui_lang.php b/application/language/indonesia/form_ui_lang.php[m
[1mindex b9daf40..3bdd19b 100644[m
[1m--- a/application/language/indonesia/form_ui_lang.php[m
[1m+++ b/application/language/indonesia/form_ui_lang.php[m
[36m@@ -102,6 +102,9 @@[m [m$lang['ui_warehouse'] = "Gudang";[m
 $lang['ui_receiveitem'] = "Penerimaan Barang";[m
 $lang['ui_receivedate'] = "Tanggal Terima";[m
 $lang['ui_receiveno'] = "No. Penerimaan";[m
[32m+[m[32m$lang['ui_sitestatus'] = "Status Laman";[m
[32m+[m[32m$lang['ui_live'] = "Berjalan";[m
[32m+[m[32m$lang['ui_maintenance'] = "Perbaikan";[m
 [m
 $lang['msg_orderuomconvertion'] = "Urutkan Perubahan ukuran dari paling BESAR ke KECIL. contoh : Box ke Pack (nomor urut = 1), Pack ke Pcs (nomor urut = 2) dan seterusnya";[m
 [m
[1mdiff --git a/application/libraries/Paging.php b/application/libraries/Paging.php[m
[1mindex c1ec87d..1054779 100644[m
[1m--- a/application/libraries/Paging.php[m
[1m+++ b/application/libraries/Paging.php[m
[36m@@ -39,6 +39,7 @@[m [mclass Paging {[m
         $data["marriagestatus"] = 4;[m
         $data["familystatus"] = 5;[m
         $data["citizenship"] = 6;[m
[32m+[m[32m        $data["sitestatus"] = 7;[m
         return $data;[m
     }[m
 [m
[36m@@ -108,6 +109,7 @@[m [mclass Paging {[m
         $resource['res_uom'] = $CI->lang->line('ui_uom');[m
         $resource['res_master_uom'] = $CI->lang->line('ui_master_uom');[m
         $resource['res_warehouse'] = $CI->lang->line('ui_warehouse');[m
[32m+[m[32m        $resource['res_sitestatus'] = $CI->lang->line('ui_sitestatus');[m
 [m
         $resource['flag'] = base_url('assets/bootstrapdashboard/img/flags/16/US.png');[m
         if($_SESSION['language']['language'] === 'indonesia'){[m
[36m@@ -121,10 +123,16 @@[m [mclass Paging {[m
     {[m
         $CI =& get_instance();[m
         $CI->load->library('session');[m
[31m-        $CI->load->model('Login_model');[m
[32m+[m[32m        $CI->load->model(array('Login_model', 'Gsitestatus_model'));[m
         if(isset($_SESSION['userdata']))[m
         {[m
[31m-            [m
[32m+[m[32m            // $sitestatus = $CI->Gsitestatus_model->get_alldata();[m
[32m+[m[32m            // if($sitestatus && $sitestatus->Status === 2){[m
[32m+[m
[32m+[m[32m            // }[m
[32m+[m[32m            // else{[m
[32m+[m[32m            //     $CI->load->view('forbidden/maintenance');[m
[32m+[m[32m            // }[m
         }[m
         else[m
         {[m
[36m@@ -132,10 +140,11 @@[m [mclass Paging {[m
         }[m
     }[m
 [m
[31m-    public function set_data_page_add($resource, $model = null)[m
[32m+[m[32m    public function set_data_page_add($resource, $model = null, $enums = null)[m
     {[m
         $data['resource'] = $resource;[m
         $data['model'] = $model;[m
[32m+[m[32m        $data['enums'] = $enums;[m
         return $data;[m
     }[m
 [m
[1mdiff --git a/application/views/m_item/edit.php b/application/views/m_item/edit.php[m
[1mindex 99a53e8..e0a84f3 100644[m
[1m--- a/application/views/m_item/edit.php[m
[1m+++ b/application/views/m_item/edit.php[m
[36m@@ -66,7 +66,7 @@[m
                       <h4><?php echo $resource['res_uomconversion']?></h4> [m
                     </div>[m
                     <div class = "col-lg-2 icon-custom-table-header">[m
[31m-                      <a id = "information" class = "icon-custom-table-detail" href="#"><i class="fa fa-info-circle"></i></a>[m
[32m+[m[32m                      <a id = "information" class = "icon-custom-table-detail" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a>[m
                       <a class = "icon-custom-table-detail" href="#" data-toggle="collapse" data-target="#collapseUomConvertion"><i class="fa fa-plus"></i></a>[m
                     </div>[m
                   </div>[m
[1mdiff --git a/application/views/template/header.php b/application/views/template/header.php[m
[1mindex e0610c9..01e91bc 100644[m
[1m--- a/application/views/template/header.php[m
[1m+++ b/application/views/template/header.php[m
[36m@@ -96,6 +96,16 @@[m
             <li><a href="<?php echo base_url('muser');?>"><i class="icon-user"></i><?php echo $resource['res_user']?></a></li>[m
           </ul>[m
         </div>[m
[32m+[m[41m        [m
[32m+[m[32m        <?php if($_SESSION['userdata']['username'] == "superadmin") { ?>[m
[32m+[m[41m        [m
[32m+[m[32m        <div class="admin-menu">[m
[32m+[m[32m          <h5 class="sidenav-heading">Sites</h5>[m
[32m+[m[32m          <ul id="side-admin-menu" class="side-menu list-unstyled">[m[41m [m
[32m+[m[32m            <li><a href="<?php echo base_url('sitestatus');?>"><i class="icon-bars"></i><?php echo $resource['res_sitestatus']?></a></li>[m
[32m+[m[32m        </div>[m
[32m+[m[32m        <?php }?>[m
[32m+[m[41m          [m
       </div>[m
     </nav>[m
     <div class="page">[m
