
<!-- /.row -->
<div class="panel panel-success">
    <div class="panel-heading"><b>Update Pengguna</b></div>
    <form action="<?php echo base_url(); ?>officer/officer/update" method="POST" name='myForm'>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12 blog-main">
                        <div class="col-sm-10">
                            
                            <div class="form-group">    
                                <label for="user_id" class="col-xs-2">User ID </label> 
                                <div class="col-xs-10"> 
                                    <input class="form-control" type="text" id="user_id" name="user_id"  value="<?= $userSelected->getUserId(); ?>" class="form-control" readonly required/><br>
                                    
                                </div>
                            </div>
                             <div class="form-group">    
                                <label for="user_id" class="col-xs-2">User Name </label> 
                                <div class="col-xs-10"> 
                                    <input class="form-control" type="text" id="user_name" name="user_name"  value="<?= $userSelected->getUserName(); ?>" class="form-control"  required/><br>                                    
                                </div>
                            </div>
                            <div class="form-group">    
                                <label for="user_id" class="col-xs-2">Email </label> 
                                <div class="col-xs-10"> 
                                    <input class="form-control" type="email" id="email" name="email"  value="<?= $userSelected->getEmail(); ?>" class="form-control"  required/><div class="avemail alert-success" style='display:none'>email tersedia</div><div style='display:none' class="unemail alert-danger">email sudah terpakai</div><br>                                   
                                </div>
                            </div>                            
                             <div class="form-group">    
                                <label for="user_name" class="col-xs-2">Unit Kerja: </label> 
                                <div class="col-xs-10"> 
                                    <select class='form-control' id='unit_id' name='unit_id' >
                                <?php foreach ($unitKerja as $unitKerja): ?>
                                        
                                    <option <?php if ($userSelected->getUnitId() == $unitKerja->getUnitId()) echo"selected"; ?> value='<?php echo $unitKerja->getUnitId(); ?>'><?= $unitKerja->getUnitName(); ?></option>                                   
                                    
                                <?php endforeach; ?>
                            </select>
                            <br/>
                                </div>
                            </div>                            
                          <div class="form-group">    
                                <label for="user_type" class="col-xs-2">Tipe Pengguna:</label> 
                                <div class="col-xs-10"> 
                                    <select class='form-control' id='user_type' name='user_type' >
                                <?php foreach ($userType as $userType): ?>
                                    <option <?php if ($userSelected->getUserType() == $userType->getUserType()) echo"selected"; ?> value='<?php echo $userType->getUserType(); ?>'> <?= $userType->getTypeName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <br/>
                           
                                </div>
                            </div>
                            


                            <div class="col-lg-12">
                                <h4>Hak Access</h4>
                            </div>
                            <div class="col-lg-12" >
                                <ul class='trvsr'>
                                    <?php
                                    $this->load->model('modofficer');
                                    $temSystem = '';
                                    $temMod = '';
                                    $temSubMod = '';
                                    $i = 0;
                                    $j = 0;
                                    $countrole = 0;
                                    // echo $useraccess->getUserId();	
                                    $arrayrole = array();
                                    // echo $userSelected->user_id;
                                    $useraccess = $this->modofficer->get_userAccess($userSelected->getUserId());
                                    // print_r($useraccess);
                                    //print_r($useraccess);
                                    // if($useraccess->getUserId()){
                                    foreach ($useraccess as $useraccess):
                                        $arrayrole[$countrole] = $useraccess->sub_module_id;
                                        $countrole++;
                                    endforeach;
                                    $objsystem = new ModSystemInformation('');
                                    $systems = $objsystem->getObjectList('', '');
                                    $objmodule = new ModSystemModule('');
                                    $objsubmodule = new ModSubSystemModule('', '');
                                    $i = 0;
                                    $j = 0;
                                    foreach ($systems as $system):
                                        $systemName = $system->getSystemName();
                                        $systemId = $system->getSystemId();
                                        echo"<li class='t-root'>";
                                        echo "<!--<input  class='t-checkbox' type='checkbox' name='system[]' id='root$i' value='$systemId'/>--><i class='glyphicon glyphicon-minus'></i>$systemName<br>";
                                        $objmodule->m_ModSystemInformation = $system;
                                        $modules = $objmodule->getObjectList('', '');
                                        echo "
						<ul>					
						";

                                        if (count((array) $modules) > 0) {
                                            foreach ($modules->result() as $module):
                                                $modName = $module->module_name;
                                                $modId = $module->module_id;
                                                echo "<li>";
                                                echo "<!--<input class='t-checkbox' type='checkbox' name='mod[]'  id='module$j' value='$modId' />--><i class='glyphicon glyphicon-minus'></i>$modName<br>";
                                                $objsubmodule->m_ModSystemModule = $module;
                                                $submodules = $objsubmodule->getObjectListModule('', '');
                                                echo "<ul>";
                                                if (count((array) $submodules) > 0) {
                                                    foreach ($submodules->result() as $submodule):
                                                        $submodName = $submodule->sub_module_name;
                                                        $submodId = $submodule->sub_module_id;
                                                        $submodDes = $submodule->deskripsi;
                                                        $i = 0;
                                                        $status = 0;
                                                        for ($i = 0; $i < $countrole; $i++) {

                                                            if ($arrayrole[$i] == $submodId) {
                                                                $status = 1;
                                                            }
                                                        }
                                                        if ($status == 1) {
                                                            echo "<li>";
                                                            echo "<input class='t-leaf$j' type='checkbox' name='submod[]' id='submod$j'  value='$submodId' checked/>$submodName ($submodDes)<br>";
                                                            echo "</li>";
                                                        } else {
                                                            echo "<li>";
                                                            echo "<input class='t-leaf$j' type='checkbox' name='submod[]' id='submod$j'  value='$submodId'/>$submodName ($submodDes)<br>";
                                                            echo "</li>";
                                                        }
                                                    endforeach;
                                                } else {
                                                    echo "
										<li>
											+ Kosong
										</li>
									";
                                                }
                                                echo "</ul>";
                                                echo "</li>";
                                                $j++;
                                            endforeach;
                                        } else {
                                            echo "
								<li>
									+ Kosong
								</li>
							";
                                        }
                                        $i++;
                                        echo "</ul>";
                                        echo "</li>";
                                    endforeach;
                                    ?>
                                </ul>

                            </div>

                            <input  class="btn btn-warning" style="margin-top:10px;" type="submit" value="Ubah"/>

                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
 </form>
</div>
<!-- /.row -->


<!-- /.container-fluid -->
<script type='text/javascript'>
    $(document).ready(function() {
        // <?php
                                    // $k=0;
                                    // for($k=0;$k<$j;$k++){
                                    // 
                                    ?>
        // if($('.t-leaf<?= $k ?>').is(':checked')==true){
        // $('.leaf<?= $k ?>').show();
        // $('#module<?= $k ?>').attr('checked',true);
        // }
        // <?php
                                    // }
                                    // 
                                    ?>
        var form = document.myForm;
        $("input[name='email']").change(function() {
            var email = $("input[name='email']").val();
            var userid = $("input[name='user_id']").val();
            // alert(email);
            if (email.length > 2) {
                $.ajax({
                    type: 'POST',
                    data: 'email=' + email + '&userid=' + userid,
                    url: '<?php echo base_url(); ?>/officer/cekeditemail',
                    success: function(data) {
                        // alert(data);
                        if (data != 'TRUE') {
                            $("input[type='submit']").prop('disabled', 'disabled');
                            form.onsubmit = function() {
                                return false;
                            }
                            $(".avemail").hide();
                            $(".unemail").show();
                        } else {
                            $("input[type='submit']").removeAttr('disabled');
                            form.onsubmit = function() {
                                return true;
                            }
                            $(".unemail").hide();
                            $(".avemail").show();
                        }

                    }
                });
            } else {
                $(".unemail").hide();
                $(".avemail").hide();
            }

        });
    });
</script>