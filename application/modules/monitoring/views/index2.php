<!DOCTYPE hmtl>
<html lang="en">
<head>
    <meta charset="utf-8">	
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    
    <title>PPPTS</title>
        
   
    <link href="<?= base_url()?>assets/css/pppts_style.css" rel="stylesheet">
    <link href="<?= base_url()?>assets/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">    
    	 <?php
            
            echo put_headers_js();
            echo put_headers_css();
            echo put_footers_css();
            echo put_footers_js();           
        ?>
  	
</head>
<body>
	<!-- header -->
	<?php $this->load->view('header')?>
	<!-- end header -->
	
	<!-- container -->
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">		
		
		<!-- content -->
			<div class="col-xs-12 col-sm-12 col-lg-12">
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
    <p class="text-center text-shadow">Copyright © PPPTS 2016 All Right Reserved</p>
    
    </div>
    
	</footer>
	<!-- end footer -->
</body>
</html>