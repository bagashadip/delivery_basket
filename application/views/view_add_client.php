<?php
  $no = 0;
  foreach ($last_id as $row) {
      $no = $row->client_id;
  }

  if($no == null){
    $id = 1;
  }else{
    $id = $no + 1;
  }
?>
<section id="main-content">
  <section class="wrapper site-min-height">
  <?php
    if(!empty($this->session->flashdata())){
      $result = $this->session->flashdata('alert');
      ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="<?php echo $result['cls']; ?>">
              <strong><?php echo $result['status']; ?> - </strong> <?php echo $result['msg']; ?>
            </div>
          </div>
        </div>
      <?php
    }
  ?>
    <div class="row">
      <div class="col-lg-12">
          <section class="panel">
              <header class="panel-heading">
                  <b>Add Client</b>
                  <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                  </span>
              </header>
              <div class="panel-body">
                  <div class="form">
                      <?php
                        $attributes = array('class' => 'cmxform form-horizontal tasi-form');
                        echo form_open_multipart(site_url("Add_client/add_data_client"), $attributes);
                      ?>
                          <div class="form-group ">
                              <label for="cname" class="control-label col-lg-2">Client Id</label>
                              <div class="col-lg-1">
                                  <input class=" form-control" id="client_id" name="client_id" type="text" value="<?php echo $id; ?>" readonly />
                              </div>
                          </div>
                          <div class="form-group ">
                              <label for="cname" class="control-label col-lg-2">Client Name</label>
                              <div class="col-lg-3">
                                  <input class=" form-control" id="client_name" name="client_name" type="text" required />
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-lg-offset-2 col-lg-10">
                                  <input class="btn btn-danger" type="submit" id="btn_save" name="save" value="Save" />
                                  <input class="btn btn-warning" type="submit" id="btn_update" name="update" value="Update" disabled="disabled" />
                                  <input type="reset" class="btn btn-primary" id="btn_cancel" value="Cancel" />
                              </div>
                          </div>
                      <?php echo form_close(); ?>
                  </div>
              </div>
          </section>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
          <section class="panel">
              <header class="panel-heading">
                  <b>Client Data</b>
                  <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                  </span>
              </header>
              <div class="panel-body">
                  <table id="example" class="display nowrap" cellspacing="0" width="100%" data-page-length="10" data-order="[[ 1, &quot;asc&quot; ]]">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Client</th>
                      <th>Create Date</th>
                      <th>Update Date</th>
                      <th>Option</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                    foreach ($clients as $row) {
                      ?>
                        <tr>
                          <td><?php echo $row->client_id; ?></td>
                          <td><?php echo $row->client_name; ?></td>
                          <td><?php echo $row->client_create_date; ?></td>
                          <td><?php echo $row->client_update_date; ?></td>
                          <td>
                            <a href="#" class="btn btn-primary btn-xs" onClick="get_client('<?php echo $row->client_id; ?>','<?php echo $row->client_name; ?>')"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:if(confirm('Are you sure want to delete this?')){document.location='<?php echo base_url("add_client/delete_client/$row->client_id") ?>';}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                          </td>
                        </tr>
                      <?php
                    }
                  ?>
              </tbody>
              </table>
            </div>
        </section>
      </div>
    </div>
  </section>
</section>
<script>
  $(document).ready(function() {
      $('#example')
          .DataTable({
              "scrollY": 300,
              "scrollX": true
      });
  });

  function get_client(id,name){
      $("#client_id").val(id);
      $("#client_name").val(name);
      $("#btn_update").removeAttr("disabled");
      $("#btn_save").attr("disabled",true);
      $("#btn_cancel").attr("disabled",true); 
  }
</script>