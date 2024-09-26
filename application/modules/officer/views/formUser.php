




<div class="card col-sm-12">
    <div class="card-header"><b>Tambah Pengguna</b></div>
    <form action="<?php echo base_url(); ?>officer/officer/create" method="POST" name='myForm'>
    <div class="card-body">
        <div class="">            
            <div class="row">
            <div class="col-sm-12 blog-main">
                <div class="col-sm-10">                   
                        
                            <div class="form-group">    
                                <label for="user_id" class="col-xs-2">User ID </label> 
                                <div class="col-xs-10"> 
                                    <input class="form-control" type="text" id="user_id" name="user_id"  placeholder="user ID ..." width="20px"/><br>
                                    <div class="user_id alert-success" style='display:none'>user id tersedia</div><div style='display:none' class="unuser_id alert-danger">user id sudah terpakai</div>
                                </div>
                            </div>
                             <div class="form-group">    
                                <label for="user_name" class="col-xs-2">Nama Pengguna </label> 
                                <div class="col-xs-10"> 
                                    <input class="form-control" type="text" id="user_name" name="user_name"  placeholder="Nama Pengguna ..." width="20px"/> <br>                                   
                                </div>
                            </div>
                            <div class="form-group">    
                                <label for="user_name" class="col-xs-2">Password </label> 
                                <div class="col-xs-10"> 
                                    <input class="form-control" type="password" id="password" name="password"  placeholder="password ..." width="20px"/>  <br>                                  
                                </div>
                            </div>    
                            <div class="form-group">    
                                <label for="user_name" class="col-xs-2">Ulangi Password </label> 
                                <div class="col-xs-10"> 
                                    <input class="form-control" type="password" id="ulangi_password" name="ulangi_password"  placeholder="Ulangi password ..." width="20px"/>                                    
                                    <div class="pass alert-success" style='display:none'>password benar</div><div style='display:none' class="unpass alert-danger">password salah</div><br>
                                </div>
                            </div>                             
                            <div class="form-group">    
                                <label for="user_name" class="col-xs-2">Email </label> 
                                <div class="col-xs-10"> 
                                    <input class="form-control" type="email" id="email" name="email"  placeholder="email ..." width="20px"/>                                    
                                    <div class="avemail alert-success" style='display:none'>email tersedia</div><div style='display:none' class="unemail alert-danger">email sudah terpakai</div><br>
                                </div>
                            </div>
                            <div class="form-group">    
                                <label for="user_name" class="col-xs-2">Unit Kerja: </label> 
                                <div class="col-xs-10"> 
                                    <select class='form-control' name='unit_id' >
                                <?php foreach ($unitKerja as $unitKerja): ?>
                                    <option value='<?php echo $unitKerja->getUnitId(); ?>'><?php echo $unitKerja->getUnitName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <br/>
                                </div>
                            </div>
                            <div class="form-group">    
                                <label for="user_name" class="col-xs-2">Tipe Pengguna:</label> 
                                <div class="col-xs-10"> 
                                    <select class='form-control' name='user_type' >
                                <?php foreach ($userType as $userType): ?>
                                    <option value='<?= $userType->getUserType(); ?>'><?= $userType->getTypeName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <br/>
                           
                                </div>
                            </div>
                           
                           
                            <div class="col-lg-12">
                                <h4>Hak Access</h4>
                            </div>
                            <div class="col-lg-12 useracces" >

                                <ul class='trvsr'>

                                    <?php
                                    $this->load->model('modofficer');
                                    $systems = $this->modofficer->get_si();
                                    $i = 0;
                                    $j = 0;
                                    foreach ($systems as $system):
                                        $systemName = $system->system_name;
                                        if ($systemName != "") {
                                            $systemId = $system->system_id;
                                            echo"<li class='t-root'>";
                                            echo "<!--<input  class='t-checkbox' type='checkbox' name='system[]' id='root$i' value='$systemId'/>--><i class='glyphicon glyphicon-minus'></i>$systemName<br>";

                                            $modules = $this->modofficer->get_modules_selected($systemId);
                                            echo "
										<ul>					
										";
                                            foreach ($modules as $module):
                                                $modName = $module->module_name;
                                                if ($modName != "") {
                                                    $modId = $module->module_id;
                                                    echo "<li>";
                                                    echo "<!--<input class='t-checkbox' type='checkbox' name='mod[]'  id='module$j' value='$modId' />--><i class='glyphicon glyphicon-minus'></i>$modName<br>";

                                                    $submodules = $this->modofficer->get_subModules_selected($modId);
                                                    echo "<ul>";
                                                    foreach ($submodules as $submodule):
                                                        $submodName = $submodule->sub_module_name;
                                                        if ($submodName) {
                                                            $submodId = $submodule->sub_module_id;
                                                            $submodDes = $submodule->deskripsi;
                                                            echo "<li>";
                                                            echo "<input class='t-leaf$j' type='checkbox' name='submod[]' id='submod$j'  value='$submodId'/>$submodName &nbsp;( $submodDes  )";

                                                            echo "</li>";
                                                        }
                                                    endforeach;
                                                    echo "</ul>";
                                                    echo "</li>";
                                                    $j++;
                                                }
                                            endforeach;
                                            $i++;
                                            echo "</ul>";
                                            echo "</li>";
                                        }
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                            <input id="tambah" class="btn btn-primary" disabled style="margin-top:10px; clear:both;" type="submit" value="Simpan"/>

                        
                    </div>
                </div>


            </div>
                </div>
            <!-- /.row -->

        </div>
        </form>
    </div>
    <!-- /.container-fluid -->


    <script type='text/javascript'>
        $(document).ready(function() {
            var user_type = $("select[name='user_type']").val();
            var unit_id = $("select[name='unit_id']").val();
            $.ajax({
                type: 'POST',
                data: 'user_type=' + user_type + '&unit_id=' + unit_id,
                url: '<?php echo base_url(); ?>officer/useraccess',
                beforeSet: function() {
                    $('.useracces').html('loading....');
                },
                success: function(data) {
                    $('.useracces').html(data);
                }

            });
            var form = document.myForm;
            $("select[name='user_type']").change(function() {
                var user_type = $("select[name='user_type']").val();
                var unit_id = $("select[name='unit_id']").val();
                $.ajax({
                    type: 'POST',
                    data: 'user_type=' + user_type + '&unit_id=' + unit_id,
                    url: '<?php echo base_url(); ?>officer/useraccess',
                    beforeSet: function() {
                        $('.useracces').html('loading....');
                    },
                    success: function(data) {
                        $('.useracces').html(data);
                    }

                });
            });
            $("select[name='unit_id']").change(function() {
                var user_type = $("select[name='user_type']").val();
                var unit_id = $("select[name='unit_id']").val();
                $.ajax({
                    type: 'POST',
                    data: 'user_type=' + user_type + '&unit_id=' + unit_id,
                    url: '<?php echo base_url(); ?>officer/useraccess',
                    beforeSet: function() {
                        $('.useracces').html('loading....');
                    },
                    success: function(data) {
                        $('.useracces').html(data);
                    }

                });
            });
            $("input[name='ulangi_password']").keyup(function() {
                if ($("input[name='ulangi_password']").val() == $("input[name='password']").val()) {
                    $("input[type='submit']").removeAttr('disabled');
                    form.onsubmit = function() {
                        return true;
                    }
                    $(".unpass").hide();
                    $(".pass").show();
                    // alert($("input[type='submit']").val());
                } else {
                    $("input[type='submit']").prop('disabled', 'disabled');
                    form.onsubmit = function() {
                        return false;
                    }
                    $(".pass").hide();
                    $(".unpass").show();
                }
                if ($("input[name='ulangi_password']").val() == '') {

                    // $("input[name='ulangi_password']").css('background-color','#fff');
                    $(".unpass").hide();
                    $(".pass").hide();
                }
            });
            $("input[name='user_id']").keyup(function() {
                var user_id = $("input[name='user_id']").val();
                // alert(user_id);
                if (user_id.length > 2) {
                    $.ajax({
                        type: 'POST',
                        data: 'user_id=' + user_id,
                        url: '<?php echo base_url(); ?>officer/cekuser',
                        success: function(data) {
                            if (data == 'TRUE') {
                                $("input[type='submit']").prop('disabled', 'disabled');
                                form.onsubmit = function() {
                                    return false;
                                }
                                $(".user_id").hide();
                                $(".unuser_id").show();
                            } else {
                                $("input[type='submit']").removeAttr('disabled');
                                form.onsubmit = function() {
                                    return true;
                                }
                                $(".unuser_id").hide();
                                $(".user_id").show();
                            }

                        }
                    });
                } else {
                    $(".unuser_id").hide();
                    $(".user_id").hide();
                }

            });

            $("input[name='email']").change(function() {
                var email = $("input[name='email']").val();
                //alert(email);
                if (email.length > 2) {
                    $.ajax({
                        type: 'POST',
                        data: 'email=' + email,
                        url: '<?php echo base_url(); ?>/officer/officer/cekemail',
                        success: function(data) {
                            // alert(data);
                            if (data == 'TRUE') {
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