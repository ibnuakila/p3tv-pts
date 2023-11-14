<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste moxiemanager"
    ],
    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
});
</script>
<script type="text/javascript">
$("document").ready(function(){

	$("#approved").click(function(event){
		
		var _keterangan = tinyMCE.activeEditor.getContent();
		var _id = $("#idregistrasi").val();
		var status = '2';
		
		$.ajax({
			type: "POST",
            dataType: "json",
            url: "<?=base_url()?>backoffice/kelolaregistrasi/verifikasi",
            data: {id:_id, status:status, keterangan:_keterangan},
            success:
            function(data){
            	if(data[0].message=="true"){
                	alert("Verifikasi OK!");
	                $("#approved").attr('disabled','disabled');
	                $("#disapproved").removeAttr('disabled');
	                $("#status_ver").val(data[0].status);
            	}else{
            		alert("Verifikasi Fail!");
            	}
            }
		});
            event.preventDefault();
	});

	$("#disapproved").click(function(event){
		var _keterangan = tinyMCE.activeEditor.getContent();
		var _id = $("#idregistrasi").val();
		var status = '6';
		
		$.ajax({
			type: "POST",
            dataType: "json",
            url: "<?=base_url()?>backoffice/kelolaregistrasi/verifikasi",
            data: {id:_id, status:status, keterangan:_keterangan},
            success:
            function(data){
            	if(data[0].message=="true"){
            		alert("Verifikasi OK!");
	                $("#disapproved").attr('disabled','disabled');
	                $("#approved").removeAttr('disabled');
	                $("#status_ver").val(data[0].status);
            	}else{
            		alert("Verifikasi Fail!");
            	}
            }
		});
            event.preventDefault();
	});

	$(document.body).on("click",".view",function()
		{
            var id =$(this).attr('id');
            var src = $(this).attr("src");
            //alert(src);
            $("#pdfview").attr("src",src);
        });
});
</script>
<div class="md-card">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="glyphicon glyphicon-list"></i> Detail Registrasi</div>
			<div class="panel-body">				
			<form action="" class="form-horizontal">
			<?php 
				
				$pt = $account->getPti();
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
			<input type="hidden" id="idaccount" value="<?=$account->getIdAccount() ?>">
				<div class="form-group">
					<label for="yayasan" class="col-lg-3 control-label">Yayasan:</label>
						<div class="col-lg-6">
	                    	<input type="text" class="form-control input-sm" name="yayasan" value="<?=$nmyayasan; ?>">                                        
	                	</div>
				</div>
				<div class="form-group">
					<label for="pt" class="col-lg-3 control-label">Perguruan Tinggi:</label>
						<div class="col-lg-6">
	                    	<input type="text" class="form-control input-sm" name="pt" value="<?=$nmpt; ?>">                                        
	                	</div>
				</div>
				
				<?php if($this->sessionutility->isAdministrator()){?>
				<div class="form-group">
					<label for="pt" class="col-lg-3 control-label">Status:</label>
						<div class="col-lg-6">
	                    	<input type="text" class="form-control input-sm" name="status" id="status_ver" value="<?=$account->getAccountStatus(); ?>">
	                    	<input type="hidden" id="idstatus">                                        
	                	</div>
				</div>
				
				<div class="form-group">
					<label for="pt" class="col-lg-3 control-label"></label>
						<div class="col-lg-6">
	                    	<button class="btn btn-sm btn-success" id="approved" <?php if($account->getAccountStatus()=='1'){ echo 'disabled="disabled"';}?>>Approved</button>
	                    	<button class="btn btn-sm btn-warning" id="disapproved" <?php if($account->getAccountStatus()=='0'){ echo 'disabled="disabled"';}?>>Disapproved</button>                                        
	                	</div>
				</div>
				<?php }?>
			</form>
				<div class="container">
	            	<iframe id="pdfview" src="<?=base_url(). ($account->getFilePath()); ?>" style="width:812px; height:700px;" frameborder="0"></iframe>
	            </div>
			
			</div>
		</div>
		
		
				
			
		
