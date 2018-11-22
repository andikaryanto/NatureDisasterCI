    <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Master       </li>
          </ul>
        </div>
    </div>
      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display"><i class="fa fa-fire"></i><?php echo $resource['res_master_item']?></h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
									<div class="row">
                    <div class = "col-lg-10">
                      <h4><?php echo $resource['res_add_data']?></h4> 
                    </div>
                    <div class = "col-lg-2 icon-custom-table-header"><a href="<?php echo base_url('mitem');?>"><i class="fa fa-table"></i> Index</a></div>
                  </div>
                </div>
                <div class="card-body">                 
                  <form method = "post" action = "<?php echo base_url('mitem/addsave');?>">
                    <div class="form-group">
                      <label><?php echo $resource['res_name']?></label>
                      <input id="named" type="text" placeholder="<?php echo $resource['res_name']?>" class="form-control" name = "named" value="<?php echo $model['name']?>" required>
                    </div>
                    <div class="form-group">
                      <label><?php echo $resource['res_uom']?></label>
                      <div class="input-group">
                        <input hidden="true" id = "uomid" type="text" class="form-control" name = "uomid" value="<?php echo $model['uomid']?>">
                        <input readonly id = "uomname" placeholder="<?php echo $resource['res_uom']?>" type="text" class="form-control"  value="<?php echo $model['uomname']?>">
                        <div class="input-group-append">
                          <button id="btnUomModal" data-toggle="modal" type="button" class="btn btn-primary" onclick="getModalUom(1);" data-target="#modalUom"><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">       
                      <label><?php echo $resource['res_description']?></label>
                      <textarea id="description" type="text" placeholder="<?php echo $resource['res_description']?>" class="form-control" name = "description" ><?php echo $model['description']?></textarea>
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
<div id="modalUom" tabindex="-1" role="dialog" aria-labelledby="modalUomLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modalUomLabel" class="modal-title">Uom</h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div id = "cardModalBody" class="card-body">
        <div class="form-group row">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="input-group">
                <input id = "searchInput" type="text" class="form-control" >
                <div class="input-group-append">
                  <button id = "searchbutton" type="button" class="btn btn-primary" onclick = "getModalUom(1);">Search</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table id = "tblUomLookUp" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Uom </th>
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
    if($this->session->flashdata('add_warning_msg'))
    {
      $msg = $this->session->flashdata('add_warning_msg');
      for($i=0 ; $i<count($msg); $i++)
      {
    ?>
        setNotification("<?php echo $msg[$i]; ?>", 3, "bottom", "right");
    <?php 
      }
    }
    ?>
  }

  function getModalUom(page)
  {
    removeModalUomComponent();
    var search = $('#searchInput').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('m_uom/uommodal')?>",
      data:{
            page: page,
            search : search
          },
      success:function(data){
        var uom = $.parseJSON(data);
        console.log(uom);
        var detail = uom['m_uom']['modeldetailmodal'];
        for(var i = 0; i < detail.length; i++)
        {
          $("#tblUomLookUp").append("<tr onclick='chooseUomName("+detail[i].Id+","+'"'+detail[i].Name+'"'+");'><td>" + detail[i].Name + "</td></tr>");
        }

        var previous = "";
        var pages = "";
        var next = "";
        var append = "";
        if(uom['m_uom']['currentpagemodal'] > 3)
        {
          previous += "<li class='page-item'>";
          previous += "<a class='page-link' href='#' onclick = 'getModalUom("+(uom['m_uom']['currentpagemodal']-1)+")' aria-label='Previous'>";
          previous += "<span aria-hidden='true'>&laquo;</span>";
          previous += "<span class='sr-only'>Previous</span>";
          previous += "</a>" ;
          previous += "</li>";
        }

        for (var i = uom['m_uom']['firstpagemodal'] ; i <= uom['m_uom']['lastpagemodal']; i++){
          pages += " <li class='page-item' >";
          pages += "<a class='page-link' href='#' onclick = 'getModalUom("+i+")'>"+i+"</a>";
          pages += "</li>";
        }

        if(uom['m_uom']['currentpagemodal'] < uom['m_uom']['totalpagemodal'] - 2)
        {
          next += "<li class='page-item'>";
          next += "<a class='page-link' href='#' onclick = 'getModalUom("+(1+uom['m_uom']['currentpagemodal'])+")' aria-label='Next'>";
          next += "<span aria-hidden='true'>&raquo;</span>";
          next += "<span class='sr-only'>Next</span>";
          next += "</a>" ;
          next += "</li>";
        }

        append += "<div id = 'modalUomPaging' class='row'>";
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
        append +="Total Data : "+uom['m_uom']['totalrowmodal'];
        append += "</div>";
        append += "</div>";
        
        $("#cardModalBody").append(append);

      }
    });
  };

  function chooseUomName(Id, Name)
  {
    $("#uomid").val(Id);
    $("#uomname").val(Name);
    $('#modalUom').modal('hide');
  };

  $("#modalUom").on('hidden.bs.modal', function(){
    removeModalUomComponent();
  });

  function removeModalUomComponent()
  {
    $("#tblUomLookUp").find("tr:gt(0)").remove();
    $("#modalUomPaging").remove();
  };
</script>