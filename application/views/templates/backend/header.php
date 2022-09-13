<?php
    $recent_payments = $this->Payment_model->getrecentpayments();
    $payments = $this->Payment_model->getstudent();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/plugins/fontawesome-free/css/all.min.css");?>">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="shortcut icon" href="<?php echo base_url("assets/backend/images/favicon.png");?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/plugins/css/tempusdominus-bootstrap-4.min.css");?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/plugins/css/icheck-bootstrap.min.css");?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/dist/css/dialog.css");?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/dist/css/adminlte.css");?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/plugins/css/OverlayScrollbars.min.css");?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/plugins/css/daterangepicker.css");?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/plugins/css/summernote-bs4.min.css");?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/plugins/css/dataTables.bootstrap4.min.css");?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/plugins/css/responsive.bootstrap4.min.css");?>">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="https://netschoolug.com" target="blank" class="nav-link">visit website</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge" id="recentpayment">
              <?php echo $recent_payments; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <?php if($recent_payments > 0):?>    
        <?php foreach($payments as $key=>$payment): ?>
          <a href="#" class="dropdown-item">
            <div class="media">
                <img src="<?php echo base_url('assets/backend/images/uploads/students/default.png');?>"  alt="image" class="img-size-50 mr-3 img-circle" width="35px" height="35px">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <?php echo $payment['firstname'].' '.$payment['lastname'];?>
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Pending confirmation...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?php echo date("M d, Y h:i A", strtotime($payment['date_created']));?></p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
        <?php endforeach;?>  
          <a href="<?php echo base_url('admin/payments'); ?>" class="dropdown-item dropdown-footer">
              See All Payments</a>
        </div>
        <?php else:?>
        <a href="<?php echo base_url('admin/payments'); ?>" class="dropdown-item dropdown-footer">
              There are no pending payment confirmations.</a>
        <a href="<?php echo base_url('admin/payments'); ?>" class="dropdown-item dropdown-footer">
              See All Payments</a>
        <?php endif;?>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url("admin/profile"); ?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> My Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url("admin/change-password"); ?>" class="dropdown-item">
          <i class="fas fa-lock mr-2"></i> Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url("admin/logout"); ?>" class="dropdown-item">
            <i class="fa fa-sign-out-alt mr-2"></i> Logout
          </a>
      </li>
    </ul>
  </nav>
