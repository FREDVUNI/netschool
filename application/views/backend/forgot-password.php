<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netschool | Forgot Password</title>
    <link rel="shortcut icon" href="<?php echo base_url("assets/backend/images/favicon.png");?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/plugins/fontawesome-free/css/all.min.css");?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/dist/css/adminlte.min.css");?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/dist/css/style.css");?>">
</head>
<body>
<div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-12 col-md-9">
          <div class="card o-hidden border-0 shadow-lg my-5 col-md-10 ml-5">
              <div class="card-body p-0">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="p-4">
                      <div class="text-center">
                        <span class="mb-0"><img src="<?php echo base_url("assets/backend/images/login.png");?>" alt="logo" width="100px" height="100px" class="mb-3 rounded-circle"></span>
                        <h1 class="h5 text-dark-500 font-weight-bold mb-3">RECOVER PASSWORD</h1>
                      </div>
                      <p>
                        Enter your registered Email address below and we will send you instructions on
                        how to recover and reset your password.
                      </p>
                      <?php echo $this->session->flashdata('message');?>
                      <form class="user" id="validate" action="<?php echo base_url('admin/forgot-password');?>" method="post" novalidate="novalidate">
                        <div class="form-group">
                          <input type="email" class="form-control form-control-user  <?php if(form_error('email')): echo "is-invalid"; endif;?>" id="email" name="email" placeholder="Enter Email Address" value="<?php echo set_value('email');?>" autofocus>
                          <span class="is-invalid"><?php echo form_error('email');?></span>
                        </div>
                        <button type="submit" class="btn btn-info btn-user btn-block">
                          RECOVER PASSWORD
                        </button>
                      </form>
                      <hr>
                      <div class="text-center">
                        <a id="torecover" href="<?php echo base_url("admin/login");?>">Back to login</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.min.js");?>"></script>
    <script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.validate.min.js");?>"></script>
    <script src="<?php echo base_url("assets/backend/plugins/jquery/additional-methods.min.js");?>"></script>
    <script src="<?php echo base_url("assets/backend/plugins/jquery/scripts.js");?>"></script>
</body>
</html>