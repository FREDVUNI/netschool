<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Edit sample video</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Edit sample video</li>
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
                Edit <?php echo $samplevideo["title"]; ?>
              </div>
              <div class="card-body">
              <form id="editsamplevideo" action="<?php echo base_url('/admin/'.$samplevideo['slug'].'/samplevideo'); ?>" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="form-group ">
                        <input type="hidden" name="samplevideo_id" value="<?php echo $samplevideo['samplevideo_id']; ?>">
                        <label for="title">Title <span class="text-danger">*</span> </label>
                        <input type="text" id="title" name="title" class="form-control" required value="<?php echo $samplevideo['title'] ?? set_value('title');?>">
                        <span class="invalid-feedback"><?php echo form_error('title');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="video">Video URL <span class="text-danger">*</span> </label>
                        <input type="text" id="video" name="video" class="form-control" required value="<?php echo $samplevideo['video'] ?? set_value('video');?>">
                        <span class="invalid-feedback"><?php echo form_error('video');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="subject">Subject <span class="text-danger">*</span> </label>
                        <select name="subject" id="subject" class="form-control">
                            <option value="<?php echo $samplevideo['subject_id'] ?? set_value('subject_id');?>"><?php echo $samplevideo['subject'] ?? set_value('subject');?></option>
                            <?php foreach($subjects as $subject): ?>
                                <option value="<?php  echo $subject['subject_id'];?>" <?php echo set_select("subject",$subject['subject_id'],(!empty($subject_list) && $subject_list==$subject['subject_id'] ? TRUE:FALSE));?>>
                                    <?php echo $subject['subject']."-".$subject['level']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo form_error('subject');?></span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                        <div class="form-group">
                        <label for="video">Video <span class="text-danger">*</span> </label>
                            <div class="d-flex flex-row">
                                <iframe src="<?php echo $samplevideo['video'];?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe>
                            </div>
                            <span class="invalid-feedback videoerror"></span>
                        </div>
                        </div>
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
    $('#editsamplevideo').validate({
        rules: {
        title: {
            required: true,
        },
        subject: {
            required: true,
        },
        vid: {
            required: true,
        },
        video: {
            required: true,
        },
        },
        messages: {
            title: {
            required: "Please enter a title",
        },
            subject: {
                required: "Please choose a subject",
        },
            vid: {
                required: "Please choose a video",
            },
            video: {
                required: "Please enter a video url",
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
<script>
    function uploadV(){
        $('#vid').click();
    }
    $(function(){

        $('#vid').change(function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = viewer.load;
            reader.readAsDataURL(file);
            //viewer.setProperties(file); 
        }); 
        var viewer ={
            load:function(e){
                $("#preview").attr("src",e.target.result);
            }
        }
    });
    function DeleteV() {
        $('#preview').attr('src', '<?php echo base_url('assets/backend/videos/uploads/samplevideos/dubai.mp4');?>');
        $('#videoerror').text('')
    }
</script>