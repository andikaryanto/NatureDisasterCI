    <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
                      <h4><?php echo $resource['res_edit_data']?></h4> 
                    </div>
                    <div class = "col-lg-2 icon-custom-table-header"><a href="<?php echo base_url('mitem');?>"><i class="fa fa-table"></i> Index</a></div>
                  </div>
                </div>
                <div class="card-body">
                  <form method = "post" action = "<?php echo base_url('mitem/editsave');?>">

                    <div class="form-group">
                      <label><?php echo $resource['res_name']?></label>
                      <input hidden="true" id = "itemid" type="text" class="form-control" name = "itemid" value="<?php echo $model['id']?>">
                      <input id="named" type="text" placeholder="<?php echo $resource['res_name']?>" class="form-control" name = "named" value="<?php echo $model['name']?>" required>
                    </div>
                    <div class="form-group">
                      <label><?php echo $resource['res_uom']?></label>
                      <div class="input-group">
                        <input hidden="true" id = "uomid" type="text" class="form-control" name = "uomid" value="<?php echo $model['uomid']?>">
                        <input readonly id = "uomname" placeholder="<?php echo $resource['res_uom']?>" type="text" class="form-control"  name ="uomname" value="<?php echo $model['uomname']?>">
                        <div class="input-group-append">
                          <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" onclick="getModalUom(1);" data-target="#modalUom"><i class="fa fa-search"></i></button>
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
      <section class="forms" id = "uomConvertionSection">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class = "col-lg-10">
                      <h4><?php echo $resource['res_uomconversion']?></h4> 
                    </div>
                    <div class = "col-lg-2 icon-custom-table-header">
                      <a id = "information" class = "icon-custom-table-detail" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a>
                      <a class = "icon-custom-table-detail" href="#" data-toggle="collapse" data-target="#collapseUomConvertion"><i class="fa fa-plus"></i></a>
                    </div>
                  </div>
                </div>
                <div class="card-body collapse" id = "collapseUomConvertion">
                  <div class="form-group ">
                    <div class="row">
                      <div class="col">
                        <input hidden id = "uomconvertionid" value="">
                        <label><?php echo $resource['res_fromuom']?></label>
                          <div class="input-group">
                            <input hidden id = "fromuomid" value="" name = "fromuomid">
                            <input readonly id = "fromuomname" placeholder="<?php echo $resource['res_fromuom']?>" type="text" class="form-control" name = "fromuomname"  value="" readonly>
                            <div class="input-group-append">
                              <button id="btnFromUom" data-toggle="modal" type="button" class="btn btn-primary" onclick="getModalFromUom(1);" data-target="#modalFromUom"><i class="fa fa-search"></i></button>
                            </div>
                          </div>
                      </div>
                      <div class="col">
                        <label><?php echo $resource['res_touom']?></label>
                          <div class="input-group">
                            <input hidden id = "touomid" value="" name = "touomid">
                            <input readonly id = "touomname" placeholder="<?php echo $resource['res_touom']?>" type="text" class="form-control" name = "touomname"  value="" readonly>
                            <div class="input-group-append">
                              <button id="btnToUom" data-toggle="modal" type="button" class="btn btn-primary" onclick="getModalToUom(1);" data-target="#modalToUom"><i class="fa fa-search"></i></button>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col">
                        <label><?php echo $resource['res_qty']?></label>
                        <input id="qty" type="number" placeholder="<?php echo $resource['res_qty']?>" class="form-control" name = "qty" value="1" min = "1" required>
                      </div>
                      
                      <div class="col">
                        <label><?php echo $resource['res_ordernumber']?></label>
                        <input id="ordernumber" type="number" placeholder="<?php echo $resource['res_ordernumber']?>" class="form-control" name = "ordernumber" value="1" min = "1" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">       
                    <button type = "button" id = "btnSaveUomConvertion" value="<?php echo $resource['res_save']?>" class="btn btn-primary text-white"><?php echo $resource['res_save']?>
                  </div>
                  
                </div>
                <div class = "card-header"  id = "uomConvertion">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover" id = "tblUomConvertion">
                      <thead>
                        <tr>
                          <th><?php echo  $resource['res_fromuom']?></th>
                          <th><?php echo  $resource['res_touom']?></th>
                          <th><?php echo  $resource['res_qty']?></th>
                          <th><?php echo  $resource['res_ordernumber']?></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

<!-- modal -->
<div id="modalUom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title"><?php echo $resource['res_uom']?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div id = "cardModalBody" class="card-body">
        <div class="form-group row">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="input-group">
                <input id = "searchInputUoM" type="text" class="form-control" >
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
                <th><?php echo $resource['res_uom']?> </th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modalFromUom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title"><?php echo $resource['res_uom']?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div id = "cardModalFromUomBody" class="card-body">
        <div class="form-group row">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="input-group">
                <input id = "searchInputFromUoM" type="text" class="form-control" >
                <div class="input-group-append">
                  <button id = "searchbuttonFromUom" type="button" class="btn btn-primary" onclick = "getModalFromUom(1);">Search</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table id = "tblFromUomLookUp" class="table table-striped table-hover">
            <thead>
              <tr>
                <th><?php echo $resource['res_uom']?> </th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modalToUom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title"><?php echo $resource['res_uom']?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div id = "cardModalToUomBody" class="card-body">
        <div class="form-group row">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="input-group">
                <input id = "searchInputToUoM" type="text" class="form-control" >
                <div class="input-group-append">
                  <button id = "searchbuttonToUom" type="button" class="btn btn-primary" onclick = "getModalToUom(1);">Search</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table id = "tblToUomLookUp" class="table table-striped table-hover">
            <thead>
              <tr>
                <th><?php echo $resource['res_uom']?> </th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<script type = "text/javascript">

  $(document).ready(function() {  
    init();
    getDataUomConvertion(1);
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
    ?>
  }

  $("#information").on("click", function(e){
    setNotification("<?php echo $resource['res_msg_orderuomconvertion']; ?>", 4, "bottom", "right");
  });

  function getModalUom(page)
  {
    removeModalUomComponent();
    var search = $('#searchInputUoM').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('m_uom/uommodal')?>",
      data:{
            page: page,
            search : search
          },
      success:function(data){
        console.log(data)
        var uom = $.parseJSON(data);
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
  }

  $("#modalUom").on('hidden.bs.modal', function(){
    removeModalUomComponent();
  });

  function removeModalUomComponent()
  {
    $("#tblUomLookUp").find("tr:gt(0)").remove();
    $("#modalUomPaging").remove();
  };

  function getModalFromUom(page)
  {
    removeModalFromUomComponent();
    var search = $('#searchInputFromUoM').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('m_uom/uommodal')?>",
      data:{
            page: page,
            search : search
          },
      success:function(data){
        var uom = $.parseJSON(data);
        var detail = uom['m_uom']['modeldetailmodal'];
        for(var i = 0; i < detail.length; i++)
        {
          $("#tblFromUomLookUp").append("<tr onclick='chooseFromUomName("+detail[i].Id+","+'"'+detail[i].Name+'"'+");'><td>" + detail[i].Name + "</td></tr>");
        }

        var previous = "";
        var pages = "";
        var next = "";
        var append = "";
        if(uom['m_uom']['currentpagemodal'] > 3)
        {
          previous += "<li class='page-item'>";
          previous += "<a class='page-link' href='#' onclick = 'getModalFromUom("+(uom['m_uom']['currentpagemodal']-1)+")' aria-label='Previous'>";
          previous += "<span aria-hidden='true'>&laquo;</span>";
          previous += "<span class='sr-only'>Previous</span>";
          previous += "</a>" ;
          previous += "</li>";
        }

        for (var i = uom['m_uom']['firstpagemodal'] ; i <= uom['m_uom']['lastpagemodal']; i++){
          pages += " <li class='page-item' >";
          pages += "<a class='page-link' href='#' onclick = 'getModalFromUom("+i+")'>"+i+"</a>";
          pages += "</li>";
        }

        if(uom['m_uom']['currentpagemodal'] < uom['m_uom']['totalpagemodal'] - 2)
        {
          next += "<li class='page-item'>";
          next += "<a class='page-link' href='#' onclick = 'getModalFromUom("+(1+uom['m_uom']['currentpagemodal'])+")' aria-label='Next'>";
          next += "<span aria-hidden='true'>&raquo;</span>";
          next += "<span class='sr-only'>Next</span>";
          next += "</a>" ;
          next += "</li>";
        }

        append += "<div id = 'modalFromUomPaging' class='row'>";
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
        
        $("#cardModalFromUomBody").append(append);

      }
    });
  };

  function chooseFromUomName(Id, Name)
  {
    $("#fromuomid").val(Id);
    $("#fromuomname").val(Name);
    $('#modalFromUom').modal('hide');
  }

  $("#modalFromUom").on('hidden.bs.modal', function(){
    removeModalFromUomComponent();
  });

  function removeModalFromUomComponent()
  {
    $("#tblFromUomLookUp").find("tr:gt(0)").remove();
    $("#modalFromUomPaging").remove();
  };

  function getModalToUom(page)
  {
    removeModalToUomComponent();
    var search = $('#searchInputToUoM').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('m_uom/uommodal')?>",
      data:{
            page: page,
            search : search
          },
      success:function(data){
        var uom = $.parseJSON(data);
        var detail = uom['m_uom']['modeldetailmodal'];
        for(var i = 0; i < detail.length; i++)
        {
          $("#tblToUomLookUp").append("<tr onclick='chooseToUomName("+detail[i].Id+","+'"'+detail[i].Name+'"'+");'><td>" + detail[i].Name + "</td></tr>");
        }

        var previous = "";
        var pages = "";
        var next = "";
        var append = "";
        if(uom['m_uom']['currentpagemodal'] > 3)
        {
          previous += "<li class='page-item'>";
          previous += "<a class='page-link' href='#' onclick = 'getModalToUom("+(uom['m_uom']['currentpagemodal']-1)+")' aria-label='Previous'>";
          previous += "<span aria-hidden='true'>&laquo;</span>";
          previous += "<span class='sr-only'>Previous</span>";
          previous += "</a>" ;
          previous += "</li>";
        }

        for (var i = uom['m_uom']['firstpagemodal'] ; i <= uom['m_uom']['lastpagemodal']; i++){
          pages += " <li class='page-item' >";
          pages += "<a class='page-link' href='#' onclick = 'getModalToUom("+i+")'>"+i+"</a>";
          pages += "</li>";
        }

        if(uom['m_uom']['currentpagemodal'] < uom['m_uom']['totalpagemodal'] - 2)
        {
          next += "<li class='page-item'>";
          next += "<a class='page-link' href='#' onclick = 'getModalToUom("+(1+uom['m_uom']['currentpagemodal'])+")' aria-label='Next'>";
          next += "<span aria-hidden='true'>&raquo;</span>";
          next += "<span class='sr-only'>Next</span>";
          next += "</a>" ;
          next += "</li>";
        }

        append += "<div id = 'modalToUomPaging' class='row'>";
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
        
        $("#cardModalToUomBody").append(append);

      }
    });
  };

  function chooseToUomName(Id, Name)
  {
    $("#touomid").val(Id);
    $("#touomname").val(Name);
    $('#modalToUom').modal('hide');
  }

  $("#modalToUom").on('hidden.bs.modal', function(){
    removeModalToUomComponent();
  });

  function removeModalToUomComponent()
  {
    $("#tblToUomLookUp").find("tr:gt(0)").remove();
    $("#modalToUomPaging").remove();
  };

  $("#btnSaveUomConvertion").on("click", function(e){
    var id = $("#uomconvertionid").val();
    var itemid = $("#itemid").val();
    var fromuomid = $("#fromuomid").val();
    var fromuomname = $("#fromuomname").val();
    var touomid = $("#touomid").val();
    var touomname = $("#touomname").val();
    var qty = $("#qty").val();
    var ordernumber = $("#ordernumber").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url('m_item/saveuomconvertion')?>",
      data: {
        id: id,
        itemid:itemid,
        fromuomid: fromuomid,
        fromuomname: fromuomname,
        touomid: touomid,
        touomname: touomname,
        qty: qty,
        ordernumber: ordernumber
      },
      success:function(data){
        if(data !== "success"){
          var msg = $.parseJSON(data);
          console.log(msg);
          for(var i = 0; i < msg.length; i++){
            setNotification(msg[i], 3, "bottom", "right");
          }
        } else {
          resetUomConvertion();
          location.reload();
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr.status);
        console.log(thrownError);
      }
      
    });
  })

  function resetUomConvertion(){
    $("#fromuomid").val("");
    $("#fromuomname").val("");
    $("#touomid").val("");
    $("#touomname").val("");
    $("#qty").val("");
    $("#ordernumber").val("");
  }

  function removeUomConvertionGrid()
  {
    $("#tblUomConvertion").find("tr:gt(0)").remove();
    $("#uomConvertionPaging").remove();
  };

  function getDataUomConvertion(page){
    //alert("here");
    var iditem = $("#itemid").val();
    //alert(iditem);
    $.ajax({
      url: "<?php echo base_url("m_item/getuomconvertion")?>",
      type: 'POST',
      data: {
        iditem: iditem,
        page: page
      },
      success:function(data){
        removeUomConvertionGrid();
        var datas = $.parseJSON(data);
        var res = <?php echo json_encode($resource)?>;
        var detail = datas['modeldetail'];
        //console.log(detail);
        for(var i = 0; i < detail.length; i++)
        {
          //alert(detail);
          $("#tblUomConvertion").append("<tr>"+
                                        "<td>" + detail[i].FromUomName + "</td>"+
                                        "<td>" + detail[i].ToUomName + "</td>"+
                                        "<td>" + detail[i].Qty + "</td>"+
                                        "<td>" + detail[i].OrderNumber + "</td>"+
                                        "<td class = 'icon-custom-table-header'>" +
                                        "<a class = 'icon-custom-table-detail' href='javascript:void(0);' onclick='edit_itemconvertion("+detail[i].Id+");'><i class='fa fa-edit'></i>"+res['res_edit']+"</a>" +
                                        "<a class = 'icon-custom-table-detail' href='javascript:void(0);' onclick='delete_itemconvertion("+detail[i].Id+");'><i class='fa fa-edit'></i>"+res['res_delete']+"</a>" +
                                        "</td>"+
                                        "</tr>");
        }
        
        var previous = "";
        var pages = "";
        var next = "";
        var append = "";
        if(datas['currentpage'] > 3)
        {
          previous += "<li class='page-item'>";
          previous += "<a class='page-link' href='#uomConvertionSection' onclick = 'getDataUomConvertion("+(datas['currentpage']-1)+")' aria-label='Previous'>";
          previous += "<span aria-hidden='true'>&laquo;</span>";
          previous += "<span class='sr-only'>Previous</span>";
          previous += "</a>" ;
          previous += "</li>";
        }

        for (var i = datas['firstpage'] ; i <= datas['lastpage']; i++){
          pages += " <li class='page-item' >";
          pages += "<a class='page-link' href='#uomConvertionSection' onclick = 'getDataUomConvertion("+i+")'>"+i+"</a>";
          pages += "</li>";
        }

        if(datas['currentpage'] < datas['totalpage'] - 2)
        {
          next += "<li class='page-item'>";
          next += "<a class='page-link' href='#uomConvertionSection' onclick = 'getDataUomConvertion("+(1+datas['currentpage'])+")' aria-label='Next'>";
          next += "<span aria-hidden='true'>&raquo;</span>";
          next += "<span class='sr-only'>Next</span>";
          next += "</a>" ;
          next += "</li>";
        }

        append += "<div id = 'uomConvertionPaging' class='row'>";
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
        append +="Total Data : "+datas['totalrow'];
        append += "</div>";
        append += "</div>";

        
        $("#uomConvertion").append(append);
      }
    });
  }

  function edit_itemconvertion(id)
  {
    $.ajax({
      url: "<?php echo base_url('m_item/edituomconvertion')?>",
      type: "POST",
      data:{
        id : id,
      },
      success:function(data){
        var detail = $.parseJSON(data);
        console.log(detail);
        $("#uomconvertionid").val(detail['Id']);
        $("#fromuomid").val(detail['FromUomId']);
        $("#fromuomname").val(detail['FromUomName']);
        $("#touomid").val(detail['ToUomId']);
        $("#touomname").val(detail['ToUomName']);
        $("#qty").val(detail['Qty']);
        $("#ordernumber").val(detail['OrderNumber']);
      }
    })
  }

  function delete_itemconvertion(id)
  {
    deleteData("", function(result){
      if (result==true){
        $.ajax({
          url: "<?php echo base_url('m_item/deleteuomconvertion')?>",
          type: "POST",
          data:{
            id : id,
          },
          success:function(data){
            if(data == "success")
              location.reload();
          }
        })
      }
    })
  }
</script>