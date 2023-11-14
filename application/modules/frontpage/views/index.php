<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    
    <title>PPPTS</title>
        
    <link href="<?= base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url()?>assets/css/pppts_style.css" rel="stylesheet">    
    <script type="text/javascript" charset="UTF-8" src="<?= base_url()?>assets/js/jquery-1.9.1.js"></script>
  	<script type="text/javascript" charset="UTF-8" src="<?= base_url()?>assets/js/bootstrap.min.js"></script>
  	
  	
</head>
<body>
	<!-- header -->
	<?php $this->load->view('header')?>
	<!-- end header -->
	
	<!-- container -->
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">		
		
		<!-- content -->
			<div class="col-xs-12 col-sm-9 col-lg-9">
			<?php $this->load->view($view)?>
			</div>
		</div>
		<!-- end content -->
		
		<!-- sidebar -->
		<div class="col-xs-6 col-sm-3 col-lg-3" id="sidebar" role="navigation">
		<?php $this->load->view('sidebar')?>
		</div>
		<!-- end sidebar -->		
		<div class="row row-offcanvas-right"> </div>
	</div>
	<!-- end container -->
	
	<!-- footer -->
	<footer class="well">
    <div class="container">          
    <p class="text-center text-inset">Copyright © PPPTS 2016 All Right Reserved</p>

    <div class="row">
        <div class="col-lg-3 col-sm-3">
            <h3 class="text-inset">Contact</h3>
            <p class="text-inset">
                Jl. Dewi Sartika No.289, Cawang, Jakarta Timur
                <br>
                Phone: (021) 8005721 
                <br>
                Ejournal Team
            </p>
        </div>
                
                
        <div class="col-lg-3 col-sm-3">
            <h3 class="text-inset">Links</h3>
            <ul class="list-unstyled">
              <li >
                <a href="http://www.bsi.ac.id/">www.bsi.ac.id</a>
              </li>
              <li >
                <a href="http://www.nusamandiri.ac.id/">www.nusamandiri.ac.id</a>
              </li>
              <li >
                <a href="http://lppm.bsi.ac.id/">lppm.bsi.ac.id</a>
              </li>
              <li >
                <a href="http://www.mosaik-pena.com">www.mosaik-pena.com</a>
              </li>
            </ul>
        </div>
    </div>
    </div>
    
	</footer>
	<!-- end footer -->
</body>
</html>