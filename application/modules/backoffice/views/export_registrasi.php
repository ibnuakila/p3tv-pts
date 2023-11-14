
<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=exported_data.xls");
 
?>
<table class="table table-condensed table-striped table-bordered">
            <thead class="tbl-head">
              <tr class="bg-success" >
                <th>#</th>
                <th class="text-center">Id Registrasi</th> 
                <th class="text-center">Yayasan</th> 
                <th class="text-center">Perguruan Tinggi</th>                 
                <th class="text-center">Tgl Registrasi</th>
                <th class="text-center">Status</th>                
                <th class="text-center">Publish</th>
                
              </tr>
            </thead>
            <tbody>          
<?php //print_r($registrasi)?>                
<?php if(isset($registrasi) && $registrasi != null){ 
	$segment = $this->uri->segment(4,0);
    $user = $this->session->userdata('userid');
    $i = $segment+1;
    if($i==''){
        $i = 1;
    }
    foreach($registrasi->result() as $obj){
    	$reg = new Registrasi($obj->id_registrasi);
        //$account = $reg->getAccount();
        //$yayasan = $account->getYayasan();
        $pt = $reg->getPti();
        $yayasan = $reg->getPenyelenggara();
        $status = $reg->getStatusRegistrasi();
        $nmyayasan = '-';
        if(is_object($yayasan)){
        	$nmyayasan = $yayasan->getNamaPenyelenggara();
        }        
        $publish = 'no';
        $verifikasi = $reg->getVerifikasi();
        $isVerified = '';
        //print_r($verifikasi);
        if(is_object($verifikasi)){
        	$publish = $verifikasi->getPublish();
                
            if($verifikasi->getIdRegistrasi()!=''){
                $isVerified = 'Verified';
            }else{
                
            }
        }
        
        
?>
        <tr class="tbl-row">
        
          <td><?=$i?></td>
          <td><?= '\''.$obj->id_registrasi?></td>
          <td><?= $nmyayasan ?></td>
          <td><?= $pt->getNmPti(); ?></td>
          <td><?= $reg->getTglRegistrasi(); ?></td>
          <td><?php            
                echo $status->getNamaStatus();
            ?></td>
          <td>
          	<?php 
                if($publish=='yes'){
                    	echo 'Yes';
          		}elseif($isVerified!=''){
          			echo 'Verified';
          		}else{
          			echo 'No';
          		}?>
          </td>
                     
          
        </tr>
<?php      $i++;
    }
}?>        
        
      </tbody>
    </table>