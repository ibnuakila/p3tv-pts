<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<div class="col-sm-12">
    <div class="card">
        <div class="panel panel-success">
            <div class="panel-heading"><b><?= $title ?></b></div>
            <div class="panel-body">
                <br>
                <div class="form-group">
                    <div class="row">
                        <label for="nmpti" class="col-lg-2 control-label" style="padding-left: 40px;">Kode PT</label>
                        <div class="col-lg-6">
                            <input name="nmpti" id="nmpti" class="form-control" value="<?php echo $row->kdpti; ?>" type="text" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label for="nmpti" class="col-lg-2 control-label" style="padding-left: 40px;">Nama PT</label>
                        <div class="col-lg-6">
                            <input name="nmpti" id="nmpti" class="form-control" value="<?php echo $row->nmpti; ?>" type="text" readonly>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div> 
    <div class="card">  
        <table class="table table-striped table-bordered table-hover" id="datauser">
            <thead>             
                <tr class="active text-info">                  
                    <th width=20% class="text-center">Nama Barang</th> 
                    <th width=20% class="text-center">Merk</th> 
                    <th width=20% class="text-center">Type</th>                 
                    <th width=10% class="text-center">Jumlah Barang</th>
                    <th width=10% class="text-center">Presensi</th>                                                  
                </tr>
            </thead>
 <tbody>
        <!-- Loop through the 'barang' array to add rows barang,spesifikasi, jumlah_barang, presensi ,merk,type -->  
        <?php  foreach ($barang as $item) { ?>
            <tr>
                <td class="text-center"><?php echo $item->barang ?></td>
                <td class="text-center"><?php echo $item->merk ?></td>
                <td class="text-center"><?php echo $item->type ?></td> 
                <td class="text-center"><?php echo $item->jumlah_barang ?></td>
                <td class="text-center"><?php echo $item->presensi ?></td>
            </tr>
        <?php } ?>
    </tbody>

        </table>

    </div>
</div>




