



</br>
</br>
<div class="col-sm-12">
<div class="card">
    <div class="card-header"><b><?= $title ?></b></div>
    <div class="card-body">
        <div class="btn-group">

            <a href="<?= base_url() . 'officer/officer/add' ?>"> <button  type="button" class="btn btn-warning btn-sm" ><i class="glyphicon glyphicon-file glyphicon-white"></i>  Tambah </button></a>               

        </div>  <br /> <br />
        <table class="table table-condensed table-hover table-bordered" id="datauser">
            <thead>             
                <tr class="active text-info">                  
                    <th width=10% class="text-center">User ID</th> 
                    <th width=25% class="text-center">Nama</th> 
                    <th width=20% class="text-center">Email</th>
                    <th width=10% class="text-center">Unit</th>
                    <th width=10% class="text-center">Type</th>                      
                    <th width=25% class="text-center">Aksi</th>
                </tr>
            </thead>

        </table>
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
        font-size: 10px;
        max-width: 100px;
    }

    .DTTT{
        float: right;
        margin-left: 2px;
    }

    div#datauser_filter label{
        width: 100%;
        margin-left: 160px;
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
<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>-->

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />  
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" class="init">
    /*$(document).ready(function ()
    {
        $("#datauser").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
            columns: [
                {"visible": true, "searchable": false, "sortable": false},
                {"visible": true, "searchable": true, "sortable": false},
                {"visible": true, "searchable": true, "sortable": false},
                {"visible": true, "searchable": true, "sortable": false},
                {"visible": true, "searchable": false, "sortable": false}
            ],
            ajax: {
                "url": "<?php echo base_url() ?>officer/officer/lookup",
                "type": "GET"
            },
            dom: 'T<"top"fl>rt<"bottom"ip><"clear">',
            "tableTools": {
                "sSwfPath": "../../assets/vendor/DataTables-1.10.6/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [

                ]
            },
            "columnDefs": [{
                    "targets": 5,
                    "render": function (data, type, row) {

                        return '<a class="btn btn-success btn-xs" href="<?= base_url() ?>officer/officer/edit/' + row[0] + '"><span class="glyphicon glyphicon-edit" ></span> Ubah</a>' + ' &nbsp ' +
                                '<a class="btn btn-warning btn-xs" href="<?= base_url() ?>officer/officer/hapus/' + row[0] + '"><span class="glyphicon glyphicon-trash" ></span> Hapus</a>' + ' &nbsp ' +
                                '<a class="btn btn-info btn-xs" href="<?= base_url() ?>backoffice/backoffice/loginasuser/' + row[0] + '"><span class="glyphicon glyphicon-user" ></span> Login</a>';

                    }
                }]





        });


        var status = $("#datauser").DataTable();
        $('#status').on('change', function () {   // for text boxes
            var y = $('#status').val();  // getting search input value
            status.column(4).search(y).draw();
        });
    });*/
</script>

