<div class="container">

    <div class="row">

        <div class="col-md-12">

                <div class="card">

                    <div class="card-header"><h3>Anggaran : <span class='anggaran'>0</span></h3></div>
                    
                    <div class="card-body">

                        <div class="body_anggaran"></div>

                    </div>
                </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">

//var tabel = null;
$(document).ready(function() {
    /*
    $('#anggaran').DataTable({
        "processing": true,
        "responsive":true,
        "serverSide": true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": "<?php // base_url('monitoring/anggaran/data_anggaran_pt');?>", // URL file untuk proses select datanya
            "type": "POST"
        },
        "deferRender": true,
        "aLengthMenu": [[60,100],[60,100]], // Combobox Limit
        "columns": [
            {"data": 'kdpti',"sortable": true, "width": "1%", 
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }  
            },
            { "data": "nmpti" },
            { "data": "total","sortable": false},



        ],
    });*/

    /*setInterval(function(){
        var table = $('#anggaran').DataTable();
        table.ajax.reload();
    },2000);*/
          setInterval(function() { 
              //$(".anggaran").hide();
              $.ajax({
                  url: "<?= base_url('monitoring/anggaran/data_anggaran_pt');?>",
                  type: 'GET',
                  
                  success: function(msg) {
                    $('.body_anggaran').show().html(msg);
                  }
              }); 
          }, 3000);

          setInterval(function() { 
              //$(".anggaran").hide();
              $.ajax({
                  url: "<?= base_url('monitoring/anggaran/data_anggaran_total');?>",
                  type: 'GET',
                  
                  success: function(msg) {
                    $('.anggaran').show().html(msg);
                  }
              }); 
          }, 3000);

});
</script>