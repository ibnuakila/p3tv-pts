
	<div class="panel panel-success">
		<div class="panel-heading"><b><?=$title?></b></div>
		<div class="panel-body">
                     <br /> <br /> 
                     <div class="form-group" >
                        <label class="col-lg-4 control-label">Kode PT</label>
                        <div class="col-lg-6">
                        <input name="nmpti" id="nmpti" class="form-control" value="<?php 
                        $id = $row->kdpti;
                        echo $row->kdpti; ?>" type="text" readonly>
                      </div>
                    </div>
                     <div class="form-group" >
                        <label class="col-lg-4 control-label">Nama PT</label>
                        <div class="col-lg-6">
                        <input name="nmpti" id="nmpti" class="form-control" value="<?php echo $row->nmpti; ?>" type="text" readonly>
                      </div>
                    </div>
                      <div class="form-group" >
                        
                      </div>
                    </div>
                     
                    <table class="table table-striped table-bordered table-hover" id="datauser">
            <thead>             
              <tr class="active text-info">                  
                <th width=10% class="text-center">Nama Barang</th> 
                <th width=30% class="text-center">Spesifikasi</th> 
                <th width=10% class="text-center">Tgl Terima</th> 
                <th width=20% class="text-center">Jumlah Barang</th>
                <th width=10% class="text-center">Presensi</th>                                                  
              </tr>
            </thead>
            
    </table>
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
        
        <script type="text/javascript" language="javascript" class="init">
$(document).ready(function()
{
	$("#datauser").DataTable({
		processing 	: 	true,
		serverSide 	: 	true,
		responsive 	: 	true,
                "bPaginate": true,
		lengthMenu	: 	[[10, 30, 50,100, -1], [10, 30, 50,100, "All"]],
		columns		: 	[
							{ "visible": true, "searchable": true,  "sortable": true },
                                                        { "visible": true, "searchable": true,  "sortable": false  },        
							{ "visible": true, "searchable": true,  "sortable": false  },
							{ "visible": true, "searchable": true,  "sortable": false  },							                                                       
							{ "visible": true, "searchable": true,  "sortable": false  }
						],
		ajax 		: 	{
							"url" 	: "<?php echo base_url().'monitoring/monitoring/lookupdetil/'.$id ?>",
							"type"	: "GET"
						},
		dom 		: 'T<"top"fl>rt<"bottom"ip><"clear">',
                "tableTools": {
	            "sSwfPath": "../../assets/vendor/DataTables-1.10.6/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
	            "aButtons": [
	                    
	            ]            
	        },
                      
	        
               
		 
	      

	});

	
		
});
</script>




