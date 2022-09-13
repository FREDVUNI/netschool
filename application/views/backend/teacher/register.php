<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Register a team member</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Register a team member</li>
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
                New Team Member
              </div>
              <div class="card-body">
              <form id="registerteacher" action="<?php echo base_url('admin/teacher/create'); ?>" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="form-group ">
                        <label for="firstname">First name <span class="text-danger">*</span> </label>
                        <input type="text" name="firstname" id="firstname" class="form-control <?php if(form_error('firstname')): echo "is-invalid"; endif;?>" placeholder="Enter First name" value="<?php echo set_value('firstname');?>" autofocus="autofocus" required pattern="^[A-Za-z0-9_- ]$">
                        <span class="invalid-feedback"><?php echo form_error('firstname');?></span>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last name <span class="text-danger">*</span> </label>
                        <input type="text" name="lastname" id="lastname" class="form-control <?php if(form_error('lastname')): echo "is-invalid"; endif;?>" placeholder="Enter Last name" value="<?php echo set_value('lastname');?>" required pattern="^[A-Za-z0-9_- ]$">
                        <span class="invalid-feedback"><?php echo form_error('lastname');?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address <span class="text-danger">*</span> </label>
                        <input type="email" name="email" id="email" class="form-control <?php if(form_error('email')): echo "is-invalid"; endif;?>" placeholder="Email address" value="<?php echo set_value('email');?>" required>
                        <span class="invalid-feedback"><?php echo form_error('email');?></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number <span class="text-danger">*</span> </label>
                        <input type="text" name="phone" id="phone" class="form-control <?php if(form_error('phone')): echo "is-invalid"; endif;?>" placeholder="Enter phone number" value="<?php echo set_value('phone');?>" required pattern="^(?:256|\+256|0)?(7(?:(?:[0127589][0-9])|(?:0[0-8])|(4[0-1]))[0-9]{6})$">
                        <span class="invalid-feedback"><?php echo form_error('phone');?></span>
                    </div>
                    <div class="form-group">
                        <label for="subjects">Role <span class="text-danger">*</span> </label>
                        <input type="text" name="subjects" id="subjects" class="form-control <?php if(form_error('subjects')): echo "is-invalid"; endif;?>" placeholder="Enter member role" value="<?php echo set_value('subjects');?>" required>
                        <span class="invalid-feedback"><?php echo form_error('subjects');?></span>
                    </div>
                    <div class="form-group">
                        <label for="school">School name <span class="text-danger">*</span> </label>
                        <input type="text" name="school" id="school" class="form-control <?php if(form_error('school')): echo "is-invalid"; endif;?>" placeholder="Enter school name" value="<?php echo set_value('school');?>">
                        <span class="invalid-feedback"><?php echo form_error('school');?></span>
                    </div>
                    <div class="form-group">
                        <label for="about">About Team Member <span class="text-danger">*</span> </label>
                        <textarea name="about" id="about" class="form-control <?php if(form_error('about')): echo "is-invalid"; endif;?>" rows="5" placeholder="Enter some information about the team member"><?php echo set_value('about');?></textarea>
                        <span class="invalid-feedback"><?php echo form_error('about');?></span>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                        <label for="image">Profile picture <span class="text-danger">*</span> </label>
                            <div class="d-flex flex-row">
                                <img src="<?php echo base_url('assets/backend/images/uploads/teachers/noimage.png');?>" alt="user" class=""  id="profileImage"  width="120" height="120">
                                <input type="file" id="image" name="image" style="display: none;" accept=".png,.jpg,.jpeg" required/>
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
    $('#registerteacher').validate({
        rules: {
        firstname: {
            required: true,
        },
        lastname: {
            required: true,
        },
        phone: {
            required: true,
            minlength: 10
        },
        email: {
            required: true,
            email: true
        },
        subjects: {
            required: true,
        },
        about: {
            required: true,
        },
        },
        messages: {
            email: {
            required: "Please enter an email address",
            email: "Please enter a vaild email address"
        },
        phone: {
            required: "Please provide the teacher's phone number",
            minlength: "The teacher's phone number must be at least 10 digits long"
        },
        firstname: {
            required: "Please provide the teacher's first name",
        },
        lastname: {
            required: "Please provide the teacher's last name",
        },
        school: {
            required: "Please provide the teacher's school",
        },
        subjects: {
            required: "Please provide the subjects taught",
        },
        about: {
            required: "Please provide some information about the teacher",
        },
        image: {
            required: "Please upload the teacher's profile picture",
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
            $('#profileImage').attr('src', e.target.result);
            $('#imageerror').text('')
            };
        }
    }
    function DeleteImage() {
        $('#profileImage').attr('src', '<?php echo base_url('assets/backend/images/uploads/teachers/noimage.png');?>');
        $('#imageerror').text('')
    }
</script>