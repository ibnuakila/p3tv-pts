<?php
$luaran = new LuaranProgram();
$param_luaran['paging'] = ['row' => 0, 'segment' => 0];
$param_luaran['field'][LuaranProgram::table.'.id_registrasi'] = ['=' => $registrasi->getIdRegistrasi()];
$result = $luaran->getResult($param_luaran);
?>
<div class="table-responsive">
    <h3>Luaran Program</h3>
    <table class="mytable">
        <thead>
            <tr class="">
                <th>#</th>
                <th class="text-center">Nama Prodi</th>
                <th class="text-center">Ruang Lingkup</th>
                <th class="text-center">Program Pengembangan</th>
                <th class="text-center">Bentuk Luaran</th>
                <th class="text-center">Jumlah Luaran</th>
                <th class="text-center">Tahun</th>
                <th class="text-center">Waktu Pelaksanaan</th>
                <th class="text-center">Biaya</th>
                <th class="text-center">Target IKU</th>
                <th class="text-center">Realisasi</th>
                <th class="text-center">File Bukti</th>
                <th class="text-center">Kuitansi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($result) && $result->num_rows() > 0) {
                $i = 1;
                foreach ($result->result() as $row) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row->nama_prodi ?></td>
                        <td><?= $row->ruang_lingkup ?></td>
                        <td><?= $row->program_pengembangan ?></td>
                        <td><?= $row->bentuk_luaran ?></td>
                        <td><?= $row->jumlah_luaran ?></td>
                        <td><?= $row->tahun ?></td>
                        <td><?= $row->waktu_pelaksanaan ?></td>
                        <td><?= $row->biaya ?></td>
                        <td><?= $row->target_iku ?></td>
                        <td><?= $row->real_keuangan ?></td>
                        <td>
                            <?php
                                $lapKemajuan = new Laporankemajuan();
                                $paramKemajuan['paging'] = ['row' => 0, 'segment' => 0];
                                $paramKemajuan['field'][Laporankemajuan::table.'.luaran_program_id'] = ['=' => $row->id];
                                $resLapKemajuan = $lapKemajuan->getResult($paramKemajuan);  
                                if ($resLapKemajuan->num_rows() > 0) {
                                    foreach( $resLapKemajuan->result() as $row) {?>
                                        <ul>
                                            <li>
                                            <a href="<?=base_url()?>backoffice/kelolaluaran/downloadbukti/<?=$row->id?>"><?=$row->nama_dokumen?></a>
                                            </li>
                                        </ul>                                           
                                <?php
                                    }
                                }else{
                                    echo '-';
                                }
                            ?>
                        </td>
                        <td></td>
                    </tr>
            <?php $i++;
                }
            }
            ?>
        </tbody>
    </table>
</div>