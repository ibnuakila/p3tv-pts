<nav class="navbar navbar-fixed-top navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">PPPTS</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?= base_url() ?>index.php/frontpage">Beranda</a></li>
            
            <li><a href="<?= base_url() ?>index.php/frontpage/registration">Registrasi</a></li>
            <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Layanan <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">One more separated link</a></li>
	          </ul>
	        </li>
          </ul>
          
        </div><!-- /.nav-collapse -->
        
        
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <div class="myhead">
      <div class="container">
          <div class="row">
                <div class="col-md-2">
                    
                        <img src="<?=base_url()?>assets/images/kemenristekdikti.png"  class="logo">
                    
                </div>
                <div class="col-md-6">                    
            
                    <div class="row">
                        
                    <h2 class="text-shadow">PPPTS</h2>
                    <p class="text-shadow"><em>Kementerian Riset, Teknologi, dan Pendidikan Tinggi</em> </p>
                    <!--<footer>Temukan referensi paper yang Anda butuhkan disini.</footer>-->                    
                       
                    </div>
                    
                </div>
              <div class="col-md-4 col-sm-4">
                  <div class="row">
                    <div class="pull-right">
                        
                        <form class="" role="search" action="<?=  base_url() ?>index.php/ejournal/search" method="post">
                            
                            <div class="input-group input-group-sm">
                              <input type="text" name="searchtext" class="form-control" placeholder="Search" value="<?php if (isset($keyword)){ echo $keyword;}?>">
                              <div class="input-group-btn">
                            <button type="submit" name="find" class="btn btn-default" value="find"><i class="glyphicon glyphicon-search glyphicon-white"></i></button>
                              </div>
                            </div>
                        </form>
                        
                    </div>
                  </div>
                  <div class="row">
                      <div class="lang-box pull-right">
                          
                          <a href="#" class="btn btn-primary btn-xs active" title="English">En</a> 
                          <a href="#" class="btn btn-primary btn-xs" title="Indonesia">Id</a>
                            
                         
                      </div>
                  </div>
              </div>
          </div>
          
      </div>
    </div>