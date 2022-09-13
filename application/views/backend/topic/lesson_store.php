<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Create Lesson (Topic: <?=$theTopic['topic'];?>)</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=site_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?=site_url('admin/topics'); ?>">Topics</a></li>
              <li class="breadcrumb-item">
                <a href="<?=site_url('admin/'.$theTopic['slug'].'/topic/lessons'); ?>">Lessons</a>
              </li>
              <li class="breadcrumb-item active">create lesson</li>
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
                New lesson
              </div>
              <div class="card-body">
              <form
                id="createlesson"
                action="<?=site_url('admin/'.$theTopic['slug'].'/topic/lesson/store'); ?>"
                method="POST" novalidate="novalidate"
                enctype="multipart/form-data">
                <div class="col-md-12">
                      <div class="form-group ">
                        <label for="term">Term <span class="text-danger">*</span> </label>
                        <select name="term" id="term" class="form-control">
                            <option value="">choose a term</option>
                            <?php foreach($terms as $term): ?>
                                <option value="<?php  echo $term['term_id'];?>" <?php echo set_select("term",$term['term_id'],(!empty($term_list) && $term_list==$term['term_id'] ? TRUE:FALSE));?>>
                                    <?php echo $term['term']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo form_error('term');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="subtopic">Sub Topic <span class="text-danger">*</span> </label>
                        <input type="text" name="subtopic" id="subtopic" class="form-control <?php if(form_error('subtopic')): echo "is-invalid"; endif;?>" placeholder="Enter subtopic name" value="<?php echo set_value('subtopic');?>" autofocus="autofocus" required>
                        <span class="invalid-feedback"><?php echo form_error('subtopic');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="videotitle">Video Title <span class="text-danger">*</span> </label>
                        <input type="text" name="videotitle" id="videotitle" class="form-control <?php if(form_error('videotitle')): echo "is-invalid"; endif;?>" placeholder="Enter video title" value="<?php echo set_value('videotitle');?>" autofocus="autofocus" required>
                        <span class="invalid-feedback"><?php echo form_error('videotitle');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="video">Video URL <span class="text-danger">*</span> </label>
                        <input type="text" name="video" id="video" class="form-control <?php if(form_error('video')): echo "is-invalid"; endif;?>" placeholder="Enter video url" value="<?php echo set_value('video');?>" required>
                        <span class="invalid-feedback"><?php echo form_error('video');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="teacher">Teacher <span class="text-danger">*</span> </label>
                        <select name="teacher" id="teacher" class="form-control">
                            <option value="">choose an instructor</option>
                            <?php foreach($teachers as $teacher): ?>
                                <option value="<?php  echo $teacher['teacher_id'];?>" <?php echo set_select("teacher",$teacher['teacher_id'],(!empty($teacher_list) && $teacher_list==$teacher['teacher_id'] ? TRUE:FALSE));?>>
                                    <?php echo $teacher['firstname']." ".$teacher['lastname']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo form_error('teacher');?></span>
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
                        <!--div class="col-md-3">
                        <div class="form-group">
                        <label for="video">Video <span class="text-danger">*</span> </label>
                            <div class="d-flex flex-row">
                                <video src="<?php //echo base_url('assets/backend/videos/uploads/lessons/dubai.mp4');?>" id="preview" class="img-thumbnail image" preload width="100%" height="100%" controls></video>
                            </div>
                            <div class="row ml-1">
                                <input style="display:none;" type="file" name="video" id="vid" accept=".mp4,.mkv,.flv,.avi">
                                <a href="javascript:uploadV()">upload</a> 
                                <a class="text-danger ml-1" href="javascript:DeleteV()">remove</a>
                            </div>
                            <span class="invalid-feedback videoerror"></span>
                        </div>
                        </div-->
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
    $('#createlesson').validate({
        rules: {
        topic: {
            required: true,
        },
        subject: {
            required: true,
        },
        level: {
            required: true,
        },
        term: {
            required: true,
        },
        subtopic: {
            required: true,
        },
        videotitle: {
            required: true,
        },
        teacher: {
            required: true,
        },
        image: {
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
            subject: {
            required: "Please enter a subject name",
        },
            topic: {
                required: "Please choose a topic",
        },
            level: {
                required: "Please choose a level",
            },
            term: {
                required: "Please choose a term",
            },
            subtopic: {
                required: "Please enter sub topic",
            },
            videotitle: {
                required: "Please enter video title",
            },
            teacher: {
                required: "Please choose an instructor",
            },
            image: {
                required: "Please choose a thumbnail",
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
        $('#thumbImage').attr('src', '<?php echo base_url('assets/backend/images/uploads/lessons/noimage.png');?>');
        $('#imageerror').text('')
    }
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
        $('#preview').attr('src', '<?php echo base_url('assets/backend/videos/uploads/lessons/dubai.mp4');?>');
        $('#videoerror').text('')
    }
</script>
