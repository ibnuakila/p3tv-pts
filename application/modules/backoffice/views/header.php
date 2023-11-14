<nav class="navbar navbar-fixed-top navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://ppptv-pts.kemdikbud.go.id">PPPTS</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?= base_url() ?>">Beranda</a></li>            
          </ul>
          <ul class="nav navbar-nav">
                        <?php
                        $userid = strtoupper($this->session->userdata('userid'));
                        
                        $user = new ModUsers($userid);
                        if($user->getUserName()!=''){
                            $objsystem = new ModSystemInformation('');
                            $systems = $objsystem->getObjectListUser($userid);
                            $objmodule = new ModSystemModule('');
                            $objsubmodule = new ModSubSystemModule('', '');
                            $accesed_module = ucfirst($this->uri->segment(1));
                            foreach ($systems as $system) {
                            ?>
                            <li class="dropdown <?php if($system->getSystemName()==$accesed_module){                            echo 'active';} ?>">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <?= $system->getSystemLabel() ?>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu" role="menu"> 
                                    <?php
                                    $objmodule->m_ModSystemInformation = $system;
                                    $modules = $objmodule->getObjectList('', '');
                                            foreach ($modules as $module) {
                                            //print_r($module);
                                            $objsubmodule->m_ModSystemModule = $module;
                                            $objsubmodule->setUserId($user->getUserId());
                                            $submodules = $objsubmodule->getObjectList('', '');
                                                if (count($submodules) > 0) {
                                                    foreach ($submodules as $submodule) {

                                                        if ($submodule->getIsMenu() == 't') {
                                                            ?>            

                                                            <li role="presentation"><a href="<?=
                                                                base_url() . strtolower($system->getSystemName() . '/' .
                                                                        $module->getModuleName() . '/' .
                                                                        $submodule->getSubModuleName())
                                                                ?>">
                                                                    <i class="glyphicon glyphicon-chevron-right"></i> <?= $submodule->getMenuName() ?>
                                                                </a>
                                                            </li>

                                                            <?php
                                                        }
                                                    }
                                                }?>
                                        
                                        <?php } ?>
                                    
                                    </ul>
                                </li>
                            <?php
                            }
                        }
                        ?> 
                    </ul>
		<?php if($this->sessionutility->validatesession()){?>                    
          <ul class="nav navbar-nav pull-right">
          	<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	          <?php $u_id = $this->session->userdata('userid');
	          		$user = new ModUsers($u_id);
	          		echo $user->getUserName();
	          ?> <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="<?=base_url().'monitoring/monitoring/ubahpassword' ?>">Ubah Password</a></li>		            
	            <li role="separator" class="divider"></li>
	            <li><a href="<?=base_url().'backoffice/logout' ?>">Log Out</a></li>	            
	          </ul>
	        </li>
          </ul>
        <?php }?>          
        </div><!-- /.nav-collapse -->                
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <div class="myhead">
      <div class="container">
          <div class="row">
                <div class="col-md-2">                    
                        <img src="<?=base_url()?>assets/images/logo_tutwuri_transparent.png"  class="img logo">                    
                </div>
                <div class="col-md-7">                      
                    <div class="row">                        
                    <h3 class="text-shadow">PPPTV-PTS</h3>
                    <h4 class="text-shadow">Direktorat Vokasi Perguruan Tinggi</h4>                    
                    <h4 class="text-shadow"><em>Kementerian Pendidikan dan Kebudayaan</em> </h4>
                    <!--<footer>Temukan referensi paper yang Anda butuhkan disini.</footer>-->                                           
                    </div>
                    
                </div>
              
          </div>
          
      </div>
    </div>