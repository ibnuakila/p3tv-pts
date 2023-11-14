
<div class="col-sm-12">
<h3 class="display-5">
    Penugasan Penilaian Usulan
</h3>
    <hr>
    <div class="card">
        <div class="card-header">Form Penugasan</div>
        <div class="card-body" >
            <form class="form-horizontal" method="post" action="<?= base_url().'backoffice/kelolapenugasan/save/'.$flagInsert ?>">
                <fieldset>
                    <legend> </legend>
<?php   if(validation_errors()!=''){?>                    
		<div class="alert alert-danger alert-dismissible" role="alert">
        	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong><?php echo validation_errors(); ?></strong>
        </div>
<?php   } ?>                    

                <div class="form-group">
                    <label class="col-lg-2 control-label lbl-color" >Registrasi:</label>
                    
<?php
		//$account = $registrasi->getAccount();
		$yayasan = $registrasi->getPenyelenggara();
                $nm_yayasan = '';
                if(is_object($yayasan)){
                    $nm_yayasan = $yayasan->getNamaPenyelenggara();
                }
		$pt = $registrasi->getPti();
                $nm_pti = '';
                if(is_object($pt)){
                    $nm_pti = $pt->getNmPti();
                }
		$status = $registrasi->getStatusRegistrasi();
?>                  
                    <div class="col-lg-8">
                        <input type="text" id="registrasi" name="registrasi" class="form-control input-sm" value="<?=$registrasi->getIdRegistrasi() ?>">
                      <input type="hidden" id="idregistrasi" name="idregistrasi" value="<?=$registrasi->getIdRegistrasi() ?>">
                      <input type="hidden" name="id_proses" value="<?php if (isset($proses)){ echo $proses->getIdProses();}?>">
                      
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label lbl-color" >Nama PT:</label>
                    <div class="col-lg-8">
                      <input type="text" id="registrasi" name="namapt" class="form-control input-sm" value="<?= $nm_pti ?>">                      
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label lbl-color" >Yayasan:</label>
                    <div class="col-lg-8">
                      <input type="text" id="registrasi" name="yayasan" class="form-control input-sm" value="<?= $nm_yayasan?>">                      
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label lbl-color" >Evaluator:</label>
                    <div class="col-lg-8">
                      <input type="text" id="evaluator" name="evaluator" class="form-control input-sm" placeholder="Nama Evaluator" value="<?php if(isset($proses)){
                      	$evaluator = $proses->getEvaluator(); echo $evaluator->getNmEvaluator();}?>">
                      <input type="hidden" id="idevaluator" name="idevaluator" value="<?php if(isset($proses)){
                      	$evaluator = $proses->getEvaluator(); echo $evaluator->getIdEvaluator();}?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label lbl-color" >Jenis Evaluasi:</label>                    
                    <div class="col-lg-4">
                        <?php
                            $sel_jns_evaluasi = 0;
                            if(isset($proses)){
                                $sel_jns_evaluasi = $proses->getIdJnsEvaluasi();
                            }
                        ?>
                    <?php echo form_dropdown('jns_evaluasi', $jns_evaluasi, $sel_jns_evaluasi,'class="form-control input-sm" id="jns_evaluasi"');?>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label lbl-color" >Type Evaluator:</label>                    
                    <div class="col-lg-4">
                        <?php
                            $option_type = array('0'=>'-Pilih-','1'=>'Reviewer','2'=>'Team Teknis');
                            $selected = 0;
                            if(isset($proses)){
                                $selected = $proses->getTypeEvaluator();
                            }
                            echo form_dropdown('type', $option_type, $selected, 'class="form-control input-sm" id="type"');
                        ?>
                        <!--<input type="text" id="type" name="type" class="form-control input-sm" placeholder="Type" value="<?php if(isset($proses)){echo $proses->getTypeEvaluator();}?>">-->                                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-lg-2 control-label lbl-color" for="">Tanggal Penugasan:</label>
                    <div class="col-lg-4">
                      <input type="text" id="tglpenugasan" name="tglkirim" class="form-control input-sm" value="<?php if(isset($proses)){echo $proses->getTglKirim();}else{ echo date('Y-m-d');} ?>">                      
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label lbl-color" for="">Tanggal Selesai Penugasan:</label>
                    <div class="col-lg-4">
                      <input type="text" id="tglselesai" name="tglexpire" class="form-control input-sm" value="<?php if(isset($proses)){echo $proses->getTglExpire();}?>">                      
                    </div>
                </div>                
                <div class="form-group">
                    <label class="col-lg-2 control-label lbl-color" for="">Batch:</label>
                    <div class="col-lg-4">
                        <input type="text" id="bulan" name="batch" class="form-control input-sm" value="<?php if(isset($proses)){echo $proses->getBatch();}?>">                                           
                    </div>
                </div>

                      
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                          <button type="submit" name="save" value="save" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
                          <button class="btn btn-warning btn-sm" name="cancel" value="cancel"><i class="glyphicon glyphicon-refresh"></i> Cancel</button>                          
                    </div>
                </div>
                </fieldset>
            </form>
        </div>
	</div>
</div>    

