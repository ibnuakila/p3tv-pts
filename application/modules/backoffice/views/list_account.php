
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
    
    $("#tglawal2").datepicker({
		dateFormat:"yy-mm-dd",
                changeYear:true
    });
    
    $("#tglakhir2").datepicker({
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
        
    $("#chevrondown").click(function(){
        $("#prosesverifikasi").animate({
            height: 'togle'
        });
    });
    
    $("#proses").click(function(){
        var x= confirm("Proses data terverifikasi ?");
        if(x){
            var tgl1 = $("#tglawal2").val();
            var tgl2 = $("#tglakhir2").val();
            $.post("<?php echo base_url().'evapro/registrasiprodi/procesverification'?>",
            {
                tglawal: tgl1,
                tglakhir: tgl2
            },
            function(data, status){
                alert(data + "\nStatus: " + status);
                document.location.reload();
            });
        }
    });
    
    $("#keyword").autocomplete({
         minLength: 3,
            source: function(req, add){
                var text = $("select[name='filter'] option:selected").text();
                                    
                if(text==='Jenis Usulan'){
                    $.ajax({
                        url: '<?php echo base_url().'evapro/registrasiprodi/autocompletejenisusulan/';?>',
                        dataType: 'json',
                        type: 'POST',
                        data: req,
                        success: function(data){
                            if(data.response =='true'){
                               add(data.message);
                            }
                        }
                    });
                }
            },
            select: function(event, ui){
                var nama = ui.item.nama_usulan;
                $("#keyword").val(nama);
                //alert(kdeval);
                
        }
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
        
    }
</script>  
<div class="">

    <div class="md-card"><i class="glyphicon glyphicon-tag"></i>
    <h2 class="">
    Daftar Permintaan Account
    </h2>
    
    <div class="panel panel-default">
        <div class="panel-heading"><i class="glyphicon glyphicon-search"></i> Pencarian</div>
        <div class="panel-body pnl-bg">
        <form class="form-horizontal" role="form" method="post" action="<?=base_url()?>evapro/registrasiprodi/findpraregistrasi/">    
            <fieldset>
            
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="tglakhir" class="">Tgl Awal</label>
                    <input type="text" id="tglawal" name="tglawal" class="form-control input-sm" placeholder="yyyy-mm-dd">                
                </div>

                <div class="col-sm-2">
                    <label for="tglakhir" class="">Tgl Akhir</label>
                    <input type="text" id="tglakhir" name="tglakhir" class="form-control input-sm" placeholder="yyyy-mm-dd">

                </div>
            <!--</div>

            <div class="form-group"> 
                <!--<div class="form-group">-->
                    <div class="col-sm-3">
                        <label for="filter" class="">Kriteria Pencarian</label>
                        <?php 
                        	$filter = array(''=>'-Pilih-','nama_pt'=>'Nama PT','yayasan'=>'Yayasan','no_regis'=>'No Registrasi','status'=>'Status');
                        ?>
                        <?php  echo form_dropdown('filter', $filter,'','class="form-control input-sm" id="filter"');?>
                        <!--<select id="filter" class="form-control input-sm">
                            <option>One</option>
                            <option>Two</option>
                        </select>-->
                    </div>
                <!--</div>-->

                <!--<div class="form-group">-->
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
                <!--</div><!-- /.col-lg-6 -->
            </div>
                <h4>Total Record: <span class="label label-info"><?=$total_row?></span></h4>
           
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
                <th class="text-center">Yayasan</th> 
                <th class="text-center">Perguruan Tinggi</th>                 
                <th class="text-center">Email</th>
                <th class="text-center">Status</th>                
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>          
                
<?php if(isset($account) && $account != null){ 
	$segment = $this->uri->segment(4,0);
    $user = $this->session->userdata('userid');
    $i = $segment+1;
    if($i==''){
        $i = 1;
    }
    foreach($account->result() as $obj){
    	$acc = new Account($obj->id);
        //$account = $reg->getAccount();
        $yayasan = '';
        $pt = $acc->getPti();
        $nmpt = '';
        if(is_object($pt)){
        	$nmpt = $pt->getNmPti();
        	$yayasan = $pt->getPenyelenggara();
        }
        //$status = $reg->getStatusRegistrasi();
        $nmyayasan = '-';
        if(is_object($yayasan)){
        	$nmyayasan = $yayasan->getNamaPenyelenggara();
        }
?>
        <tr class="tbl-row">
        
          <td><?=$i?></td>
          
          <td><?= $nmyayasan ?></td>
          <td><?= $nmpt; ?></td>
          <td><?= $acc->getEmail(); ?></td>
          <td><?= $acc->getAccountStatus()?></td>           
          <td>
              <a href="<?= base_url().'backoffice/kelolaaccount/detail/'.$acc->getIdAccount()?>" title="Detail Usulan">
                  <i class="glyphicon glyphicon-list"></i> </a>
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
            echo $this->pagination->create_links(); 
            //echo $articles->count();
        ?>
    </div>
    
</div>
</div>
</div>