<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    
    <title>PPPTS</title>
        
    <link href="<?= base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url()?>assets/css/pppts_style.css" rel="stylesheet">
    <link href="<?= base_url()?>assets/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">    
    <script type="text/javascript" charset="UTF-8" src="<?= base_url()?>assets/js/jquery-1.9.1.js"></script>
  	<script type="text/javascript" charset="UTF-8" src="<?= base_url()?>assets/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="<?= base_url()?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
  	<script type="text/javascript" src="<?= base_url()?>assets/js/tinymce/tinymce.min.js"></script>
  	
</head>
<body>
	<!-- header -->
	<?php $this->load->view('header_new')?>
	<!-- end header -->
	
	<!-- container -->
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">		
		
		<!-- content -->
			<div class="col-xs-12 col-sm-12 col-lg-12">
			<?php 
			    $modules = ucfirst($this->uri->segment(1));
			    $control = ucfirst($this->uri->segment(2));
			    $function = ucfirst($this->uri->segment(3));
			    //echo strtoupper($control);
			?>
			    <ul class="breadcrumb breadcrumb-bg">
			        <li><a href="#"><?=$modules?></a> </li>
			        <li><a href="#"><?=$control?></a> </li>
			        <li class="active"><?=$function?></li>
			    </ul>
			<?php $this->load->view($view)?>
			</div>
		<!-- end content -->
		</div>
		
		
		<!-- sidebar 
		<div class="col-xs-6 col-sm-3 col-lg-3" id="sidebar" role="navigation">
		<?php //$this->load->view('sidebar')?>
		</div>
		end sidebar -->		
		<div class="row row-offcanvas-right"> </div>
	</div>
	<!-- end container -->
	
	<!-- footer -->
	<footer class="bg-primary">
    <div class="container">          
    <p class="text-center text-shadow">Copyright © PPPTS 2017 All Right Reserved</p>
    
    </div>
    
	</footer>
	<!-- end footer -->
</body>
</html>