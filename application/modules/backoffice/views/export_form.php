
<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
$row = $detail_paket->row();
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=".$row->namapt.".xls");
 
?>
<?php
    
?>
<h3>Lampiran Berita Acara Monitoring Hibah Barang PPPTS 2017</h3>
<h3>Yang akan dihibahkan kepada  
<?php
    $yys = new BadanPenyelenggara($row->kodept);
    $nama_yys = $yys->getNamaPenyelenggara();
    echo $nama_yys;
    
?>
</h3>
<h3>Kode PT: <?=$row->kodept; ?></h3>
<h3>Nama PT: <?=$row->namapt; ?></h3>
<table border="1" >
            <thead >
              <tr >
                <th rowspan="2">No</th>
                <th class="text-center" rowspan="2">Nama Barang</th> 
                <th class="text-center" rowspan="2">Merk/Spesifikasi</th>                           
                  
                <th class="text-center" rowspan="2">Volume</th>				                              
                <th class="text-center" colspan="2">Kesesuaian</th>
                <th class="text-center" colspan="2">Fungsi</th>
                <th class="text-center" rowspan="2">Tgl Terima</th>
                <th class="text-center" rowspan="2">Keterangan</th>
              </tr>
              <tr border="1">
                  
                  <td>Ya</td>
                  <td>Tidak</td>
                  <td>Ya</td>
                  <td>Tidak</td>
                  
              </tr>
            </thead>
            <tbody>          
                
<?php if(isset($detail_paket) && $detail_paket != null){ 
	$segment = $this->uri->segment(4,0);
    //$user = $this->session->userdata('userid');
    $i = $segment+1;
    if($i==''){
        $i = 1;
    }
    foreach($detail_paket->result() as $obj){
    	
?>
        <tr class="tbl-row">
        
          <td><?=$i?></td>
          
          <td><?= $obj->namabarang; ?></td>
          <td><?= $obj->merk.'/ '.$obj->type ?></td>          
          
          <td><?= $obj->jmlbarang ?></td>
                   
          
        </tr>
<?php      $i++;
    }
}?>        
        
      </tbody>
    </table>

<table>
    <tr></tr>
    <tr><td colspan="5">Team Monitoring Hibah Barang PPPTS 2017:</td><td>Perwakilan dari</td></tr>
    <tr><td colspan="5">KEMENTERIAN RISET, TEKNOLOGI DAN PENDIDIKAN TINGGI</td><td><?=$nama_yys ?></td></tr>
    <tr></tr>
</table>


