/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function ()
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
    });