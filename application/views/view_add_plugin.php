<?php
  $no = 0;
  foreach ($last_id as $row) {
      $no = $row->plugin_id;
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
      if(!empty($error)){
        ?>
          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-danger">
                <strong>Error!</strong> <?php echo $error; ?>
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
                  Add Plugin
              </header>
              <div class="panel-body">
                  <div class=" form">
                      <?php
                        $attributes = array('class' => 'cmxform form-horizontal tasi-form');
                        echo form_open_multipart('add_plugin/add_data_plugin/', $attributes);
                      ?>
                      <form class="cmxform form-horizontal tasi-form" id="commentForm" method="get" action="">
                          <div class="form-group ">
                              <label for="cname" class="control-label col-lg-2">Plugin Id</label>
                              <div class="col-lg-1">
                                  <input class=" form-control" id="p_id" name="p_id" type="text" value="<?php echo $id; ?>" readonly />
                              </div>
                          </div>
                          <div class="form-group ">
                              <label for="cname" class="control-label col-lg-2">Plugin Name</label>
                              <div class="col-lg-4">
                                  <input class=" form-control" id="p_name" name="p_name" type="text" required="required" placeholder="your_file_name" />
                              </div>
                              <div class="col-lg-1">
                                <select class="form-control" name="ext">
                                  <option value=".zip">.zip</option>
                                </select>
                              </div>
                          </div>
                          <div class="form-group ">
                              <label for="cname" class="control-label col-lg-2">Client</label>
                              <div class="col-lg-3">
                                  <select class="form-control" name="p_client" id="p_client">
                                    <?php
                                      foreach ($clients as $data_client) {
                                        ?>
                                          <option value="<?php echo $data_client->client_id; ?>"><?php echo $data_client->client_name; ?></option>
                                        <?php
                                      }
                                    ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group ">
                              <label for="cname" class="control-label col-lg-2">Shop</label>
                              <div class="col-lg-3">
                                  <select class="form-control" name="p_shop" id="p_shop">
                                    <?php
                                      foreach ($shops as $data_shop) {
                                        ?>
                                          <option value="<?php echo $data_shop->shop_id; ?>"><?php echo $data_shop->shop_name; ?></option>
                                        <?php
                                      }
                                    ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2"">File</label>
                              <div class="col-lg-3">
                                  <input type="file" class="default" name="userfile" />
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-lg-offset-2 col-lg-10">
                                  <input class="btn btn-danger" type="submit" id="btn_save" name="save" value="Save" />
                                  <input class="btn btn-warning" type="submit" id="btn_update" name="update" value="Update" disabled="disabled" />
                                  <input type="submit" class="btn btn-primary" id="btn_cancel" name="cancel" value="Cancel" />
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
                  <b>User Data</b>
                  <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                  </span>
              </header>
              <div class="panel-body">
                  <table id="example" class="display nowrap" cellspacing="0" width="100%" data-page-length="10" data-order="[[ 1, &quot;asc&quot; ]]">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Plugin</th>
                      <th>Client</th>
                      <th>Shop</th>
                      <th>Create Date</th>
                      <th>Update Date</th>
                      <th>Option</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                    foreach ($plugins as $row) {
                      ?>
                        <tr>
                          <td><?php echo $row->plugin_id; ?></td>
                          <td><?php echo $row->plugin_name; ?></td>
                          <td><?php echo $row->client_name; ?></td>
                          <td><?php echo $row->shop_name; ?></td>
                          <td><?php echo $row->plugin_create_date; ?></td>
                          <td><?php echo $row->plugin_update_date; ?></td>
                          <td>
                            <a href="#" class="btn btn-primary btn-xs" onClick="get_plugin('<?php echo $row->plugin_id; ?>', '<?php echo $row->plugin_name; ?>', '<?php echo $row->client_id; ?>', '<?php echo $row->shop_id; ?>')"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:if(confirm('Are you sure want to delete this?')){document.location='<?php echo base_url("add_plugin/delete_plugin/$row->plugin_id") ?>';}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
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

  function get_plugin(id,plugin,client_id,shop_id){
      $("#p_id").val(id);
      $("#p_name").val(plugin);
      $('#p_client').val(client_id);
      $('#p_shop').val(shop_id);
      $("#btn_update").removeAttr("disabled");
      $("#btn_save").attr("disabled",true);
      // $("#btn_cancel").attr("disabled",true); 
  }
</script>