<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Register</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Register</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <div class="col-md-12">
        <?php echo $this->session->flashdata('message');?>
            <div class="card">
            <div class="card-header">
                New user
              </div>
              <div class="card-body">
              <form id="registeruser" action="<?php echo base_url('admin/register'); ?>" method="POST" novalidate="novalidate">
                <div class="col-md-12 ">
                    <div class="form-group">
                        <label for="username">Username <span class="text-danger">*</span> </label>
                        <input type="text" name="username" id="username" class="form-control <?php if(form_error('username')): echo "is-invalid"; endif;?>" placeholder="Enter Username" value="<?php echo set_value('username');?>" autofocus="autofocus" required pattern="^[A-Za-z0-9_]{1,15}$">
                        <span class="invalid-feedback"><?php echo form_error('username');?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address <span class="text-danger">*</span> </label>
                        <input type="email" name="email" id="email" class="form-control <?php if(form_error('email')): echo "is-invalid"; endif;?>" placeholder="Email address" value="<?php echo set_value('email');?>" required>
                        <span class="invalid-feedback"><?php echo form_error('email');?></span>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Administrator Role <span class="text-danger">*</span> </label>
                        <select name="role_id" id="role_id" class="form-control input-user-roleid <?php if(form_error('role_id')): echo "is-invalid"; endif;?>" required>
                            <option value="">Choose Administrator Type</option>
                            <option value="1" <?php echo set_select("role_id",1,(!empty($list) && $list==1 ? TRUE:FALSE));?>>
                                Administrator
                            </option>
                            <option value="2" <?php echo set_select("role_id",2,(!empty($list) && $list==2 ? TRUE:FALSE));?>>
                                member
                            </option>
                        </select>
                        <span class="invalid-feedback"><?php echo form_error('role_id');?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span> </label>
                        <input type="password" name="password" id="password" class="form-control <?php if(form_error('password')): echo "is-invalid"; endif;?>" placeholder="Enter Password" value="<?php echo set_value('password');?>" required minlength="8">
                        <span class="invalid-feedback"><?php echo form_error('password');?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm">Confirm Password <span class="text-danger">*</span> </label>
                        <input type="password" name="confirm" id="confirm" class="form-control <?php if(form_error('confirm')): echo "is-invalid"; endif;?>" placeholder="Confirm password" required>
                        <span class="invalid-feedback"><?php echo form_error('confirm');?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-flat col-md-2">Save changes</button>
                    </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.validate.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/jquery/additional-methods.min.js");?>"></script>
<script>
$(document).ready(function(){
    $('#registeruser').validate({
        rules: {
        username: {
            required: true,
        },
        role_id: {
            required: true,
        },
        password: {
            required: true,
            minlength: 8
        },
        email: {
            required: true,
            email: true
        },
        confirm: {
            required: true,
            equalTo: "#password"
        },
        },
        messages: {
            email: {
            required: "Please enter an email address",
            email: "Please enter a vaild email address"
        },
        password: {
            required: "Please provide your  password",
            minlength: "Your password must be at least 8 characters long"
        },
        confirm: {
            required: "Please confirm your password",
            equalTo: "The passwords didnot match"
        },
        username: {
            required: "Please provide a username",
        },
        role_id: {
            required: "Please choose admin role",
        },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    });
});
</script>