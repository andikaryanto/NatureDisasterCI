<div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active"><?php echo $resource['res_transaction']?></li>
          </ul>
        </div>
    </div>
      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display"><i class="fa fa-fire"></i><?php echo $resource['res_disaster_occur']?></h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                        <div class="row">
                    <div class = "col-lg-10">
                      <h4><?php echo $resource['res_add_data']?></h4> 
                    </div>
                    <div class = "col-lg-2 icon-custom-table-header"><a href="<?php echo base_url('tdisasteroccur');?>"><i class="fa fa-table"></i> Index</a></div>
                  </div>
                </div>
                <div class="card-body">
                  <form method = "post" action = "<?php echo base_url('tdisasteroccur/editsave');?>">
                  
                  <input hidden id = "disasteroccurid" name = "disasteroccurid" value="<?php echo $model['id']?>">

                    <div class="form-group ">
                        <div class="row">
                            <div class="col">
                                <label><?php echo $resource['res_nodisaster']?></label>
                                <input id="nodisaster" type="text" placeholder="[ Auto Generate ]" class="form-control" name = "nodisaster" value="<?php echo $model['nodisaster']?>" disabled>
                            </div>
                            <div class="col">              
                                <label><b><?php echo $resource['res_disaster']?>*</b></label>   
                                <div class="input-group">            
                                    <input hidden id = "disasterid" name = "disasterid" value="<?php echo $model['disasterid']?>">   
                                    <input readonly id="disastername" type="text" placeholder="<?php echo $resource['res_disaster']?>" class="form-control" name = "disastername" value="<?php echo $model['disastername']?>" required>
                                    <div class="input-group-append">
                                        <button id="btnDisasterModal" data-toggle="modal" type="button" class="btn btn-primary" onclick="getModalDisaster(1);" data-target="#modalDisaster"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col">
                                <label><b>Latitude*</b></label>
                                <input id="latitude" type="text" placeholder="Latitude" class="form-control" name = "latitude" value="<?php echo $model['latitude']?>">
                            </div>
                            <div class="col">
                                <label><b>Longitude*</b></label>
                                <input id="longitude" type="text" placeholder="Longitude" class="form-control" name = "longitude" value="<?php echo $model['longitude']?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col">
                                <label><?php echo $resource['res_village']?></label>   
                                <div class="input-group">            
                                    <input hidden id = "villageid" name = "villageid" value="<?php echo $model['villageid']?>">   
                                    <input readonly id="villagename" type="text" placeholder="<?php echo $resource['res_village']?>" class="form-control" name = "villagename" value="<?php echo $model['villagename']?>" required>
                                    <div class="input-group-append">
                                        <button id="btnVillageModal" data-toggle="modal" type="button" class="btn btn-primary" onclick="getModalVillage(1);" data-target="#modalVillage"><i class="fa fa-search"></i></button>
                                    </div>
                                </div></div>
                            <div class="col">
                                <label>RT</label>
                                <input id="rt" type="text" placeholder="RT" class="form-control" name = "rt" value="<?php echo $model['rt']?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col">
                                <label>RW</label>
                                <input id="rw" type="text" placeholder="RW" class="form-control" name = "rw" value="<?php echo $model['rw']?>">
                            </div>
                            <div class="col" style="margin-top:4%">
                                <div class="i-checks">
                                <input id="isneedlogistic" name = "isneedlogistic" type="checkbox" class="form-control-custom" value = "1"
                                  <?php if($model['isneedlogistic'] == 1){ ?>
                                         checked
                                  <?php
                                        }
                                  ?>
                                >
                                <label for="isneedlogistic"><?php echo $resource['res_isneedlogistic']?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                    <div class="row">
                        <div class="col">
                            <label><?php echo $resource['res_description']?></label>
                            <textarea id="description" type="text" placeholder="<?php echo $resource['res_description']?>" class="form-control" name = "description" ><?php echo $model['description']?></textarea> 
                        </div>
                        
                    </div>
                  </div>
                    <div class="form-group">       
                      <input type="submit" value="<?php echo $resource['res_save']?>" class="btn btn-primary">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

<!-- modal -->
<div id="modalDisaster" tabindex="-1" role="dialog" aria-labelledby="modalDisasterLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modalDisasterLabel" class="modal-title"><?php echo $resource['res_disaster']?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div id = "cardModalDisasterBody" class="card-body">
        <div class="form-group row">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="input-group">
                <input id = "searchInput" type="text" class="form-control" >
                <div class="input-group-append">
                  <button id = "searchbutton" type="button" class="btn btn-primary" onclick = "getModalDisaster(1);">Search</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table id = "tblDisasterLookUp" class="table table-striped table-hover">
            <thead>
              <tr>
                <th><?php echo $resource['res_disaster']?> </th>
                
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<div id="modalVillage" tabindex="-1" role="dialog" aria-labelledby="modalVillageLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modalVillageLabel" class="modal-title"><?php echo $resource['res_village']?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div id = "cardModalVillageBody" class="card-body">
        <div class="form-group row">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="input-group">
                <input id = "searchInput" type="text" class="form-control" >
                <div class="input-group-append">
                  <button id = "searchbutton" type="button" class="btn btn-primary" onclick = "getModalVillage(1);">Search</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table id = "tblVillageLookUp" class="table table-striped table-hover">
            <thead>
              <tr>
                <th><?php echo $resource['res_village']?> </th>
                <th><?php echo $resource['res_subcity']?> </th>
                <th><?php echo $resource['res_city']?> </th>
                <th><?php echo $resource['res_province']?> </th>
                
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<script type = "text/javascript">

  $(document).ready(function() {    
    init();
  });

  function init(){
    <?php 
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
    ?>
  }

  function getModalDisaster(page)
  {
    removeModalDisasterComponent();
    var search = $('#searchInput').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('m_disaster/disastermodal')?>",
      data:{
            page: page,
            search : search
          },
      success:function(data){
        var disaster = $.parseJSON(data);
        console.log(disaster);
        var detail = disaster['m_disaster']['modeldetailmodal'];
        for(var i = 0; i < detail.length; i++)
        {
          $("#tblDisasterLookUp").append("<tr onclick='chooseDisasterName("+detail[i].Id+","+'"'+detail[i].Name+'"'+");'><td>" + detail[i].Name + "</td></tr>");
        }

        var previous = "";
        var pages = "";
        var next = "";
        var append = "";
        if(disaster['m_disaster']['currentpagemodal'] > 3)
        {
          previous += "<li class='page-item'>";
          previous += "<a class='page-link' href='#' onclick = 'getModalDisaster("+(disaster['m_disaster']['currentpagemodal']-1)+")' aria-label='Previous'>";
          previous += "<span aria-hidden='true'>&laquo;</span>";
          previous += "<span class='sr-only'>Previous</span>";
          previous += "</a>" ;
          previous += "</li>";
        }

        for (var i = disaster['m_disaster']['firstpagemodal'] ; i <= disaster['m_disaster']['lastpagemodal']; i++){
          pages += " <li class='page-item' >";
          pages += "<a class='page-link' href='#' onclick = 'getModalDisaster("+i+")'>"+i+"</a>";
          pages += "</li>";
        }

        if(disaster['m_disaster']['currentpagemodal'] < disaster['m_disaster']['totalpagemodal'] - 2)
        {
          next += "<li class='page-item'>";
          next += "<a class='page-link' href='#' onclick = 'getModalDisaster("+(1+disaster['m_disaster']['currentpagemodal'])+")' aria-label='Next'>";
          next += "<span aria-hidden='true'>&raquo;</span>";
          next += "<span class='sr-only'>Next</span>";
          next += "</a>" ;
          next += "</li>";
        }

        append += "<div id = 'modalDisasterPaging' class='row'>";
        append += "<div class = 'col-lg-6'>";
        append += "<nav aria-label='Page navigation example'>";
        append += "<ul class='pagination'>";
        append += previous;
        append += pages;
        append += next;
        append += "</ul>";
        append += "</nav>";
        append += "</div>";
        append += "<div class = 'col-lg-6 icon-custom-table-header'>";
        append +="Total Data : "+disaster['m_disaster']['totalrowmodal'];
        append += "</div>";
        append += "</div>";
        
        $("#cardModalDisasterBody").append(append);

      }
    });
  };

  function chooseDisasterName(Id, Name)
  {
    $("#disasterid").val(Id);
    $("#disastername").val(Name);
    $('#modalDisaster').modal('hide');
  };

  $("#modalDisaster").on('hidden.bs.modal', function(){
    removeModalDisasterComponent();
  });

  function removeModalDisasterComponent()
  {
    $("#tblDisasterLookUp").find("tr:gt(0)").remove();
    $("#modalDisasterPaging").remove();
  };

  //Village
  function getModalVillage(page)
  {
    removeModalVillageComponent();
    var search = $('#searchInput').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('m_village/villagemodal')?>",
      data:{
            page: page,
            search : search
          },
      success:function(data){
        var village = $.parseJSON(data);
        console.log(village);
        var detail = village['m_village']['modeldetailmodal'];
        for(var i = 0; i < detail.length; i++)
        {
          $("#tblVillageLookUp").append("<tr onclick='chooseVillageName("+detail[i].Id+","+'"'+detail[i].Name+'"'+");'>"+
          "<td>" + detail[i].Name + "</td>"+
          "<td>" + detail[i].SubcityName + "</td>"+
          "<td>" + detail[i].CityName + "</td>"+
          "<td>" + detail[i].ProvinceName + "</td>"+
          "</tr>");
        }

        var previous = "";
        var pages = "";
        var next = "";
        var append = "";
        if(village['m_village']['currentpagemodal'] > 3)
        {
          previous += "<li class='page-item'>";
          previous += "<a class='page-link' href='#' onclick = 'getModalVillage("+(village['m_village']['currentpagemodal']-1)+")' aria-label='Previous'>";
          previous += "<span aria-hidden='true'>&laquo;</span>";
          previous += "<span class='sr-only'>Previous</span>";
          previous += "</a>" ;
          previous += "</li>";
        }

        for (var i = village['m_village']['firstpagemodal'] ; i <= village['m_village']['lastpagemodal']; i++){
          pages += " <li class='page-item' >";
          pages += "<a class='page-link' href='#' onclick = 'getModalVillage("+i+")'>"+i+"</a>";
          pages += "</li>";
        }

        if(village['m_village']['currentpagemodal'] < village['m_village']['totalpagemodal'] - 2)
        {
          next += "<li class='page-item'>";
          next += "<a class='page-link' href='#' onclick = 'getModalVillage("+(1+village['m_village']['currentpagemodal'])+")' aria-label='Next'>";
          next += "<span aria-hidden='true'>&raquo;</span>";
          next += "<span class='sr-only'>Next</span>";
          next += "</a>" ;
          next += "</li>";
        }

        append += "<div id = 'modalVillagePaging' class='row'>";
        append += "<div class = 'col-lg-6'>";
        append += "<nav aria-label='Page navigation example'>";
        append += "<ul class='pagination'>";
        append += previous;
        append += pages;
        append += next;
        append += "</ul>";
        append += "</nav>";
        append += "</div>";
        append += "<div class = 'col-lg-6 icon-custom-table-header'>";
        append +="Total Data : "+village['m_village']['totalrowmodal'];
        append += "</div>";
        append += "</div>";
        
        $("#cardModalVillageBody").append(append);

      }
    });
  };

  function chooseVillageName(Id, Name)
  {
    $("#villageid").val(Id);
    $("#villagename").val(Name);
    $('#modalVillage').modal('hide');
  };

  $("#modalVillage").on('hidden.bs.modal', function(){
    removeModalVillageComponent();
  });

  function removeModalVillageComponent()
  {
    $("#tblVillageLookUp").find("tr:gt(0)").remove();
    $("#modalVillagePaging").remove();
  };
</script>