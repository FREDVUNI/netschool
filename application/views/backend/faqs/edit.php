<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Edit question</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Edit question</li>
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
                <?php echo $faq["question"]; ?>
              </div>
              <div class="card-body">
              <form id="editquestion" action="<?php echo base_url('/admin/'.$faq['slug'].'/faq'); ?>" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="form-group ">
                        <label for="question">Question <span class="text-danger">*</span> </label>
                        <input type="hidden" name="id" value="<?php echo $faq['id']; ?>">
                        <input type="text" name="question" id="question" class="form-control <?php if(form_error('question')): echo "is-invalid"; endif;?>" placeholder="Enter question" value="<?php echo $faq['question'] ?? set_value('question');?>" autofocus="autofocus" required pattern="^[A-Za-z0-9_- ]$">
                        <span class="invalid-feedback"><?php echo form_error('question');?></span>
                    </div>
                    <div class="form-group ">
                        <label for="answer">Answer <span class="text-danger">*</span> </label>
                        <input type="text" name="answer" id="answer" class="form-control <?php if(form_error('answer')): echo "is-invalid"; endif;?>" placeholder="Enter answer" value="<?php echo $faq['answer'] ?? set_value('answer');?>" required pattern="^[A-Za-z0-9_- ]$">
                        <span class="invalid-feedback"><?php echo form_error('answer');?></span>
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
    $('#editquestion').validate({
        rules: {
        question: {
            required: true,
        },
        
        answer: {
            required: true,
        },
        },
        messages: {
            question: {
            required: "Please enter a level name",
        },
            answer: {
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