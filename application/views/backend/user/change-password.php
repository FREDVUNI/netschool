<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Change Password</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container">
        <div class="col-md-12">
        <?php echo $this->session->flashdata('message');?>
            <div class="card">
              <div class="card-body">
              <form id="changepassword" action="<?php echo base_url('admin/change-password'); ?>" method="POST">
                <div class="form-group">
                    <label for="current">Current password<span class="text-danger">*</span></label>
                    <input type="password" class="form-control <?php if(form_error('current')): echo "is-invalid"; endif;?>" name="current" placeholder="Enter current password" value="" autofocus>
                    <span class="error invalid-feedback"><?php echo form_error('current'); ?></span>
                </div>
                <div class="form-group">
                      <label for="new">New password<span class="text-danger">*</span></label>
                      <input type="password" class="form-control <?php if(form_error('new')): echo "is-invalid"; endif;?>" name="new" id="new" placeholder="Enter new password" value="">
                      <span class="error invalid-feedback"><?php echo form_error('new'); ?></span>
                </div>
                <div class="form-group">
                      <label for="confirm">Confirm password<span class="text-danger">*</span></label>
                      <input type="password" class="form-control <?php if(form_error('confirm')): echo "is-invalid"; endif;?>" name="confirm" id="confirm" placeholder="Confirm new Password" value="">
                      <span class="error invalid-feedback"><?php echo form_error('confirm'); ?></span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary btn-flat col-md-2">Save changes</button>
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
    $('#changepassword').validate({
        rules: {
        new: {
            required: true,
            minlength: 8
        },
        password: {
            required: true,
        },
        current: {
            required: true
        },
        confirm: {
            required: true,
            equalTo: "#new"
        },
        },
        messages: {
        new: {
            required: "Please provide your new password",
            minlength: "Your password must be at least 8 characters long"
        },
        password: {
            required: "Please provide your  password",
        },
        confirm: {
            required: "Please confirm your new password",
            equalTo: "The passwords didnot match"
        },
        current: {
            required: "Please provide your current password",
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