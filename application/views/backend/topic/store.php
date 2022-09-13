<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Create topic</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">create topic</li>
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
                New topic
              </div>
              <div class="card-body">
              <form id="createtopic" action="<?php echo base_url('admin/topic/store'); ?>" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="form-group ">
                        <label for="topic">Topic <span class="text-danger">*</span> </label>
                        <input type="text" name="topic" id="topic" class="form-control <?php if(form_error('topic')): echo "is-invalid"; endif;?>" placeholder="Enter topic name" value="<?php echo set_value('topic');?>" autofocus="autofocus" required>
                        <span class="invalid-feedback"><?php echo form_error('topic');?></span>
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
                    <div class="form-group ">
                        <label for="subject">Subject <span class="text-danger">*</span> </label>
                        <select name="subject" id="subject" class="form-control">
                            <option value="">choose a subject</option>
                            <?php foreach($subjects as $subject): ?>
                                <option value="<?php  echo $subject['subject_id'];?>" <?php echo set_select("subject",$subject['subject_id'],(!empty($subject_list) && $subject_list==$subject['subject_id'] ? TRUE:FALSE));?>>
                                    <?php echo $subject['subject'] ." - ".  $subject['level']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo form_error('subject');?></span>
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
    $('#createtopic').validate({
        rules: {
        topic: {
            required: true,
        },
        level: {
            required: true,
        },
        subject: {
            required: true,
        },
        },
        messages: {
            topic: {
            required: "Please enter a topic name",
        },
            level: {
            required: "Please choose a level for the topic",
        },
            subject: {
                required: "Please choose a subject for the topic",
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