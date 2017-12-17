<?php echo doctype("html5") ?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/title_icon.png">

    <title>Delivery Basket</title>

    <style type="text/css">
   input {font-weight:bold;}
</style>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap-daterangepicker/daterangepicker.css" />


    <link href="<?php echo base_url(); ?>assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/owl.carousel.css" type="text/css">

      <!--right slidebar-->
      <link href="<?php echo base_url(); ?>css/slidebars.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <!-- <link href="<?php echo base_url(); ?>css/demo_dt.css" rel="stylesheet" /> -->
    <link href="<?php echo base_url(); ?>css/style_dt.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style-responsive.css" rel="stylesheet" />
    <!-- <link href="<?php echo base_url(); ?>css/stylesheet.css" rel="stylesheet" /> -->
    
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.min.js"></script> -->
    <style>
      .ph {
          
      }

      .ph,
      .ph::-webkit-input-placeholder {
          font-size: 11px;
          line-height: 3;
      }
    </style>
   
    <script src="<?php echo base_url(); ?>js/jquery-1.12.4.js"></script>
    <script src="<?php echo base_url(); ?>js/datatables.js"></script>
    <script src="<?php echo base_url(); ?>assets/jquery-base64-master/jquery.base64.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>dist/js/standalone/selectize.js"></script>
    
  </head>

  <body>

  <section id="container" class="">
      <!--header start-->
      <header class="header white-bg">
          <div class="sidebar-toggle-box">
              <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
          </div>
          <!--logo start-->
          <a href="index.html" class="logo" ><span>Delivery</span>Basket</a>
          <!--logo end-->
          <div class="nav notify-row" id="top_menu">
            <!--  notification start -->
            <ul class="nav top-menu">
              
              <!-- inbox dropdown end -->
              
          </ul>
          </div>
          <div class="top-nav ">
              <ul class="nav pull-right top-menu">
                  <li>
                      <input type="text" class="form-control search" placeholder="Search">
                  </li>
                  <!-- user login dropdown start-->
                  <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <img alt="" src="img/avatar_login.png" width="30px">
                          <span class="username">
                            
                          </span>
                          <b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu extended logout">
                          <div class="log-arrow-up"></div>
                          <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                          <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                          <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                          <li><a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-key"></i> Log Out</a></li>
                      </ul>
                  </li>
                  <!-- user login dropdown end -->
                  <!-- <li class="sb-toggle-right"> -->
                      <!-- <i class="fa  fa-align-right"></i> -->
                  <!-- </li> -->
              </ul>
          </div>
      </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                  <?php
                    $level = $this->session->userdata("level");
                    if($level == 1){
                      ?>
                        <li>
                            <a href="<?php echo base_url(); ?>add_user">
                                <i class="fa fa-user"></i>
                                <span>Add User</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>add_client">
                                <i class="fa fa-sitemap"></i>
                                <span>Add Client</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>add_shop">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Add Shop</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>add_plugin">
                                <i class="fa fa-tasks"></i>
                                <span>Add Plugin</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>add_folder">
                                <i class="fa fa-book"></i>
                                <span>Add Client Folder</span>
                            </a>
                        </li>
                      <?php
                    }
                  ?>
                  
                  <?php
                    $y=0;
                    foreach ($folders as $data_folder) {
                        if($data_folder->status == 1){
                          foreach ($user_login as $data_user) {
                            $arr_client = explode(",", $data_user->assigned_folders);
                            array_push($arr_client, "t");
                            if($arr_client[$y] == $data_folder->client_id){
                              ?>
                                <li class="sub-menu">
                                    <a href="" >
                                        <span><?php echo $data_folder->client_name; ?></span>
                                    </a>
                                    <ul class="sub">
                                      <?php
                                        $i = 0;
                                        $arr_shop = explode(",", $data_folder->shop_id);
                                        array_push($arr_shop,"t");
                                        foreach ($shops as $data_shop) {
                                          if($arr_shop[$i] == $data_shop->shop_id){
                                            ?>
                                              <li class="sub-menu">
                                                <a  href="boxed_page.html"><?php echo $data_shop->shop_name; ?></a>
                                                <ul class="sub">
                                                    <?php
                                                      $x=0;
                                                      foreach ($plugins as $data_plugins) {
                                                        if($data_folder->client_id == $data_plugins->client_id && $data_shop->shop_id == $data_plugins->shop_id){
                                                          ?>
                                                            <li>
                                                              <a href="<?php echo base_url(); ?>add_plugin/download_plugin/<?php echo $data_plugins->plugin_id; ?>"><small><?php echo $data_plugins->plugin_name; ?></small>
                                                              </a>
                                                            </li>
                                                          <?php
                                                        }
                                                      }
                                                    ?>
                                                </ul>
                                              </li>
                                            <?php
                                            $i++;
                                          }
                                        }
                                      ?>
                                    </ul>
                                </li>
                              <?php
                              $y++;
                            }
                          }
                          
                        }
                    }
                  ?>
                  <!-- <li class="sub-menu">
                      <a href="javascript:;" >
                          <span>Cardprocess</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="javascript:;">Menu Item 1</a></li>
                          <li class="sub-menu">
                              <a  href="boxed_page.html">Menu Item 2</a>
                              <ul class="sub">
                                  <li><a  href="javascript:;">Menu Item 2.1</a></li>
                              </ul>
                          </li>
                      </ul>
                  </li> -->


              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->