
	<div class="panel panel-success">
		<div class="panel-heading"><b><?=$title?></b></div>
		<div class="panel-body">
                    <form class="form-horizontal">
                     <br /> <br /> 
                     <div class="form-group" >
                        <label class="col-lg-2 control-label">Kode PT</label>
                        <div class="col-lg-6">
                        <input name="nmpti" id="nmpti" class="form-control" value="<?php 
                        $id = $row->kdpti;
                        echo $row->kdpti; ?>" type="text" readonly>
                      </div>
                    </div>
                     
                                     
                     <div class="form-group" >
                        <label class="col-lg-2 control-label">Nama PT</label>
                        <div class="col-lg-6">
                        <input name="nmpti" id="nmpti" class="form-control" value="<?php echo $row->nmpti; ?>" type="text" readonly>
                      </div>
                    </div>
                      <div class="form-group" >
                        <label class="col-lg-4 control-label"></label>
                      </div>
                    
                     
                    <table class="table table-striped table-bordered table-hover" id="mydata">
            <thead>             
              <tr class="active text-info">                  
                <th width=20% class="text-center">Nama Barang</th> 
                <th width=20% class="text-center">Merk</th> 
                <th width=20% class="text-center">Type</th>                 
                <th width=10% class="text-center">Jumlah Barang</th>
                <th width=10% class="text-center">Presensi</th>                                                  
              </tr>
            </thead>
             <tbody id="show_data">
                 
            </tbody>
            
    </table>
                     </form>
                     </div>
        </div>
	</div>
        
        <style type="text/css">

	table#datauser th{
		font-size: 12px;
		vertical-align:top;
		background-color: #eee;
		padding:5px;
	}

	table#datauser td{
		padding:5px;
		font-family: sans-serif;
		font-size: 11px;
		vertical-align:middle;
	}

	table#datauser select{
		font-size: 15px;
		max-width: 100px;
	}
        
       
	

        div#datauser_filter{
		width: 50%;
	}
        
	


	.DTTT{
		float: right;
		margin-left: 250px;
	}

	div#datauser_filter label{
		width: 100%;
		margin-left: 0px;
		text-align: right;
	}

	div#datauser_filter input{
		width: 190px;
	} 

	div#datauser_length{
		position: absolute;
		float: left;
	}	
	div#datauser_status{
		position: relative;
		max-width: 200px;
	}

	.table  tr.info {
	  background-color: #eee !important;
	}

	.dataTables_wrapper .dataTables_paginate .paginate_button {
		margin-left: 0;
		padding: 0;
	}

	a.btn {
		font-size: 12px;
		font-family: sans-serif;
	}
	
        label#statusx{
            z-index: 1;
		position: absolute;
		width: 160px;
		margin-left: -400px;
		text-align: left;
        }
	select#status{
		z-index: 1;
		position: absolute;
		width: 160px;
		margin-left: -350px;
		text-align: left;
	}
</style>
        
       <script type="text/javascript">
    $(document).ready(function(){
        tampil_data_barang();   //pemanggilan fungsi tampil barang.
         
        $('#mydata').dataTable();
          
        //fungsi tampil barang  barang, spesifikasi, tgl_terima,jumlah_barang,presensi
        function tampil_data_barang(){
            $.ajax({
                type  : 'ajax',
                url   : '<?php echo base_url().'monitoring/monitoring/data_barang/'.$id ?>',
                async : false,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<tr>'+
                                '<td>'+data[i].barang+'</td>'+
                                '<td>'+data[i].merk+'</td>'+
                                '<td>'+data[i].type+'</td>'+
                                
                                '<td style="text-align:center;">'+data[i].jumlah_barang+'</td>'+ 
                                '<td style="text-align:center;">'+data[i].presensi+'</td>'+ 
                                +
                                
                                '</tr>';
                    }
                    $('#show_data').html(html);
                }
 
            });
        }
        
          //GET UPDATE
        $('#show_data').on('click','.item_hapcus',function(){
            var id=$(this).attr('data');
            $.ajax({
                type : "GET",
                url  : "<?php echo base_url()?>backoffice/berita/data_berita",
                dataType : "JSON",
                data : {id:id},
                success: function(data){
                    $.each(data,function(id_berita, judul, konten){
                        $('#ModalaEdit').modal('show');
                        $('[name="kobar_edit"]').val(data.id_berita);
                        $('[name="nabar_edit"]').val(data.judul);
                        $('[name="harga_edit"]').val(data.konten);
                    });
                }
            });
            return false;
        });
        
          //GET HAPUS
        $('#show_data').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="kode"]').val(id);
        });
 
     
 
    });
 
</script>


