<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Profile</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
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
                Settings
              </div>
              <div class="card-body">
              <?php echo form_open_multipart('admin/profile');?>
                    <div class="row user">
                        <div class="col-md-4 grid-margin stretch-card">
                            <div class="d-flex flex-row">
                            <img src="<?php echo base_url('assets/backend/images/uploads/admins/').$user['image'];?>" alt="user" class=""  id="profileImage"  width="300" height="300">
                                <input type="file" id="image" name="image" style="display: none;"/>
                            </div>
                        <div class="col-md-12 text-center">
                            <input type="hidden" name="id" value="1">
                            <label for="image" class="mt-3 mr-4">
                                <a href="javascript:updateImage()" class="text-primary">
                                    <i class="fas fa-camera"></i>
                                    <span class="align-middle">CHANGE PHOTO</span>
                                </a>
                            </label>
                        </div>
                        <span class="text-danger ml-4" id="imageerror"></span>
                    </div>
                    <div class="col-md-8 grid-margin stretch-card">
                        <div class="form-group">
                            <label>Email Address <span class="text-danger">*</span> </label>
                            <input type="email" class="form-control <?php if(form_error('email')): echo "is-invalid"; endif;?>" name="email" id="email" placeholder="Email Address" value="<?php echo $user['email'];?>" readonly>
                            <span class="text-danger"><?php echo form_error('email');?></span>  
                        </div>
                        <div class="form-group">
                            <label>username <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control <?php if(form_error('username')): echo "is-invalid"; endif;?>" name="username" id="username" placeholder="Username" value="<?php echo $user['username'] ?? set_value('username');?>">
                            <span class="text-danger"><?php echo form_error('username');?></span>
                        </div>
                        <div class="form-group">
                            <label>Role <span class="text-danger">*</span> </label>
                            <select name="role_id" id="roleid" class="form-control input-user-roleid <?php if(form_error('role_id')): echo "is-invalid"; endif;?>">
                                <option value="<?php echo $user['role_id'] ?? set_value('role_id');?>">
                                    <?php
                                        if($user['role_id'] == 1):
                                            echo "Administrator";
                                        elseif($user['role_id'] == 2):
                                            echo "member";
                                        else:
                                            echo "Choose type";
                                        endif;
                                    ?> 
                                </option>
                                <option value="1">Administrator</option>
                                <option value="2">member</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Save changes</button>
                        </div>
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
    $('.custom-file-input').on('change', function() { 
        let fileName = $(this).val().split('\\').pop(); 
        $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });

    function updateImage(){
        $('#image').click();
        $('#imageerror').text('')
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
</script>