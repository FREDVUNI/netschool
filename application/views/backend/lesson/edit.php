<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Edit Lesson</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Edit lesson</li>
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
                Edit <?php echo $lesson["topic"]; ?>
              </div>
              <div class="card-body">
              <form id="editlesson" action="<?php echo base_url('/admin/'.$lesson['slug'].'/lesson'); ?>" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="form-group ">
                        <label for="level">Class <span class="text-danger">*</span> </label>
                        <select name="level" id="level" class="form-control"  autofocus="autofocus">
                        <option value="<?php echo $lesson['level_id'] ?? set_value('level_id');?>" autofocus><?php echo $lesson['level'] ?? set_value('level');?></option>
                            <?php foreach($levels as $level): ?>
                                <option value="<?php  echo $level['level_id'];?>" <?php echo set_select("level",$level['level_id'],(!empty($level_list) && $level_list==$level['level_id'] ? TRUE:FALSE));?>>
                                    <?php echo $level['level']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo form_error('level');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="term">Term <span class="text-danger">*</span> </label>
                        <select name="term" id="term" class="form-control">
                            <option value="<?php echo $lesson['term_id'] ?? set_value('term_id');?>"><?php echo $lesson['term'] ?? set_value('term');?></option>
                            <?php foreach($terms as $term): ?>
                                <option value="<?php  echo $term['term_id'];?>" <?php echo set_select("term",$term['term_id'],(!empty($term_list) && $term_list==$term['term_id'] ? TRUE:FALSE));?>>
                                    <?php echo $term['term']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo form_error('term');?></span>
                    </div>
                    
                    <div class="form-group ">
                        <label for="subject">Subject <span class="text-danger">*</span> </label>
                        <select name="subject" id="subject" class="form-control">
                            <option value="<?php echo $lesson['subject_id'] ?? set_value('subject_id');?>"><?php echo $lesson['subject'] ?? set_value('subject');?></option>
                            <?php foreach($subjects as $subject): ?>
                                <option value="<?php  echo $subject['subject_id'];?>" <?php echo set_select("subject",$subject['subject_id'],(!empty($subject_list) && $subject_list==$subject['subject_id'] ? TRUE:FALSE));?>>
                                    <?php echo $subject['subject']."-".$subject['level']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo form_error('subject');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="topic">Topic <span class="text-danger">*</span> </label>
                        <input type="hidden" name="lesson_id" value="<?php echo $lesson['lesson_id']; ?>">
                        <select name="topic" id="topic" class="form-control">
                        <option value="<?php echo $lesson['topic_id'] ?? set_value('topic_id');?>"><?php echo $lesson['topic'] ?? set_value('topic');?></option>
                            <?php foreach($topics as $topic): ?>
                                <option value="<?php  echo $topic['topic_id'];?>" <?php echo set_select("topic",$topic['topic_id'],(!empty($topic_list) && $topic_list==$topic['topic_id'] ? TRUE:FALSE));?>>
                                    <?php echo $topic['topic']."-".$topic['level'];  ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo form_error('topic');?></span>
                    </div>
                    
                    <div class="form-group ">
                        <label for="subtopic">Sub Topic <span class="text-danger">*</span> </label>
                        <input type="text" name="subtopic" id="subtopic" class="form-control <?php if(form_error('subtopic')): echo "is-invalid"; endif;?>" placeholder="Enter subtopic name" value="<?php echo $lesson['subtopic'];?>" required>
                        <span class="invalid-feedback"><?php echo form_error('subtopic');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="videotitle">Video Title <span class="text-danger">*</span> </label>
                        <input type="text" name="title" id="videotitle" class="form-control <?php if(form_error('videotitle')): echo "is-invalid"; endif;?>" placeholder="Enter video title" value="<?php echo $lesson['title'];?>" autofocus="autofocus" required>
                        <span class="invalid-feedback"><?php echo form_error('videotitle');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="video">Video URL <span class="text-danger">*</span> </label>
                        <input type="text" name="video" id="video" class="form-control <?php if(form_error('video')): echo "is-invalid"; endif;?>" placeholder="Enter video url name" value="<?php echo $lesson['video'];?>" autofocus="autofocus" required>
                        <span class="invalid-feedback"><?php echo form_error('video');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="teacher">Teacher <span class="text-danger">*</span> </label>
                        <select name="teacher" id="teacher" class="form-control">
                        <option value="<?php echo $lesson['teacher_id'] ?? set_value('teacher_id');?>"><?php echo $lesson['firstname']." ".$lesson['lastname'] ?? set_value('teacher');?></option>
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
                                <img src="<?php echo $lesson['image'];?>" alt="user" class=""  id="thumbImage" width="140" height="140">
                                <input type="file" id="image" name="image" style="display: none;" accept="image/*" required/>
                            </div>
                            <div class="row ml-1">
                                <a href="javascript:uploadImage()">upload</a> 
                                <a class="text-danger ml-1" href="javascript:DeleteImage()">remove</a>
                            </div>
                            <span class="invalid-feedback imageerror"></span>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <div class="form-group">
                        <label for="video">Video <span class="text-danger">*</span> </label>
                            <div class="d-flex flex-row">
                                <iframe src="<?php echo $lesson['video'];?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe>
                            </div>
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
    $('#editlesson').validate({
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
        $('#thumbImage').attr('src', '<?php echo base_url('assets/backend/images/uploads/lessons/').$lesson['image'];?>');
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
        $('#preview').attr('src', '<?php echo base_url('assets/backend/videos/uploads/lessons/').$lesson['video'];?>');
        $('#videoerror').text('')
    }
</script>
