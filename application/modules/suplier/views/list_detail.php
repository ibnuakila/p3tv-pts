
                


	</br>
        </br>

	<div class="card mb-3">
		<div class="card-header"><b><?=$title?></b></div>
		<div class="card-body">
                      <br /> <br /> 
                    <table class="table table-condensed table-hover table-bordered" id="datapaket">
            <thead>             
              <tr class="active text-info">    
                 
                <th width=10% class="text-center">ID</th> 
                <th width=30% class="text-center">Nama PT</th> 
                <th width=20% class="text-center">Jumlah Item</th>
                <th width=10% class="text-center">Jumlah Barang</th>
                <th width=10% class="text-center">Presensi</th>                      
                <th width=20% class="text-center">Aksi</th>
              </tr>
            </thead>
            
    </table>
        </div>
	</div>
        
        <style type="text/css">

	table#datapaket th{
		font-size: 12px;
		vertical-align:top;
		background-color: #eee;
		padding:5px;
	}

	table#datapaket td{
		padding:5px;
		font-family: sans-serif;
		font-size: 11px;
		vertical-align:middle;
	}

	table#datapaket select{
		font-size: 10px;
		max-width: 100px;
	}

	.DTTT{
		float: right;
		margin-left: 250px;
	}

	div#datapaket_filter label{
		width: 100%;
		margin-left: 150px;
		text-align: right;
	}

	div#datapaket_filter input{
		width: 290px;
	} 

	div#datapaket_length{
		position: absolute;
		float: left;
	}	
	div#datapaket_status{
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
	

	select#status{
		z-index: 1;
		position: absolute;
		width: 160px;
		margin-left: 300px;
		text-align: left;
	}
</style>
        
        <script type="text/javascript" language="javascript" class="init">
$(document).ready(function()
{
	$("#datapaket").DataTable({
		processing 	: 	true,
		serverSide 	: 	true,
		responsive 	: 	true,		
		lengthMenu	: 	[[10, 30, 50,100, -1], [10, 30, 50,100, "All"]],
		columns		: 	[
							{ "visible": true, "searchable": false,  "sortable": false },
							{ "visible": true, "searchable": true,  "sortable": false  },
							{ "visible": true, "searchable": true,  "sortable": false  },
							{ "visible": true, "searchable": true, "sortable": false  },                                                                                                                       
							{ "visible": true, "searchable": false,  "sortable": false  }
						],
		ajax 		: 	{     
							"url" 	: "<?php echo base_url().'suplier/suplier/lookupdetil/'.$id ?> " ,
							"type"	: "GET"
						},
		dom 		: 'T<"top"fl>rt<"bottom"ip><"clear">',
                "tableTools": {
	            "sSwfPath": "../../assets/vendor/DataTables-1.10.6/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
	            "aButtons": [
	                    
	            ]            
	        },
                "columnDefs": [ {
	            "targets": 5,
	            "render" : function(data, type, row){	
								
							return '<a class="btn btn-warning btn-xs" href="<?=base_url()?>suplier/suplier/kirim/'+row[5]+row[0]+'"><span class="glyphicon glyphicon-edit" ></span> Kirim Barang</a>'   ;
							
                                                        }          	
	            }]        
	        
               
		 
	      

	});

	
	var status = $("#datapaket").DataTable();
	$('#status').on( 'change', function () {   // for text boxes
		var y =$('#status').val();  // getting search input value
		status.column(4).search(y).draw();
	});	
});
</script>

