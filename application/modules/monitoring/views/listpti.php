<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<div class="card">
    <div class="card-header"><b><?= $title ?> </b></div>
    <div class="card-body">
        
        <div >
            <div class="col-md-4">
                <label id="statusx" >Status </label>
                <select id="status"  class="form-control">
                    <option selected value="">Semua</option>
                    <option value="0">Non Aktif</option>
                    <option value="1">Aktif</option>

                </select>

            </div>	
        </div>

        <table class="table table-striped table-bordered table-hover" id="datauser">
            <thead>             
                <tr class="active text-info">                  
                    <th width=10% class="text-center">Kode PT</th> 
                    <th width=30% class="text-center">Nama Pengusul</th> 
                    <th width=10% class="text-center">Tanggal</th> 
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
        font-size: 15px;
        max-width: 100px;
    }




    div#datauser_filter{
        width: 50%;
    }




    .DTTT{
        float: right;
        margin-left: 280px;
    }

    div#datauser_filter label{
        width: 100%;
        margin-left: 170px;
       // text-align: right;
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
        margin-left: 0px;
        text-align: left;
    }
    select#status{
        z-index: 1;
        position: absolute;
        width: 160px;
        margin-left: 70px;
        text-align: left;
    }
</style>

<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function ()
    {
        $("#datauser").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "bPaginate": true,
            lengthMenu: [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
            columns: [
                {"visible": true, "searchable": true, "sortable": true},
                {"visible": true, "searchable": true, "sortable": false},
                {"visible": true, "searchable": true, "sortable": false},
                {"visible": true, "searchable": true, "sortable": false},
                {"visible": true, "searchable": true, "sortable": false}
            ],
            ajax: {
                "url": "<?php echo base_url() ?>monitoring/monitoring/lookup",
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

                        if (row[4] == 'Tolak') {
                            return  '<a class="btn btn-danger btn-xs" target="_blank" href="../../../../site/aliaslogin?id=' + row[0] + '&admin=idc"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</a> ' +
                                    '<a class="btn btn-warning btn-xs" href="edituser/' + row[6] + '"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a> ' +
                                    '<a class="btn btn-danger btn-xs"  href="#" onclick="hapus(' + row[6] + ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a> ' +
                                    '<a class="btn btn-success btn-xs" href="/' + row[5] + '" target="_blank "><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> Lihat File</a>';
                        }
                        else {
                            return 	'<a class="btn btn-danger btn-xs" target="_blank" href="../../../../site/aliaslogin?id=' + row[0] + '&admin=idc"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</a> ' +
                                    '<a class="btn btn-warning btn-xs" href="edituser/' + row[6] + '"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a> ' +
                                    '<a class="btn btn-success btn-xs" href="/' + row[5] + '" target="_blank "><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> Lihat File</a>';

                        }


                    }
                }]





        });


        var status = $("#datauser").DataTable();
        $('#status').on('change', function () {   // for text boxes
            var y = $('#status').val();  // getting search input value
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

    $(function () {
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
        $(window).on('resize', function () {
            $('.modal:visible').each(reposition);
        });
    });
</script>

