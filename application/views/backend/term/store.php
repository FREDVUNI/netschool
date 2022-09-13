<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Create term</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">create term</li>
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
                New term
              </div>
              <div class="card-body">
              <form id="createterm" action="<?php echo base_url('admin/term/store'); ?>" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="form-group ">
                        <label for="term">Term <span class="text-danger">*</span> </label>
                        <input type="text" name="term" id="term" class="form-control <?php if(form_error('term')): echo "is-invalid"; endif;?>" placeholder="Enter term name" value="<?php echo set_value('term');?>" autofocus="autofocus" required>
                        <span class="invalid-feedback"><?php echo form_error('term');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="level">Level <span class="text-danger">*</span> </label>
                        <select name="level" id="level" class="form-control">
                            <option value="">choose a level</option>
                            <?php foreach($levels as $level): ?>
                                <option value="<?php  echo $level['level_id'];?>" <?php echo set_select("level",$level['level_id'],(!empty($level_list) && $level_list==$level['level_id'] ? TRUE:FALSE));?>>
                                    <?php echo $level['level']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
    $('#createterm').validate({
        rules: {
        term: {
            required: true,
        },
        level: {
            required: true,
        },
        },
        messages: {
            term: {
            required: "Please enter a term",
        },
        term: {
            required: "Please enter a level",
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