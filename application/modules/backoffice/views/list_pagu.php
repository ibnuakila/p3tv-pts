
<script type="text/javascript" >
$("document").ready(function(){
    $("#tglawal").datepicker({
		dateFormat:"yy-mm-dd",
                changeYear:true
    });
    
    $("#tglakhir").datepicker({
		dateFormat:"yy-mm-dd",
		changeYear:true
    });
    
    
    
    $("#filter").change(function(){
        var x = document.getElementById("filter").selectedIndex;
        var y = document.getElementById("filter").options;
        //alert(y[x].value);
        if(y[x].value==='semua'){
            $("#keyword").val("all");
        }else if(y[x].value==='jns_usulan'){
            //$("#keyword").attr("class",'complete');
        }

    });        
        
    
    $(document.body).on("click",".pleno",function()
    {
   		/*var id_reg=$(this).attr('id');
    	var status = $("#"+id_reg).is(":checked");
    	            
    	//alert(status);
        if(confirm("Anda ingin mengumumkan usulan ini ?")){			
		
			$.ajax
			({
				type: "POST",
				url: "<?php echo base_url().'backoffice/kelolaregistrasi/publishverifikasi/'?>"+id_reg+"/"+status,
				success: function(msg)
				{			
					alert(msg);
                    //$("#"+noevaluasi).Attr("checked","true");
				}
			});
                
		}else{
			if(status){
            	$("#"+noevaluasi).removeAttr("checked");
			}else{
				$("#"+noevaluasi).prop("checked", true);
			}
        }*/    	            
   	});
    
    
        
});


</script>
<script language=javascript>
function activation()
    {
        var answer = confirm("Registrasi usulan ini ?")
        if (answer){
            document.messages.submit();
        }

        return false;  
        
    };

    function deletechecked()
    {
        var answer = confirm("Hapus data terpilih ?")
        if (answer) {
            document.messages.submit();
        }

        return false;
    };
</script>
<div class="">

    <div class="md-card"><i class="glyphicon glyphicon-tag"></i>
    <h2 class="">
    Daftar Rekapitulasi Pagu
    </h2>
    
<div class="panel panel-default">
        <div class="panel-heading"><i class="glyphicon glyphicon-search"></i> Pencarian</div>
        <div class="panel-body pnl-bg">
        <form class="form-horizontal" role="form" method="post" action="<?=base_url()?>backoffice/kelolarekapitulasi/find/">    
            <fieldset>
            
            <div class="form-group">
                
                    <div class="col-lg-3">
                        <label for="filter" class="">Wilayah</label>
                        <?php 
                        	$filter = array(''=>'-Pilih-','nmpti'=>'Nama PT','nama_penyelenggara'=>'Yayasan',
                        			'id_registrasi'=>'No Registrasi','nama_status'=>'Status','all'=>'Semua');
                        	$a_filter = '';
                        	if (isset($selected_filter)){
                        		$a_filter = $selected_filter;
                        	}
                        	?>
                        <?php  echo form_dropdown('filter', $filter,$a_filter,'class="form-control input-sm" id="filter"');?>
                        
                    </div>
                
                    <div class="col-lg-4">
                        <label for="keyword" class="">Kata Kunci</label>
                        <div class="input-group">                                          
                            <input type="text" id="keyword" name="keyword" class="form-control input-sm">
                            <span class="input-group-btn">
                              <button type="submit" name="find" class="btn btn-primary btn-sm" value="find"><i class="glyphicon glyphicon-search glyphicon-white"></i> Find</button>
                              <button type="submit" name="export" id="export" class="btn btn-success btn-sm" value="export"><i class="glyphicon glyphicon-share glyphicon-white"></i> Export</button>
                            </span>
                        </div>
                    </div><!-- /input-group -->
                <!-- /.col-lg-6 -->
            </div>
                
           
            </fieldset>
        </form>    
        </div>
</div>
    


<div class="row-fluid">
    <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered">
            <thead class="tbl-head">
              <tr class="bg-success" >
                <th>#</th>
                <th class="text-center">Periode</th> 
				<th class="text-center">Nama PT</th> 
				<th class="text-center">Sub Total</th> 
				<th class="text-center">PPN 10%</th> 
                <th class="text-center">Jumlah Anggaran</th>                 
                
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>          
<?php //print_r($registrasi)?>                
<?php if(isset($rekap) && $rekap != null){ 
	$segment = $this->uri->segment(4,0);
    $user = $this->session->userdata('userid');
    $i = $segment+1;
    if($i==''){
        $i = 1;
    }
    foreach($rekap->result() as $obj){
    	$pti = new PTI($obj->kdpti);
        //$account = $reg->getAccount();
        //$yayasan = $account->getYayasan();
        //$supplier = $pack->getSupplier();
        $ppn = 0; $total_anggaran = 0; $total = 0;
        if($obj->file_rab != ''){
            $total = ($obj->total / 2);
            $ppn = $total * 0.1;
            $total_anggaran = ($obj->total / 2) + $ppn;
        }else{
            $total = $obj->total;
            $ppn = $total * 0.1;
            $total_anggaran = $obj->total + $ppn;
        }
        
        
?>
        <tr class="tbl-row <?php if($obj->file_rab != ''){echo 'warning';} ?>">
        
          <td><?=$i?></td>
          <td><?= ucfirst($obj->periode);?></td>
          <td><?= $pti->getNmPti();?></td>
          <td class="text-right"><?= number_format($total); ?></td>
          <td class="text-right"><?= number_format($ppn); ?></td>
          <td class="text-right"><?= number_format($total_anggaran); ?></td>
                     
          <td>
              <!--<a href="<?= base_url().'backoffice/#' ?>" title="Remove" onclick="return deletechecked()">
                  <i class="glyphicon glyphicon-remove"></i> </a>
			  <a href="<?= base_url().'backoffice/#' ?>" title="Edit">
                  <i class="glyphicon glyphicon-edit"></i> </a>-->
          </td>
        </tr>
<?php      $i++;
    }
}?>        
        
      </tbody>
    </table>
    </div>
    <div>
        <?php 
            //echo $this->pagination->create_links(); 
            //echo $articles->count();
        ?>
    </div>
    
</div>
</div>
</div>