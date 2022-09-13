<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Create subject</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">create subject</li>
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
                New subject
              </div>
              <div class="card-body">
              <form id="createsubject" action="<?php echo base_url('admin/subject/store'); ?>" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="form-group ">
                        <label for="subject">Subject <span class="text-danger">*</span> </label>
                        <input type="text" name="subject" id="subject" class="form-control <?php if(form_error('subject')): echo "is-invalid"; endif;?>" placeholder="Enter subject name" value="<?php echo set_value('subject');?>" autofocus="autofocus" required pattern="^[A-Za-z0-9_- ]$">
                        <span class="invalid-feedback"><?php echo form_error('subject');?></span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                        <div class="form-group">
                        <label for="image">Thumbnail <span class="text-danger">*</span> </label>
                            <div class="d-flex flex-row">
                                <img src="<?php echo base_url('assets/backend/images/uploads/lessons/noimage.png');?>" alt="lesson" class=""  id="thumbImage" width="140" height="140">
                                <input type="file" id="image" name="image" style="display: none;" accept="image/*" required/>
                            </div>
                            <div class="row ml-1">
                                <a href="javascript:uploadImage()">upload</a> 
                                <a class="text-danger ml-1" href="javascript:DeleteImage()">remove</a>
                            </div>
                            <span class="invalid-feedback imageerror"></span>
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
    $('#createsubject').validate({
        rules: {
        subject: {
            required: true,
        },
        level: {
            required: true,
        },
        image: {
            required: true,
        },
        },
        messages: {
            subject: {
            required: "Please enter a subject name",
        },
            level: {
                required: "Please enter a class",
        },
            image: {
                required: "Please choose a thumbnail",
        },
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
function uploadImage(){
    $('#image').click();
}                     
$('#image').change(function () {
    var imgLivePath = this.value;
    var img_extions = imgLivePath.substring(imgLivePath.lastIndexOf('.') + 1).toLowerCase();
    if (img_extions == "gif" || img_extions == "png" || img_extions == "jpg" || img_extions == "jpeg")
        readURL(this);
    else
        $('#imageerror').text('Please select a valid image file.')
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.onload = function (e) {
            $('#thumbImage').attr('src', e.target.result);
            $('#imageerror').text('')
            };
        }
    }
    function DeleteImage() {
        $('#thumbImage').attr('src', '<?php echo base_url('assets/backend/images/uploads/subjects/noimage.png');?>');
        $('#imageerror').text('')
    }
</script>