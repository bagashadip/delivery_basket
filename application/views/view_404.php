<!DOCTYPE html>
<html>
<head>
  <title>404 - Page Not Found</title>
  <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/not_found404.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>Oops!</h1>
                <h2>404 Not Found</h2>
                <div class="error-details">
                    Sorry, an error has occured, Requested page not found!
                </div>
                <div class="error-actions">
                    <a href="<?php echo base_url(); ?>login" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>Take Me Home </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>