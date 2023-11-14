
	<div class="panel panel-success">
		<div class="panel-heading"><b><?=$title?></b></div>
		<div class="panel-body">
                     <br /> <br /> 
                    <table class="table table-striped table-bordered table-hover" id="datauser">
            <thead>             
              <tr class="active text-info">                  
                <th width=10% class="text-center">ID</th> 
                <th width=40% class="text-center">Nama Pengusul</th> 
                <th width=20% class="text-center">Email</th>
                <th width=10% class="text-center">Status</th>                                   
                <th width=20% class="text-center">Aksi</th>
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
		font-size: 10px;
		max-width: 100px;
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
		width: 290px;
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
	$("#datauser").DataTable({
		processing 	: 	true,
		serverSide 	: 	true,
		responsive 	: 	true,
                "bPaginate": true,
		lengthMenu	: 	[[5,10, 30, 50,100, -1], [5,10, 30, 50,100, "All"]],
		columns		: 	[
							{ "visible": true, "searchable": false,  "sortable": false },
							{ "visible": true, "searchable": true,  "sortable": false  },
							{ "visible": true, "searchable": true,  "sortable": false  },							                                                       
							{ "visible": true, "searchable": false,  "sortable": false  }
						],
		ajax 		: 	{
							"url" 	: "<?php echo base_url() ?>monitoring/monitoring/lookup",
							"type"	: "GET"
						},
		dom 		: 'T<"top"fl>rt<"bottom"ip><"clear">',
                "tableTools": {
	            "sSwfPath": "../../assets/vendor/DataTables-1.10.6/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
	            "aButtons": [
	                    
	            ]            
	        },
                "columnDefs": [ {
	            "targets": 4,
	            "render" : function(data, type, row){	
								
							if(row[3]=='aktif') {  
								return 		'<a class="btn btn-warning btn-xs" href="edituser/'+row[0]+'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a> '+
										'<a class="btn btn-danger btn-xs"  href="#" onclick="hapus('+row[0]+')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a> ';
							}
							else {  
								return 		'<a class="btn btn-warning btn-xs" href="edituser/'+row[0]+'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a> '+
										'<a class="btn btn-danger btn-xs"  href="#" onclick="hapus('+row[0]+')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a> '+
										'<a class="btn btn-success btn-xs" href="/' +row[4]+'" target="_blank "><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> Lihat File</a>';

							}

							
                                                        }          	
	            }]        
	        
               
		 
	      

	});

	
	var status = $("#datauser").DataTable();
	$('#status').on( 'change', function () {   // for text boxes
		var y =$('#status').val();  // getting search input value
		status.column(4).search(y).draw();
	});	
});
</script>


<!-- Modal Hapus -->
    <div class="modal fade" id="modalHapus"  tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Keluar</span></button>
                    <h4 class="modal-title" id="modalHapusLabel">Hapus User Pengusul</h4>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin akan menghapus user pengusul ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <a href="#" onclick="ok()" class="btn btn-danger danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
var globalId;

$('#modalHapus').on('show', function () {

    });

    function hapus(id) {
        globalId = id;
        $('#modalHapus').data('id', id).modal('show');
    }

    function ok() {
        var url = "hapus/" + globalId;
        window.location.href = url;
    }
    
    $(function() {
    function reposition() {
        var modal = $(this),
            dialog = modal.find('.modal-dialog');
        modal.css('display', 'block');
        
        // Dividing by two centers the modal exactly, but dividing by three 
        // or four works better for larger screens.
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
    }
    // Reposition when a modal is shown
    $('.modal').on('show.bs.modal', reposition);
    // Reposition when the window is resized
    $(window).on('resize', function() {
        $('.modal:visible').each(reposition);
    });
});
</script>

