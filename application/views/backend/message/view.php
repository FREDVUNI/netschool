<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Message Content</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">message content</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="col-md-12">
            <div class="row inbox-wrapper">
            <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 email-content">
                  <div class="email-head">
                    <div class="email-head-subject">
                      <div class="title d-flex align-items-center justify-content-between">
                      </div>
                    </div>
                    <div class="email-head-sender d-flex align-items-center justify-content-between flex-wrap">
                      <div class="d-flex align-items-center">
                        <div class="avatar">
                          <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="Avatar" class="rounded-circle user-avatar-md" width="35">
                        </div>
                        <div class="ml-3 sender d-flex align-items-center">
                          <a href="#"><?php echo $message['name'];?> says;</a>
                        </div>
                      </div>
                      <div class="date"><?php echo date("M d, Y", strtotime($message['date_created']));?></div>
                    </div>
                    <br/>
                    <div class="d-flex align-items-center">
                        <span><?php if($message["subject"]):echo $message["subject"]; else: echo 'No subject'; endif;?></span>
                    </div>
                  </div>
                  <div class="email-body">
                    <p></p>
                    <br>
                    <p><?php echo $message['message'];?>.</p>
                    <br>
                    <p><strong>Email</strong>,<br> <?php echo $message['email'];?></p>
                    <br>
                    <a class="btn btn-primary btn-block col-md-2" target="blank" href="https://mail.google.com/mail/u/0/#inbox?compose=new">Compose Email</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
</section>
</div>
