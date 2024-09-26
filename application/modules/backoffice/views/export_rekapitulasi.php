
<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=exported_data.xls");
 
?>
<table class="table table-condensed table-striped table-bordered">
            <thead class="tbl-head">
              <tr class="active" >
                <th>#</th>
                <th class="text-center">Yayasan</th> 
                <th class="text-center">Perguruan Tinggi</th>                           
                <th class="text-center">Tgl Rekap</th>                
                <th class="text-center">Status</th>
                <th class="text-center">Nilai Total</th>				                              
                
              </tr>
            </thead>
            <tbody>          
                
<?php if(isset($rekapitulasi) && $rekapitulasi != null){ 
	$segment = $this->uri->segment(4,0);
    $user = $this->session->userdata('userid');
    $i = $segment+1;
    if($i==''){
        $i = 1;
    }
    foreach($rekapitulasi->result() as $obj){
    	$eva = new Rekapitulasi($obj->id_rekapitulasi);
    	//$pro = $eva->getProses();
    	$reg = $eva->getRegistrasi();
    	$pt = $reg->getPti();
    	//print_r($reg);
        //$account = $reg->getAccount();
    	$yayasan = $reg->getPenyelenggara();
        //$evaluasi = $pro->getEvaluasi();
    	$nmyayasan = '-';
        if(is_object($yayasan)){
        	$nmyayasan = $yayasan->getNamaPenyelenggara();
        } 
        
        $status = $eva->getStatusRegistrasi();
        $stat_eval = '';
        $skor = '';
        if (is_object($eva)){
        	$stat = $eva->getStatusRegistrasi();
        	$stat_eval = $stat->getNamaStatus();
        	$skor = $eva->getNilaiTotal();
        }
        //$evaluator = new Evaluator($pro->getIdEvaluator());
?>
        <tr class="tbl-row <?php if($skor>'300'){ echo 'success';}else{ echo 'warning';}?>">
        
          <td><?=$i?></td>
          
          <td><?= $nmyayasan; ?></td>
          <td><?= $pt->getNmPti(); ?></td>
          
          <td><?= $eva->getTglRekap()?></td>
          
          <td><?= $status->getNamaStatus() ?></td>
          <td><?= $skor ?></td>
                   
          
        </tr>
<?php      $i++;
    }
}?>        
        
      </tbody>
    </table>