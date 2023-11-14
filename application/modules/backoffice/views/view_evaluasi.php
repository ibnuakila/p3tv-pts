<div class="card">
    <div class="card-header"><i class="fa fa-tag"></i></div>
    <div class="card-body">
    <h2>Hasil Penilaian</h2>

    <?php
    if (isset($evaluasi)) {
        $eva = $evaluasi->row();

        $e = new Evaluasi($eva->id_evaluasi); //$eva->current();
        $pro = $e->getProses();
        $reg = $pro->getRegistrasi();
        $pt = $reg->getPti();
        $skema = trim($reg->getSchema());
        //print_r($reg);
        //$account = $reg->getAccount();
        $yayasan = $reg->getPenyelenggara();
        //$evaluasi = $pro->getEvaluasi();
        $nmyayasan = '-';
        if (is_object($yayasan)) {
            $nmyayasan = $yayasan->getNamaPenyelenggara();
        }
        $prodi_usulan = new RegistrasiProdiUsulan();
        $res_prodi_usulan = $prodi_usulan->getBy('id_registrasi', $reg->getIdRegistrasi());
    }
    ?>
    <h4>
        <?php
        $array_evaluasi = array();
        if (isset($evaluasi)) {
            echo $nmyayasan . '</br>';
            echo $pt->getNmPti() . '</br>';
            $array_evaluasi = array();
            $i = 0;
            //echo count($evaluasi);
            foreach ($evaluasi->result() as $row) {
                $array_evaluasi[$i] = new Evaluasi($row->id_evaluasi);
                $i++;
            }
            //print_r($array_evaluasi);
        }
        ?>
    </h4>
    <hr>
    <h4>Prodi yang diusulkan:</h4>
    <div class="">
        <table class="table">
            <tr>
                <th>Nama Prodi</th>
                <th>Program</th>
            </tr>
            <?php
            if ($res_prodi_usulan->num_rows() > 0) {
                foreach ($res_prodi_usulan->result() as $prodi) {
                    echo '<tr>';
                    echo '<td>' . $prodi->nama_prodi . '</td>';
                    echo '<td>' . $prodi->jenjang . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </table>
    </div>

    <div class="table-responsive">
        <table class="mytable">
            <thead class="thead-light">
                <tr>
                    <th colspan="2">Evaluator:</th>
                    <th colspan="2">
                        <!-- evaluator 1 --> <?php
                        if (is_array($array_evaluasi) && count($array_evaluasi) > 0) {
                            $evaluasi1 = $array_evaluasi[0];
                            $evaluator1 = $evaluasi1->getEvaluator();
                            echo $evaluator1->getNmEvaluator() . ' (<mark>' . $evaluasi1->getSkor() . '</mark>)';
                            $temp_path1 = $evaluasi1->getFilePath();
                            $path1 = substr($temp_path1, 35);
                            ?> </br>
                            <a href="<?= base_url().'backoffice/kelolaevaluasi/downloadevaluasi/'.$evaluasi1->getIdEvaluasi() ?>"><i
                                    class="fa fa-download"></i>
                            </a> <?php } ?></th>
                    <th colspan="2">
                        <!-- evaluator 2 --> <?php
                        if (is_array($array_evaluasi) && count($array_evaluasi) > 1) {
                            $evaluasi2 = $array_evaluasi[1];
                            $evaluator2 = $evaluasi2->getEvaluator();
                            echo $evaluator2->getNmEvaluator() . ' (<mark>' . $evaluasi2->getSkor() . '</mark>)';
                            $temp_path2 = $evaluasi2->getFilePath();
                            $path2 = substr($temp_path2, 35);
                            ?> </br>
                            <a href="<?= base_url() . 'backoffice/kelolaevaluasi/downloadevaluasi/'.$evaluasi2->getIdEvaluasi() ?>"><i
                                    class="fa fa-download"></i>
                            </a> <?php } ?></th>

                </tr>
                <tr>
                    <td colspan="2"><b>Komentar Umum:</b>
                    </td>

                    <td colspan="2"><?php
                        if (is_array($array_evaluasi) && count($array_evaluasi) > 0) {
                            $evaluasi1 = $array_evaluasi[0];
                            echo $evaluasi1->getKeterangan();
                        }
                        ?></td>
                    <td colspan="2"><?php
                        if (is_array($array_evaluasi) && count($array_evaluasi) > 1) {
                            $evaluasi2 = $array_evaluasi[1];
                            echo $evaluasi2->getKeterangan();
                        }
                        ?></td>
                </tr>
                <tr>
                    <th>Id Bobot</th>
                    <th>Aspek</th>
                    <th>Nilai</th>
                    <th>Komentar</th>
                    <th>Nilai</th>
                    <th>Komentar</th>

                </tr>
            </thead>
            <tbody>

                <?php
                if (!empty($evaluasi1)) {
                    $nilai1 = new NilaiDetail('', '');
                    $nilai1->setIdEvaluasi($evaluasi1->getIdEvaluasi());
                    $resultnilai1 = $nilai1->get('0', '0');
                    $iteratornilai1 = $resultnilai1->getIterator();
                }
                if (!empty($evaluasi2)) {
                    $nilai2 = new NilaiDetail('', '');
                    $nilai2->setIdEvaluasi($evaluasi2->getIdEvaluasi());
                    $resultnilai2 = $nilai2->get('0', '0');
                    $iteratornilai2 = $resultnilai2->getIterator();
                }

                //print_r($resultnilai1);
                $modbobot = new BobotNilai();
                $modbobot->setPeriode(trim($reg->getPeriode()));
                //$modbobot->setAspek($skema);
                $item = $modbobot->get();
                //print_r($item);
                foreach ($item as $bobot) {
                    $bobot = new BobotNilai($bobot->getIdBobot());
                    if (!empty($evaluasi1)) {
                        $itemNilai1 = $iteratornilai1->current();
                    }
                    if (!empty($evaluasi2)) {
                        $itemNilai2 = $iteratornilai2->current();
                    }
                    ?>
                    <tr class="">
                        <td><?= $bobot->getIdBobot() ?>
                        </td>
                        <td><?= $bobot->getKeteranganAspek() ?>
                        </td>
                        <td><?php
                            if (!empty($itemNilai1)) {
                                if ($itemNilai1->getNilai() < 2.5) {
                                    echo '<mark>' . $itemNilai1->getNilai() . '</mark>';
                                } else {
                                    echo $itemNilai1->getNilai();
                                }
                            }
                            ?></td>
                        <td><?php
                            if (!empty($itemNilai1)) {
                                echo $itemNilai1->getKomentar();
                            }
                            ?></td>
                        <td><?php
                            if (!empty($itemNilai2)) {
                                if ($itemNilai2->getNilai() < 2.5) {
                                    echo '<mark>' . $itemNilai2->getNilai() . '</mark>';
                                } else {
                                    echo $itemNilai2->getNilai();
                                }
                            }
                            ?></td>
                        <td><?php
                            if (!empty($itemNilai2)) {
                                echo $itemNilai2->getKomentar();
                            }
                            ?></td>



                    </tr>
                    <?php
                    if (!empty($evaluasi1)) {
                        $iteratornilai1->next();
                    }
                    if (!empty($evaluasi2)) {
                        $iteratornilai2->next();
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
    </div>
</div>
