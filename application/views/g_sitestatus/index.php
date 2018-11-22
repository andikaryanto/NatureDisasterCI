<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
        <li class="breadcrumb-item active">Site</li>
        </ul>
    </div>
</div>
<section>
    <div class="container-fluid">
        <header> 
            <h1 class="h3 display"></i></h1>
        </header>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class = "col-lg-10">
                                <h4>Site Status</h4> 
                            </div>
                        </div>
                    </div>
                    <div class="card-body">               
                    <form method = "post" action = "<?php echo base_url('g_sitestatus/editsave');?>">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Status</label>
                                    <select id="status" name="status" class="form-control">
                                    <?php 	
                                    foreach ($enums['sitestatusenum'] as $value)
                                    { 
                                    ?>
                                    <option value ="<?php echo $value->Value?>"><?php echo $resource[$value->Resource]?></option>
                                    <?php 
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group">       
                            <input type="submit" value="<?php echo $resource['res_save']?>" class="btn btn-primary">
                        </div>
                    </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>
</section>
<script type = "text/javascript">

$(document).ready(function(e){
    init();
    $("#status").val(<?php echo $model['status']?>);
});

function init(){
    <?php 
    if($this->session->flashdata('edit_warning_msg'))
    {
      $msg = $this->session->flashdata('edit_warning_msg');
      for($i=0 ; $i<count($msg); $i++)
      {
    ?>
        setNotification("<?php echo $msg[$i]; ?>", 3, "bottom", "right");
    <?php 
      }
    }
    
    if($this->session->flashdata('success_msg'))
    {
      $msg = $this->session->flashdata('success_msg');
      for($i=0 ; $i<count($msg); $i++)
      {
    ?>
        setNotification("<?php echo $msg[$i]; ?>", 2, "bottom", "right");
    <?php 
      }
    }
    ?>
  }

</script>