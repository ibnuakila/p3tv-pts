<nav class="pcoded-navbar  ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div " >

            <div class="">
                <div class="main-menu-header">
                    <img class="img-radius" src="<?= base_url() ?>assets/admin2023/images/user/avatar-dummy.png" alt="User-Profile-Image">
                    <div class="user-details">
                        <?php
                        $userid = strtoupper($this->session->userdata('userid'));
                        $user = new ModUsers($userid);
                        $utype = new ModUserType($user->getUserType());
                        ?>
                        <span><?= $user->getUserName() ?></span>
                        <div id="more-details"><?= $utype->getTypeName() ?><i class="fa fa-chevron-down m-l-5"></i></div>
                    </div>
                </div>
                <div class="collapse" id="nav-user-link">
                    <ul class="list-unstyled">
                        <li class="list-group-item"><a href="user-profile.html"><i class="feather icon-user m-r-5"></i>View Profile</a></li>
                        <li class="list-group-item"><a href="<?= base_url() . 'monitoring/monitoring/ubahpassword' ?>"><i class="feather icon-settings m-r-5"></i>Ubah Password</a></li>
                        <li class="list-group-item"><a href="<?= base_url() . 'backoffice/logout' ?>"><i class="feather icon-log-out m-r-5"></i>Logout</a></li>
                    </ul>
                </div>
            </div>

            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption">
                    <label>Navigation</label>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() . 'backoffice/index' ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>
                <?php
                $objsystem = new ModSystemInformation('');
                $systems = $objsystem->getObjectListUser($userid);
                $objmodule = new ModSystemModule('');
                $objsubmodule = new ModSubSystemModule('', '');
                $accesed_module = ucfirst($this->uri->segment(1));
                foreach ($systems->result() as $sys_row) {
                    $system = new ModSystemInformation($sys_row->system_id);
                    ?>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-layout"></i></span><span class="pcoded-mtext"><?= $system->getSystemLabel() ?></span></a>
                        <ul class="pcoded-submenu">
                            <?php
                            $objmodule->m_ModSystemInformation = $system;
                            $modules = $objmodule->getObjectList('', '');
                            foreach ($modules->result() as $module_row) {
                                $module = new ModSystemModule($module_row->module_id);
                                $objsubmodule->m_ModSystemModule = $module;
                                $objsubmodule->setUserId($user->getUserId());
                                $submodules = $objsubmodule->getObjectList('', '');
                                if (($submodules->num_rows()) > 0) {
                                    foreach ($submodules->result() as $submod_row) {
                                        $submodule = new ModSubSystemModule($submod_row->sub_module_id);
                                        if ($submodule->getIsMenu() == 't') {
                                            ?>
                                            <li><a href="<?=
                                                base_url() . strtolower($system->getSystemName() . '/' .
                                                        $module->getModuleName() . '/' .
                                                        $submodule->getSubModuleName())
                                                ?>"><?= $submodule->getMenuName() ?></a></li>

                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                ?>

            </ul>

            <div class="card text-center">
                <div class="card-block">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="feather icon-sunset f-40"></i>
                    <h6 class="mt-3">PPPTV-PTS</h6>
                    <p>Silahkan hubungi Administrator bila Anda menemukan kesulitan</p>

                </div>
            </div>

        </div>
    </div>
</nav>