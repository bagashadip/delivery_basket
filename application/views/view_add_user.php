<?php
  $no = 0;
  foreach ($last_id as $row) {
      $no = $row->user_id;
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
      $attributes = array('class' => 'cmxform form-horizontal tasi-form');
      echo form_open_multipart(site_url("Add_user/add_data_user"), $attributes);
    ?>
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
                    <b>Add User</b>
                    <span class="tools pull-right">
                      <a href="javascript:;" class="fa fa-chevron-down"></a>
                    </span>
                </header>
                <div class="panel-body">
                    <div class=" form">
                      <div class="form-group ">
                          <label for="cname" class="control-label col-lg-2">User Id</label>
                          <div class="col-lg-1">
                              <input class=" form-control" id="user_id" name="user_id" type="text" value="<?php echo $id; ?>" readonly required />
                          </div>
                      </div>
                      <div class="form-group ">
                          <label for="cname" class="control-label col-lg-2">Full Name</label>
                          <div class="col-lg-3">
                              <input class=" form-control" id="full_name" name="full_name" type="text" required />
                          </div>
                      </div>
                      <div class="form-group ">
                          <label for="cname" class="control-label col-lg-2">Username</label>
                          <div class="col-lg-3">
                              <input class="form-control" id="username" name="username" type="text" placeholder="username" required />
                          </div>
                      </div>
                      <div class="form-group ">
                          <label for="cname" class="control-label col-lg-2">Password</label>
                          <div class="col-lg-3">
                              <input class=" form-control ph" id="password" name="password" type="password" />
                          </div>
                      </div>
                      <div class="form-group ">
                          <label for="cname" class="control-label col-lg-2">Level</label>
                          <div class="col-lg-3">
                              <select class="form-control" name="level" id="level">
                                <option value="2">User</option>
                                <option value="1">Admin</option>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                        <label for="cname" class="control-label col-lg-2">Assigned Folders</label>
                        <div class="col-lg-4">
                            <?php
                              foreach ($clients as $row) {
                                ?>
                                  <div class="form-check">
                                    <label class="form-check-label">
                                        <input name="clients[]" id="<?php echo $row->client_id; ?>" value="<?php echo $row->client_id; ?>" type="checkbox" /> <?php echo $row->client_name; ?>
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
                              <input class="btn btn-warning" type="submit" id="btn_update" name="update" value="Update" disabled="disabled" />
                              <input type="reset" class="btn btn-primary" id="btn_cancel" value="Cancel" />
                          </div>
                      </div>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      foreach ($users as $row) {
                        ?>
                          <tr>
                            <td><?php echo $row->user_id; ?></td>
                            <td><?php echo $row->user_full_name; ?></td>
                            <td><?php echo $row->user_email; ?></td>
                            <td><?php echo $row->user_lvl; ?></td>
                            <td>
                              <a href="#" class="btn btn-primary btn-xs" onClick="get_user('<?php echo $row->user_id; ?>')"><i class="fa fa-pencil"></i></a>
                              <a href="javascript:if(confirm('Are you sure want to delete this?')){document.location='<?php echo base_url("add_user/delete_user/$row->user_id") ?>';}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
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
    <?php echo form_close(); ?>
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

  function get_user(id){
      $('input[type=checkbox]').prop('checked', false);
      $.ajax({
        url: "<?php echo base_url("Add_user/get_user"); ?>",
        method: "POST",
        data: {id:id},
        success:function(data){
          var src = data;
          var obj = JSON.parse(data);
          var client = obj.assigned_folders.split(',');
          $("#user_id").val(obj.user_id);
          $("#full_name").val(obj.user_full_name);
          $("#username").val(obj.user_email);
          $("#level").val(obj.user_lvl);
          for(var i=0; i<client.length; i++){
            $("#"+client[i]).prop('checked', true);
          }
          $("#btn_update").removeAttr("disabled");
          $("#btn_save").attr("disabled",true);
          $("#btn_cancel").attr("disabled",true);
          $("#password").attr("placeholder", "empty this field if you do not want to change it");
        }
      });
  }

  // function get_user(id,name,email,lvl){
  //     $("#user_id").val(id);
  //     $("#full_name").val(name);
  //     $("#email").val(email);
  //     $("#lvl").val(lvl);
  //     $("#btn_update").removeAttr("disabled");
  //     $("#btn_save").attr("disabled",true);
  //     $("#btn_cancel").attr("disabled",true); 
  // }
</script>