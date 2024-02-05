<?php

require_once ('Icontroll.php');
//require_once APPPATH . 'third_party/PHPExcel.php';
//require_once APPPATH . 'third_party/PHPExcel/IOFactory.php';
require 'vendor/autoload.php';

/**
 * @author akil
 * @version 1.0
 * @created 26-Mar-2016 19:14:52
 */
class KelolaRegistrasi extends MX_Controller implements IControll {

    function __construct() {
        parent::__construct();
        $this->load->library('sessionutility');
        $this->load->library('WebServiceAgent');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
        $this->load->model('registrasi');
        $this->load->model('verifikasi');
        $this->load->model('periode');
        $this->load->model('dokumenperbaikan');
        $this->load->model('dokumenperbaikanupload');
        $this->load->model('rekapitulasiberitaacara');
        $this->load->model('ProdiPelaporanPddikti');
        $this->load->model('LaporanPernyataan');
        $this->load->model('LaporanCapaian');
        $this->load->model('LaporanIndikator');
        $this->load->model('Registrasiprodi');
        $this->load->model('Penanggungjawab');
        $this->load->model('Danapendamping');
        $this->load->model('Laporankemajuan');
    }

    function __destruct() {
        
    }

    public function add() {
        
    }

    public function edit() {
        
    }

    public function find() {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'list_registrasi';

            $id_registrasi = trim($this->input->post('id_registrasi'));
            $yayasan = trim($this->input->post('yayasan'));
            $pti = trim($this->input->post('pti'));
            $tgl_registrasi = trim($this->input->post('tgl_registrasi'));
            $periode = trim($this->input->post('periode'));
            $schema = trim($this->input->post('schema'));
            $status_registrasi = trim($this->input->post('status_registrasi'));
            $publish_verifikasi = trim($this->input->post('publish_verifikasi'));

            $segment = $this->uri->segment(4, 0);
            $temp_post = $this->input->post(NULL, TRUE);
            if (!$temp_post) {
                $id_registrasi = trim($this->session->flashdata('id_registrasi'));
                $yayasan = trim($this->session->flashdata('yayasan'));
                $pti = trim($this->session->flashdata('pti'));
                $tgl_registrasi = trim($this->session->flashdata('tgl_registrasi'));
                $periode = trim($this->session->flashdata('periode'));
                $status_registrasi = trim($this->session->flashdata('status_registrasi'));
                $publish_verifikasi = trim($this->session->flashdata('publish_verifikasi'));
                $schema = trim($this->session->flashdata('schema'));
            }
            $temp_filter = array(
                'id_registrasi' => $id_registrasi,
                'yayasan' => $yayasan,
                'pti' => $pti,
                'tgl_registrasi' => $tgl_registrasi,
                'periode' => $periode,
                'schema' => $schema,
                'status_registrasi' => $status_registrasi,
                'publish_verifikasi' => $publish_verifikasi
            );
            $this->session->set_flashdata($temp_filter);

            if ($this->input->post('export')) {
                $params = array(
                    'paging' => array('row' => '0', 'segment' => '0')
                );
            } else {
                $params = array(
                    'paging' => array('row' => 10, 'segment' => $segment)
                );
            }

            if ($id_registrasi != '') {
                $params['field']['registrasi.id_registrasi'] = $id_registrasi;
            }
            if ($tgl_registrasi != '') {
                $params['field']['registrasi.tgl_registrasi'] = $tgl_registrasi;
            }
            if ($schema != '') {
                $params['field']['registrasi.skema'] = $schema;
            }
            if ($periode != '') {
                $params['field']['registrasi.periode'] = $periode;
            }
            if ($status_registrasi != '') {
                $params['field']['registrasi.id_status_registrasi'] = $status_registrasi;
            }
            if ($yayasan != '') {
                $params['join']['tbl_badan_penyelenggara'] = 'registrasi.kdpti = tbl_badan_penyelenggara.kdpti';
                $params['field']['tbl_badan_penyelenggara.nama_penyelenggara'] = $yayasan;
            }
            if ($pti != '') {
                $params['join']['tbl_pti'] = 'registrasi.kdpti = tbl_pti.kdpti';
                $params['field']['tbl_pti.nmpti'] = $pti;
            }
            if ($publish_verifikasi != '') {
                $params['join']['verifikasi'] = 'registrasi.id_registrasi = verifikasi.id_registrasi';
                $params['field']['verifikasi.publish'] = $publish_verifikasi;
            }

            $registrasi = new Registrasi();
            $result_registrasi = $registrasi->search($params);

            //config pagination                     
            $per_page = 10;
            $params['count'] = array('1');
            $total_row = $registrasi->search($params);
            $base_url = base_url() . 'backoffice/kelolaregistrasi/find/';
            setPagingTemplate($base_url, 4, $total_row, $per_page);

            //data periode
            $mperiode = new Periode();
            $result_periode = $mperiode->get('0', '0');
            $option_periode = array('' => '~Pilih~');
            foreach ($result_periode->result() as $value) {
                $option_periode[$value->periode] = $value->periode;
            }
            $data['periode'] = $option_periode;

            //data status registrasi
            $mstatus_registrasi = new StatusRegistrasi();
            $result_status = $mstatus_registrasi->get('0', '0');
            $option_status = array('' => '~Pilih~');
            foreach ($result_status->result() as $value) {
                $option_status[$value->id_status_registrasi] = $value->nama_status;
            }
            $data['status_registrasi'] = $option_status;

            $skema = array('' => '-Pilih-', 'A' => 'A', 'B' => 'B', 'C' => 'C');
            //publish verifikasi
            $opt_verifikasi = array('' => '~Pilih~', 'yes' => 'Yes', 'no' => 'No');
            $data['publish_verifikasi'] = $opt_verifikasi;
            $data['skema'] = $skema;
            $data['registrasi'] = $result_registrasi;
            $data['total_row'] = $total_row;

            if ($this->input->post('export')) {
                $this->load->view('export_registrasi', $data, 'index-1');
            } else {
                showNewBackEnd('backoffice/' . $view, $data, 'index-1');
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function __index() {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'list_registrasi';
            $token = md5('service@silem');
            $registrasi = new Registrasi();
            $segment = $this->uri->segment(4, 0);
            $per_page = 10;
            $params = array(
                'paging' => array('row' => 10, 'segment' => $segment)
            );
            $periode = new Periode();
            $periode->getBy('status_periode', 'open');
            $current_periode = $periode->getOpenPeriode();
            //print_r($current_periode);
            $params['field']['registrasi.periode'] = $current_periode[0];
            $result = $registrasi->search($params);

            //data periode
            $result_periode = $periode->get('0', '0');
            $option_periode = array('' => '~Pilih~');
            foreach ($result_periode->result() as $value) {
                $option_periode[$value->periode] = $value->periode;
            }
            $data['periode'] = $option_periode;

            //data status registrasi
            $status_registrasi = new StatusRegistrasi();
            $result_status = $status_registrasi->get('0', '0');
            $option_status = array('' => '~Pilih~');
            foreach ($result_status->result() as $value) {
                $option_status[$value->id_status_registrasi] = $value->nama_status;
            }
            $data['status_registrasi'] = $option_status;

            //publish verifikasi
            $opt_verifikasi = array('' => '~Pilih~', 'yes' => 'Yes', 'no' => 'No');
            $data['publish_verifikasi'] = $opt_verifikasi;

            $skema = array('' => '-Pilih-', 'A' => 'A', 'B' => 'B', 'C' => 'C');
            //config pagination
            $params['count'] = array('1');
            $total_row = $registrasi->search($params);
            $base_url = base_url() . 'backoffice/kelolaregistrasi/index';
            setPagingTemplate($base_url, 4, $total_row, $per_page);
            $data['skema'] = $skema;
            $data['registrasi'] = $result;
            $data['total_row'] = $total_row;
            $data['token'] = $token;
            //showBackEnd($view, $data, 'index_new');
            showNewBackEnd('backoffice/' . $view, $data, 'index-1');
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function index() {
        if ($this->sessionutility->validateAccess($this)) {

            $id_registrasi = trim($this->input->post('id_registrasi'));
            $yayasan = trim($this->input->post('yayasan'));
            $pti = trim($this->input->post('pti'));
            $tgl_registrasi = trim($this->input->post('tgl_registrasi'));
            $periode = trim($this->input->post('periode'));
            //$schema = trim($this->input->post('schema'));
            $status_registrasi = trim($this->input->post('status_registrasi'));
            $publish_verifikasi = trim($this->input->post('publish_verifikasi'));
            //var_dump($temp_post);
            $segment = $this->uri->segment(4, 0);
            $temp_post = $this->input->post(NULL, TRUE);
            if (!$temp_post) {
                $id_registrasi = trim($this->session->flashdata('id_registrasi'));
                $yayasan = trim($this->session->flashdata('yayasan'));
                $pti = trim($this->session->flashdata('pti'));
                $tgl_registrasi = trim($this->session->flashdata('tgl_registrasi'));
                $periode = trim($this->session->flashdata('periode'));
                $status_registrasi = trim($this->session->flashdata('status_registrasi'));
                $publish_verifikasi = trim($this->session->flashdata('publish_verifikasi'));
                //$schema = trim($this->session->flashdata('schema'));
            }
            $flash_data = array(
                'id_registrasi' => $id_registrasi,
                'yayasan' => $yayasan,
                'pti' => $pti,
                'tgl_registrasi' => $tgl_registrasi,
                'periode' => $periode,
                //'schema' => $schema,
                'status_registrasi' => $status_registrasi,
                'publish_verifikasi' => $publish_verifikasi
            );
            $this->session->set_flashdata($flash_data);
            $mperiode = new Periode();
            $current_periode = $mperiode->getOpenPeriode();
            //print_r($current_periode);

            $params = [];
            if ($this->input->post('export')) {
                $params['paging'] = ['row' => 0, 'segment' => 0];
            } else {
                $params['paging'] = ['row' => 10, 'segment' => $segment];
            }
            $table = 'registrasi';
            $params['field'][$table . '.periode'] = ['=' => $current_periode[0]];
            if ($id_registrasi != '') {
                $params['field'][$table . '.id_registrasi'] = ['=' => $id_registrasi];
            }
            if ($tgl_registrasi != '') {
                $params['field'][$table . '.tgl_registrasi'] = ['=' => $tgl_registrasi];
            }
            /* if($schema != ''){                
              $params['field'][$table.'.skema'] = ['=' => $schema];
              } */
            if ($periode != '') {
                $params['field'][$table . '.periode'] = ['=' => $periode];
            }
            if ($status_registrasi != '') {
                $params['field'][$table . '.id_status_registrasi'] = ['=' => $status_registrasi];
            }
            if ($yayasan != '') {
                $params['join']['tbl_badan_penyelenggara'] = ['INNER' => $table . '.kdpti = tbl_badan_penyelenggara.kdpti'];
                $params['field']['tbl_badan_penyelenggara.nama_penyelenggara'] = ['LIKE' => $yayasan];
            }
            if ($pti != '') {
                $params['join']['tbl_pti'] = ['INNER' => $table . '.kdpti = tbl_pti.kdpti'];
                $params['field']['tbl_pti.nmpti'] = ['LIKE' => $pti];
            }
            if ($publish_verifikasi != '') {
                $params['join']['verifikasi'] = ['INNER' => $table . '.id_registrasi = verifikasi.id_registrasi'];
                $params['field']['verifikasi.publish'] = ['=' => $publish_verifikasi];
            }
            $params['order'][$table . '.tgl_registrasi'] = 'DESC';
            $registrasi = new Registrasi();
            $result = $registrasi->getResult($params);
            //configure pagination
            $params['count'] = true;
            //print_r($result);
            $total_row = $registrasi->getResult($params);
            $base_url = base_url() . 'backoffice/kelolaregistrasi/index/';
            $uri_segment = '4';
            $per_page = 10;
            //setPagingTemplate($base_url, $uri_segment, $total_row);
            setPagingTemplate($base_url, $uri_segment, $total_row, $per_page);
            //data periode
            $mperiode = new Periode();
            $result_periode = $mperiode->get('0', '0');
            $option_periode = array('' => '~Pilih~');
            foreach ($result_periode->result() as $value) {
                $option_periode[$value->periode] = $value->periode;
            }
            $data['periode'] = $option_periode;

            //data status registrasi
            $mstatus_registrasi = new StatusRegistrasi();
            $result_status = $mstatus_registrasi->get('0', '0');
            $option_status = array('' => '~Pilih~');
            foreach ($result_status->result() as $value) {
                $option_status[$value->id_status_registrasi] = $value->nama_status;
            }
            $data['status_registrasi'] = $option_status;

            $skema = array('' => '-Pilih-', 'A' => 'A', 'B' => 'B', 'C' => 'C');
            //publish verifikasi
            $opt_verifikasi = array('' => '~Pilih~', 'yes' => 'Yes', 'no' => 'No');
            $data['publish_verifikasi'] = $opt_verifikasi;
            $data['skema'] = $skema;
            $data['registrasi'] = $result;
            $data['total_row'] = $total_row;
            $view = 'list_registrasi';
            add_footer_js('js/app/index_registrasi.js');
            if ($this->input->post('export')) {
                //$this->load->view('list_prodi_registrasi_excell.php',$data);
            } else {
                showNewBackEnd('backoffice/' . $view, $data, 'index-1');
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function remove() {
        if ($this->sessionutility->validateAccess($this)) {
            
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function detail($id_reg) {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'detail_registrasi';
            $registrasi = new Registrasi($id_reg);
            $kode_pt = $registrasi->getKdPti();
            //echo 'kodepti: '.$kode_pt.'</br>';
            $prodi_pelaporan = new ProdiPelaporanPddikti();
            //$return = $prodi_pelaporan->getBy('kdpti', $kode_pt);
            $dana = new DanaPendamping();
            $params = [];
            $params['paging'] = ['row' => 0, 'segment' => 0];
            $params['field'][DanaPendamping::table . '.id_registrasi'] = ['=' => $id_reg];
            $res_dana = $dana->getResult($params);

            $prodi_pelaporan->setKdPti($kode_pt);
            $prodi = $prodi_pelaporan->get('0', '0');
            //var_dump($prodi);
            //$pts = [];
            //$prodi = [];
            //$data['pts'] = $pts;
            $data['data_prodi'] = $prodi;
            $data['registrasi'] = $registrasi;
            $data['danas'] = $res_dana;
            add_footer_js('tinymce/tinymce.min.js');
            add_footer_js('js/app/registrasi.js');
            showNewBackEnd('backoffice/' . $view, $data, 'index-1');
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function save() {
        $this->load->model('ModUserActivity');
        $userid = strtoupper($this->session->userdata('userid'));
        $acc = 0;
        $user = new ModUsers($userid);
        $access = new ModSubSystemModule('');
        $access->setUserId($user->getUserId());
        $subsysmodule = $access->getObjectList('', '');
        $uri = explode('/', $this->uri->uri_string());
        $class = get_class($this);
        if (($subsysmodule->num_rows()) > 0) {
            echo 'count:' . ($subsysmodule->num_rows()) . '</br>';
            foreach ($subsysmodule as $value) {
                $systemodule = new ModSystemModule($value->getModuleId());
                if ($systemodule->getModuleName() == $class) {
                    if (count($uri) <= 2) {
                        if ($value->getSubModuleName() == 'index') {
                            $acc = 1;
                            break;
                        }
                    } elseif (strtolower($value->getSubModuleName()) == strtolower($uri[2])) {
                        $acc = 1;
                        echo 'access type: ' . $value->getAccessTypeId() . '</br>';
                        if ($value->getAccessTypeId() == '1' ||
                                $value->getAccessTypeId() == '3' ||
                                $value->getAccessTypeId() == '4') {
                            echo 'access type: ' . $value->getAccessTypeId() . '</br>';
                            $userActivity = new ModUserActivity('');
                            $userActivity->m_ModUsers = new ModUsers($userid);
                            $qrystring = $this->uri->uri_string();
                            $userActivity->setModuleAccessed($qrystring);
                            $userActivity->settimeAccessed(date('c'));
                            $userActivity->insert();
                        }
                        break;
                    }
                }
            }
        }
        echo 'access is: ' . $acc;
    }

    public function verifikasi() {
        if ($this->sessionutility->validateAccess($this)) {
            $id_registrasi = trim($this->input->post('id'));
            $status = trim($this->input->post('status'));
            $keterangan = trim($this->input->post('keterangan'));

            $registrasi = new Registrasi($id_registrasi);
            $status_reg = $registrasi->getStatusRegistrasi();
            $verifikasi = new Verifikasi($id_registrasi);

            //$data = '';
            $response = '';
            if ($verifikasi->getIdRegistrasi() == '') {//insert
                $verifikasi->setIdRegistrasi($id_registrasi);
                $verifikasi->setIdStatusRegistrasi($status);
                $verifikasi->setKeterangan($keterangan);
                $verifikasi->setTglVerifikasi(date('Y-m-d'));
                $verifikasi->setPublish('no');
                if ($verifikasi->insert()) {
                    $registrasi->setIdStatusRegistrasi($status);
                    //$registrasi->update();
                    $response = 'true';
                } else {
                    $response = 'false';
                }
            } else {
                $verifikasi->setIdRegistrasi($id_registrasi);
                $verifikasi->setIdStatusRegistrasi($status);
                $verifikasi->setKeterangan($keterangan);
                $verifikasi->setTglVerifikasi(date('Y-m-d'));
                $verifikasi->setPublish('no');
                if ($verifikasi->update()) {
                    $registrasi->setIdStatusRegistrasi($status);
                    //$registrasi->update();
                    $response = 'true';
                } else {
                    $response = 'false';
                }
            }

            $status_registrasi = new StatusRegistrasi($status);
            $data[0] = array('message' => $response, 'status' => $status_registrasi->getNamaStatus());

            echo json_encode($data);
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function publishVerifikasi() {
        if ($this->sessionutility->validateAccess($this)) {
            $id_registrasi = $this->input->post('id_reg');
            $status = $this->input->post('status');
            $registrasi = new Registrasi($id_registrasi);
            $verifikasi = $registrasi->getVerifikasi();
            $status_verifikasi = $verifikasi->getIdStatusRegistrasi();
            if ($status == 'true') {
                $registrasi->setIdStatusRegistrasi($status_verifikasi);
                $registrasi->setPenugasan('0');
                $verifikasi->setPublish('yes');
                $verifikasi->update();
                $result = $registrasi->update();
            } else {
                $registrasi->setIdStatusRegistrasi('1');
                $registrasi->setPenugasan('0');
                $verifikasi->setPublish('no');
                $verifikasi->update();
                $result = $registrasi->update();
            }
            if ($result) {
                echo "Verifikasi Ok";
            } else {
                echo "Verifikasi Gagal";
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function updateDocument($idupload, $status) {
        if ($this->sessionutility->validateAccess($this)) {
            $dokumen_reg = new DokumenRegistrasi($idupload);
            $label = '';
            if ($status == 'true') {
                $dokumen_reg->setVerifikasi('y');
                $label = 'Verified';
            } else {
                $dokumen_reg->setVerifikasi('n');
                $label = 'Unverified';
            }
            $dokumen_reg->update();
            echo $label;
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function exportVerifikasi($id_registrasi) {
        $registrasi = new Registrasi($id_registrasi);
        $verifikasi = new Verifikasi($id_registrasi);
        $pti = new Pti($registrasi->getKdPti());
        $dokumen = new Dokumen();
        $result_dokumen = $dokumen->get('0', '0');
        $dokumen_registrasi = new DokumenRegistrasi();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("pppts.ristekdikti.go.id")
                ->setLastModifiedBy("Admin")
                ->setTitle("Verifikasi")
                ->setSubject("Laporan Hasil Verifikasi");
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0);
        //header
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'FM.DESK-01');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'DOKUMEN ADMINISTRASI');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'DESK EVALUATION PROGRAM PEMBINAAN PTS');
        //data pts
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Nama PT: ' . $pti->getNmPti());
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Kopertis: ');
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Nama Reviewer: ');
        $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Institusi Asal Reviewer:');
        $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Tanggal Evaluasi:' . $verifikasi->getTglVerifikasi());
        //tabel nilai            
        $objPHPExcel->getActiveSheet()->setCellValue('A11', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B11', 'Dokumen');
        $objPHPExcel->getActiveSheet()->setCellValue('C11', 'Panduan Skor');
        $objPHPExcel->getActiveSheet()->setCellValue('E11', 'Skor');
        $objPHPExcel->getActiveSheet()->setCellValue('F11', 'Nilai');
        $objPHPExcel->getActiveSheet()->setCellValue('G11', 'Informasi Dari Lampiran');
        $objPHPExcel->getActiveSheet()->setCellValue('C12', '1');
        $objPHPExcel->getActiveSheet()->setCellValue('D12', '0');

        $row = 13;
        $no = 1;
        foreach ($result_dokumen->result() as $obj) {
            $dokumen_registrasi->getByArray(array('id_registrasi' => $registrasi->getIdRegistrasi(), 'id_form' => $obj->id_form));
            $dokumen = $dokumen_registrasi->getDokumen();
            $hasil_verify = $dokumen_registrasi->verifikasi;
            $skor = '';
            if ($hasil_verify == 'y') {
                $skor = '1';
            } else {
                $skor = '0';
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A' . strval($row), $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . strval($row), $dokumen->getFormName());

            $objPHPExcel->getActiveSheet()->setCellValue('C' . strval($row), 'Ada 100%');
            $objPHPExcel->getActiveSheet()->setCellValue('D' . strval($row), 'Tidak Ada atau < 100%');

            $objPHPExcel->getActiveSheet()->setCellValue('E' . strval($row), $skor);
            $row++;
            $no++;
        }

        //formating the look
        //merge cells
        //title
        $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');

        $objPHPExcel->getActiveSheet()->mergeCells('A5:B5');
        $objPHPExcel->getActiveSheet()->mergeCells('A6:B6');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:B7');
        $objPHPExcel->getActiveSheet()->mergeCells('A8:B8');
        $objPHPExcel->getActiveSheet()->mergeCells('A9:B9');
        //table head
        $objPHPExcel->getActiveSheet()->mergeCells('C11:D11');
        $objPHPExcel->getActiveSheet()->mergeCells('A11:A12');
        $objPHPExcel->getActiveSheet()->mergeCells('B11:B12');
        $objPHPExcel->getActiveSheet()->mergeCells('E11:E12');
        $objPHPExcel->getActiveSheet()->mergeCells('F11:F12');
        $objPHPExcel->getActiveSheet()->mergeCells('G11:G12');

        //fonts
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);

        //auto column width and alignment
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //border
        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
                'inside' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A11:G' . $row)->applyFromArray($styleThinBlackBorderOutline);

        //shading
        $objPHPExcel->getActiveSheet()->getStyle('A11:G12')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ), 'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('argb' => 'd5d8c5')
                    )
                )
        );

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $pti->getNmPti() . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function testApiPddikti() {
        $kode = '044163';
        $ws_agent = new WebServiceAgent();
        $website_link = $ws_agent->getByKodePt($kode);
        $pt = $ws_agent->getDetailPt($website_link);
        print_r($pt);
        echo '<hr>';
        $prodi = $ws_agent->getDetailPtProdi($website_link);
        for ($i = 0; $i < count($prodi); $i++) {
            //print_r($prodi[$i]);
            $rasio_list = $prodi[$i]['rasio_list'];
            $id_sms = $prodi[$i]['id_sms'];
            echo $id_sms . ' | ' . $prodi[$i]['kode_prodi'] . ' | ' . $prodi[$i]['nm_lemb'] . ' | ' . $prodi[$i]['jenjang'];
            echo '</br>';
            for ($j = 0; $j < count($rasio_list); $j++) {
                print_r($rasio_list[$j]);
                echo '</br>';
            }
            echo '<hr>';
        }
    }

    public function getDataPddikti($kdpti) {
        $ws_agent = new WebServiceAgent();
        $website_link = $ws_agent->getByKodePt($kdpti);
        $pts = $ws_agent->getDetailPt($website_link);
        $data_prodi = $ws_agent->getDetailPtProdi($website_link);

        print_r($data_prodi);
        if (count($data_prodi) > 0) {
            echo 'Nama PT: ' . ($pts['nm_lemb']) . '</br>';

            for ($i = 0; $i < count($data_prodi); $i++) {
                $rasio_list = $data_prodi[$i]['rasio_list'];
                for ($j = 0; $j < count($rasio_list); $j++) {
                    echo $data_prodi[$i]['nm_lemb'] . ' | ' .
                    $data_prodi[$i]['jenjang'] . ' | ' .
                    $rasio_list[$j]['semester'] . ' | ' .
                    $rasio_list[$j]['mahasiswa'] . ' | ' .
                    $rasio_list[$j]['dosen'] . ' | ' .
                    $rasio_list[$j]['dosenNidn'] . '</br>';
                    $prodi = new ProdiPelaporanPddikti();
                    $prodi->setKdPti($kdpti);
                    $prodi->setKdProdi($data_prodi[$i]['kode_prodi']);
                    $prodi->setNamaProdi($data_prodi[$i]['nm_lemb']);
                    $prodi->setJenjang($data_prodi[$i]['jenjang']);
                    $prodi->setSemester($rasio_list[$j]['semester']);
                    $prodi->setMahasiswa($rasio_list[$j]['mahasiswa']);
                    $prodi->setDosen($rasio_list[$j]['dosen']);
                    $prodi->setDosenNidn($rasio_list[$j]['dosenNidn']);
                    if (!$prodi->isExist()) {
                        $prodi->insert();
                    }
                }
            }
        }
    }

    public function downloadLaporanPernyataan($id_registrasi) {
        $this->load->helper('download');
        $laporan_pernyataan = new LaporanPernyataan($id_registrasi);
        if ($laporan_pernyataan->getId() != '') {
            $path = $laporan_pernyataan->getFilePath();
            if (is_file($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $name = 'laporan_pernyataan' . $ext;
                //echo 'name: '.$name;
                force_download($name, $data);
            } else {
                $temp_path = '/home/pppts/frontends/frontend/web/' . $path;
                if (is_file($path)) {
                    $ext = pathinfo($temp_path, PATHINFO_EXTENSION);
                    $data = file_get_contents($temp_path);
                    $name = 'laporan_pernyataan' . $ext;
                    //echo 'name: '.$name;
                    force_download($name, $data);
                } else {
                    echo 'File not found!';
                }
            }
        }
    }

    public function downloadLaporanCapaian($id_registrasi) {
        $laporan_capaian = new LaporanCapaian();

        $laporan_capaian->setIdRegistrasi($id_registrasi);
        $result = $laporan_capaian->get('0', '0');
        $thn = date("Y");
        $bln = date("M");
        $temp_file_path_excel = '/home/pppts/frontends/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/' . $bln . '/';
        if (!is_dir($temp_file_path_excel)) {
            mkdir($temp_file_path_excel, 0777, true);
        }
        //var_dump($result);
        if ($result->num_rows() > 0) {
            $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("ppptv-pts.kemdikbud.go.id")
                    ->setLastModifiedBy("Admin")
                    ->setTitle("Form Monitoring PPPTV-PTS")
                    ->setSubject("Laporan Monitoring PPPTV-PTS");
            // Add some data
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Indikator Kinerja');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Baseline');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Target');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Tahun');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Program Pengembangan');
            $r = 2;
            $no = 0;
            foreach ($result->result() as $row) {
                $indikator = new LaporanIndikator($row->indikator_id);
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $r, ++$no);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $r, $indikator->getIndikator());
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $r, $row->baseline);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $r, $row->target);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $r, $row->tahun);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $r, '-');

                //$objPHPExcel->getActiveSheet()->getStyle('D' . $r)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                //$objPHPExcel->getActiveSheet()->getStyle('E' . $r)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                //$objPHPExcel->getActiveSheet()->getStyle('F' . $r)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $r++;
            }
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

            //download
            // Redirect output to a client’s web browser (Excel2007)
            //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data.xls"');
            //header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            //header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            //header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            //header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            //header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            //header('Pragma: public'); // HTTP/1.0
            //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
            //$objWriter->save($temp_file_path_excel.'data.xlsx');
            $objWriter->save('php://output');
        } else {
            echo '<script>';
            echo 'alert("Data tidak tersedia !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function downloadBuktiLuaran($id) {
        $this->load->helper('download');
        $dana = new DanaPendamping($id);
        $registrasi = new Registrasi($dana->id_registrasi);
        if ($dana->id != '') {
            $path = $dana->bukti_luaran;
            if (is_file($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $name = 'Bukti_Luaran_' . $registrasi->getKdPti() . $ext;
                //echo 'name: '.$name;
                //force_download($name, $data);
            } else {
                $temp_path = '/home/pppts/frontends/frontend/web/' . $path;
                //echo 'path: '.$temp_path;
                if (is_file($temp_path)) {
                    $ext = pathinfo($temp_path, PATHINFO_EXTENSION);
                    $data = file_get_contents($temp_path);
                    $name = 'Bukti_Luaran_' . $registrasi->getKdPti() .'.'. $ext;
                    //echo 'name: '.$name;
                    force_download($name, $data);
                } else {
                    echo '<script>';
                    echo 'alert("File/ Dokumen tidak tersedia !");';
                    echo 'window.history.back(1);';
                    echo '</script>';
                }
            }
        }
    }
    
    public function downloadLaporanKemajuan($id_registrasi) {
        $this->load->helper('download');
        $lap = new Laporankemajuan($id_registrasi);
        $registrasi = new Registrasi($id_registrasi);
        if ($lap->id != '') {
            $path = $lap->filePath;
            if (is_file($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $name = 'Laporan_Kemajuan_' . $registrasi->getKdPti() .'.'. $ext;
                //echo 'name: '.$name;
                //force_download($name, $data);
            } else {
                $temp_path = '/home/pppts/frontends/frontend/web/' . $path;
                //echo 'path: '.$temp_path;
                if (is_file($temp_path)) {
                    $ext = pathinfo($temp_path, PATHINFO_EXTENSION);
                    $data = file_get_contents($temp_path);
                    $name = 'Laporan_Kemajuan_' . $registrasi->getKdPti() .'.'. $ext;
                    //echo 'name: '.$name;
                    force_download($name, $data);
                } else {
                    echo '<script>';
                    echo 'alert("File/ Dokumen tidak tersedia !");';
                    echo 'window.history.back(1);';
                    echo '</script>';
                }
            }
        }
    }
    
    public function downloadLaporanAkhir($id) {
        $this->load->helper('download');
        $this->db->select('*'); $this->db->from('laporan_akhir');$this->db->where('id_registrasi', $id);
        $res_file_dp = $this->db->get();
        $row = $res_file_dp->row();
        $registrasi = new Registrasi($row->id_registrasi);
        if ($row->id != '') {
            $path = $lap->filePath;
            if (is_file($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                if($row->tipe_file == 'pdf'){
                    $name = 'Surat_Pernyataan' . $registrasi->getKdPti() .'.'. $ext;
                }else{
                    $name = 'Laporan_akhir_' . $registrasi->getKdPti() .'.'. $ext;
                }
                //echo 'name: '.$name;
                //force_download($name, $data);
            } else {
                $temp_path = '/home/pppts/frontends/frontend/web/' . $path;
                //echo 'path: '.$temp_path;
                if (is_file($temp_path)) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    if($row->tipe_file == 'pdf'){
                        $name = 'Surat_Pernyataan' . $registrasi->getKdPti() .'.'. $ext;
                    }else{
                        $name = 'Laporan_akhir_' . $registrasi->getKdPti() .'.'. $ext;
                    }
                    force_download($name, $data);
                } else {
                    echo '<script>';
                    echo 'alert("File/ Dokumen tidak tersedia !");';
                    echo 'window.history.back(1);';
                    echo '</script>';
                }
            }
        }
    }
}

?>