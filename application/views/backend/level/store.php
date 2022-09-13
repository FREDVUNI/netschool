<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Create level</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">create level</li>
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
                New level
              </div>
              <div class="card-body">
              <form id="createlevel" action="<?php echo base_url('admin/level/store'); ?>" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="form-group ">
                        <label for="level">Level <span class="text-danger">*</span> </label>
                        <input type="text" name="level" id="level" class="form-control <?php if(form_error('level')): echo "is-invalid"; endif;?>" placeholder="Enter Level name" value="<?php echo set_value('level');?>" autofocus="autofocus" required pattern="^[A-Za-z0-9_- ]$">
                        <span class="invalid-feedback"><?php echo form_error('level');?></span>
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
    $('#createlevel').validate({
        rules: {
        level: {
            required: true,
        },
        },
        messages: {
            level: {
            required: "Please enter a level name",
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