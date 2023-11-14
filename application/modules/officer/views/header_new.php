<nav class="navbar navbar-expand-md navbar-light bg-warning sticky-top">
    <div class="container-fluid">
        <a href="" class="navbar-brand"><img src="<?= base_url() ?>assets/images/tut-wuri-handayani-7759.png" style="width: 60px; height: 60px;">
        </a>
        <span>
            <h3 class="text-shadow">PPPTV-PTS</h3>
            <h5 class="text-white">Direktorat Jenderal Pendidikan Vokasi</h5>
            <h5 class="text-white">Kementerian Pendidikan dan Kebudayaan</h5>
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="<?= base_url()?>" class="nav-link active">Home</a>
                </li>
                <?php
                $userid = strtoupper($this->session->userdata('userid'));

                $user = new ModUsers($userid);
                if ($user->getUserName() != '') {
                    $objsystem = new ModSystemInformation('');
                    $systems = $objsystem->getObjectListUser($userid);
                    $objmodule = new ModSystemModule('');
                    $objsubmodule = new ModSubSystemModule('', '');
                    $accesed_module = ucfirst($this->uri->segment(1));
                    foreach ($systems as $system) {
                        ?>
                        <li class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $system->getSystemLabel() ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
                                                <a class="dropdown-item" href="<?=
                                                base_url() . strtolower($system->getSystemName() . '/' .
                                                        $module->getModuleName() . '/' .
                                                        $submodule->getSubModuleName())
                                                ?>"><?= $submodule->getMenuName() ?></a>
                                                   <?php
                                               }
                                           }
                                       }
                                   }
                                   ?>

                            </div>
                        </li>

                        <?php
                    }
                }
                ?>
                <?php if ($this->sessionutility->validatesession()) { ?>                    

                    <li class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php
                            $u_id = $this->session->userdata('userid');
                            $user = new ModUsers($u_id);
                            echo $user->getUserName();
                            ?> 
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="<?= base_url() . 'monitoring/monitoring/ubahpassword' ?>">Ubah Password</a>		            
                            
                            <a class="dropdown-item" href="<?= base_url() . 'backoffice/logout' ?>">Log Out</a>	            
                        </div>
                    </li>

                <?php } ?>       

            </ul>


        </div>
    </div>
</nav>