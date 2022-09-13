<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netschool | Error 404</title>
    <link rel="shortcut icon" href="<?php echo base_url("assets/backend/images/favicon.png");?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/plugins/fontawesome-free/css/all.min.css");?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/dist/css/adminlte.min.css");?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/dist/css/style.css");?>">
</head>
<body class="bg-img-hero-fixed" style="background-image: url(<?php echo base_url("assets/backend/images/svg/error-404.svg");?>);" data-gr-c-s-loaded="true">
    <header id="header" class="header header-bg-transparent header-abs-top py-3">
        <div class="header-section">
        <div id="logoAndNav" class="container">
            <nav class="navbar">
                <a class="navbar-brand" href="<?php echo base_url("admin/index");?>" aria-label="Netschool">
                    <img src="<?php echo base_url("assets/backend/images/favicon.png");?>" alt="Logo" width="100px">
                </a>
            </nav>
        </div>
        </div>
    </header>
    <div class="container">
        <main id="content" role="main">
            <div class="d-lg-flex">
            <div class="container d-lg-flex align-items-lg-center min-vh-lg-100">
                <div class="w-lg-60 w-xl-50">
                <div class="mb-4">
                <div class="text-center">
                    <div class="error404 mx-auto" data-text="404">404</div>
                    <p class="lead text-gray-800 mb-5">Page Not Found</p>
                </div>
                <p class="lead">Oops! Looks like you followed a bad link. <br> If you think this is a problem with us, please <a href="#">tell us.</a></p>
                </div>
                <a class="btn btn-lg btn-primary transition-3d-hover" href="<?php echo base_url("admin/index");?>">Back Home</a>
                </div>
            </div>
            </div>
        </main>
        <footer class="position-absolute right-0 bottom-0 left-0 mt-5">
            <div class="container">
            <div class="d-flex justify-content-between align-items-center space-1">
                <p class="text-small text-muted mb-0">© NET SCHOOL. <?php echo date("Y"); ?>.</p>
                <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <a class="btn btn-xs btn-icon btn-ghost-secondary" href="#">
                    <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="btn btn-xs btn-icon btn-ghost-secondary" href="#">
                    <i class="fab fa-twitter"></i>
                    </a>
                </li>
                </ul>
            </div>
            </div>
        </footer>
    </div> 
</body>
</html>