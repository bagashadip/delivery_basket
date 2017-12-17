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
                  Add Folder
              </header>
              <div class="panel-body">
                  <div class=" form">
                      <?php
                        $attributes = array('class' => 'cmxform form-horizontal tasi-form');
                        echo form_open_multipart(site_url("Add_folder/add_data_folder"), $attributes);
                      ?>
                          <div class="form-group ">
                              <label for="cname" class="control-label col-lg-2">Client</label>
                              <div class="col-lg-3">
                                  <select class="form-control" name="c_client" id="c_client">
                                    <option>--- Client ---</option>
                                    <?php
                                      foreach ($clients as $row) {
                                        ?>
                                          <option value="<?php echo $row->client_id; ?>"><?php echo $row->client_name; ?></option>
                                        <?php
                                      }
                                    ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="cname" class="control-label col-lg-2">Shops</label>
                            <div class="col-lg-4">
                                <?php
                                  foreach ($shops as $row) {
                                    ?>
                                      <div class="form-check">
                                        <label class="form-check-label">
                                            <input name="shops[]" id="<?php echo $row->shop_id; ?>" value="<?php echo $row->shop_id; ?>" type="checkbox" /> <?php echo $row->shop_name; ?>
                                        </label>
                                      </div>
                                    <?php
                                  }
                                ?>
                            </div>
                          </div>
                          <div class="form-group">
                              <div class="col-lg-offset-2 col-lg-10">
                                  <input class="btn btn-danger" type="submit" id="btn_save" name="save" value="Save" />
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
                  <b>All Folders</b>
                  <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                  </span>
              </header>
              <div class="panel-body">
                  <table id="example" class="display nowrap" cellspacing="0" width="100%" data-page-length="10" data-order="[[ 1, &quot;asc&quot; ]]">
              <thead>
                  <tr>
                      <th>Client</th>
                      <th>Create Date</th>
                      <th align="center">Status</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                    foreach ($folders as $row) {
                      ?>
                        <tr>
                          <td><?php echo $row->client_name; ?></td>
                          <td><?php echo $row->create_date; ?></td>
                          <td align="center">
                            <?php
                                if($row->status == 1){
                                  $btn = "Enabled";
                                  $cls = "btn-primary";
                                }else{
                                  $btn = "Disabled";
                                  $cls = "btn-danger";
                                }
                              ?>
                            <a href="<?php echo base_url(); ?>add_folder/change_status/<?php echo $row->client_id; ?>" type="submit" class="btn btn-small <?php echo $cls; ?>" name="">
                            <?php echo $btn; ?>
                            </a>
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
      

      $("#c_client").change(function() {
          var id = $("#c_client").val();
          $('input[type=checkbox]').prop('checked', false);
          $.ajax({
            url: "<?php echo base_url("Add_folder/get_checked_folder"); ?>",
            method: "POST",
            data: {id:id},
            success:function(data){
              var src = data;
              var obj = JSON.parse(data);
              var shop = obj.shop_id.split(',');
              for(var i=0; i<shop.length; i++){
                $("#"+shop[i]).prop('checked', true);
              }
            }
          });
      });

  });

</script>