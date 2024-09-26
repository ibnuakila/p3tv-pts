
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
        
    
    /*$(document.body).on("click",".pleno",function()
    {
   		var id_reg=$(this).attr('id');
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
        }    	            
   	});*/
    
    
        
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
        
    }
</script>  
<div class="">

    <div class="md-card"><i class="glyphicon glyphicon-tag"></i>
    <h2 class="">
    Detail Paket Barang
    </h2>
    
 

<div class="row-fluid">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-responsive" id="tbl_detail">
                    <thead class="tbl-head">
                        <tr class="bg-success" >
                            <th class="text-center">No</th> 
                            <th class="text-center">ID Registrasi</th> 
                            <th class="text-center">No Kontrak</th>
                            <th class="text-center">Nama PT</th> 
                            <th class="text-center">Nama Barang</th>                 
                            <th class="text-center">Merk</th>
                            <th class="text-center">Type</th>                
                            <th class="text-center">Volume</th>
                            <th class="text-center">Biaya Kirim</th>
                            <th class="text-center">HPS</th>
                            <th class="text-center">Jumlah Terkirim</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($detail_paket) && $detail_paket->num_rows()>0){
                                $no_kontrak = $paket->getNoKontrak();
                                $i=1;
                                foreach ($detail_paket->result() as $row){
                        ?>
                        <tr class="<?php if($no_kontrak==$row->no_kontrak){ echo 'active';}?>">
                            <td><?= $i;?></td>
                            <td><?= $row->id_registrasi; ?></td>
                            <td><?= $row->no_kontrak;?></td>
                            
                            <?php
                                $registrasi = new Registrasi($row->id_registrasi);
                                $pti = $registrasi->getPti();
                                $barang = new Barang($row->id_item);
                            ?>
                            <td><?= $pti->getNmPti(); ?></td>
                            <td><?= $barang->getNmBarang(); ?></td>
                            <td><?= $row->merk; ?></td>
                            <td><?= $row->type; ?></td>
                            <td><?= $row->volume; ?></td>
                            <td><?= $row->biaya_kirim; ?></td>
                            <td><?= $row->hps; ?></td>
                            <td><?= $row->volume_kirim; ?></td>
                            <td><?php if($row->status==0 || $row->status==''){ ?>
                                <a href=""><i class="glyphicon glyphicon-gift" title="Packing"></i></a>
                            <?php }elseif($row->status==1){ ?>
                                <a href=""><i class="glyphicon glyphicon-plane" title="Dikirim"></i></a>
                            <?php }else{ ?>
                                <a href=""><i class="glyphicon glyphicon-ok-sign" title="Diterima"></i></a>
                            <?php } ?>
                            </td>
                        </tr>
                                <?php   $i++;
                                }
                            }
                        ?>
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