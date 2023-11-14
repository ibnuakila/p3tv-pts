<?php

require_once ('Icontroll.php');
//require_once APPPATH . 'third_party/PHPExcel.php';
//require_once APPPATH . 'third_party/PHPExcel/IOFactory.php';
require 'vendor/autoload.php';

//use PhpOffice\phpexcel\PHPExcel;
use PhpOffice\PhpSpreadsheet\IOFactory; //PhpOffice\PhpSpreadsheet\Spreadsheet\src\PhpSpreadsheet\IOFactory;

/**
 * @author akil
 * @version 1.0
 * @created 26-Mar-2016 19:15:09
 */
class KelolaEvaluasi extends MX_Controller implements IControll {

    private $objRegistrasi;
    private $objProses;

    function __construct() {
        parent::__construct();
        $this->load->library('sessionutility');
        $this->load->library('form_validation');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
        $this->load->model('registrasi');
        $this->load->model('proses');
        $this->load->model('evaluasi');
        $this->load->model('nilaidetail');
        $this->load->model('evaluatorevaluasi');
        $this->load->model('evaluasiproses');
        $this->load->model('bobotnilai');
        $this->load->model('evaluasirekapitulasi');
        $this->load->model('rekapitulasi');
        $this->load->model('rekapitulasiberitaacara');
        $this->load->model('itemhibah');
        $this->load->model('barang');
        $this->load->model('gedung');
        $this->load->model('kategori');
        $this->load->model('subkategori');
        $this->load->model('periode');
        $this->load->model('registrasiprodiusulan');
        $this->load->model('dokumenpresentasi');
        $this->load->model('dokumenperbaikanupload');
    }

    function __destruct() {
        
    }

    public function add() {
        $view = 'form_entry_evaluasi';
        $id_reg = $this->uri->segment(4, 0);
        $id_proses = $this->uri->segment(5, 0);
        $registrasi = new Registrasi($id_reg);
        $proses = new Proses($id_proses);
        $proses->setIdStatusProses('2'); //proses penilaian
        $proses->setTglTerima(date('Y-m-d'));
        $proses->update();
        $jns_usulan = substr($registrasi->getJnsUsulan(), 1, 1);
        $qry = "SELECT * FROM tbl_direktorat_aktif WHERE status='Aktif'";
        $res_query = $this->db->query($qry);
        $direktorat = '';
        if ($res_query->num_rows() > 0) {
            $row = $res_query->row();
            if ($row->nama_direktorat == 'Akademik') {
                $direktorat = 'akademik';
            } else {
                $direktorat = 'vokasi';
            }
        }
        if ($proses->getTypeEvaluator() == '1') {//reviewer
            $sql = "SELECT * FROM dokumen_presentasi_baru " .
                    "WHERE bagian = '" . $direktorat . "' " .
                    "AND jns_usulan LIKE '%" . $jns_usulan . "%' " .
                    "AND aktor = 'Reviewer' " .
                    "AND periode = '" . $registrasi->getPeriode() . "'" .
                    "AND id_jns_file IN('1') " .
                    "AND id_jns_file NOT IN (" .
                    "SELECT id_jns_file FROM rekapitulasi_berita_acara WHERE id_registrasi = '" . $registrasi->getIdRegistrasi() . "')";

            $sql_check1 = "SELECT * FROM rekapitulasi_berita_acara WHERE id_registrasi = '" . $registrasi->getIdRegistrasi() . "' " .
                    "AND id_jns_file = 8";

            $sql_check2 = "SELECT * FROM rekapitulasi_berita_acara WHERE id_registrasi = '" . $registrasi->getIdRegistrasi() . "' " .
                    "AND id_jns_file = 8";
            //$temp_result = $this->db->query($sql2);
            //if($temp_result->num_rows()>0){
            //}else{
            //}

            $result = $this->db->query($sql);
        } else {
            $sql = "SELECT * FROM dokumen_presentasi_baru " .
                    "WHERE bagian = '" . $direktorat . "' " .
                    "AND jns_usulan LIKE '%" . $jns_usulan . "%' " .
                    "AND aktor = 'Tim Teknis' " .
                    "AND periode = '" . $registrasi->getPeriode() . "'" .
                    "AND id_jns_file IN('2','3','4','5') " .
                    "AND id_jns_file NOT IN (" .
                    "SELECT id_jns_file FROM rekapitulasi_berita_acara WHERE id_registrasi = '" . $registrasi->getIdRegistrasi() . "')";

            $result = $this->db->query($sql);
        }

        $opt_dokumen = array('' => '-Pilih-');
        foreach ($result->result() as $value) {
            $opt_dokumen[$value->id . '_' . $value->id_jns_file] = $value->nama_file;
        }
        $data['opt_dokumen'] = $opt_dokumen;
        $data['registrasi'] = $registrasi;
        $data['flagInsert'] = 'true';
        $data['id_proses'] = $id_proses;
        showNewBackEnd($view, $data, 'index-1');
    }

    public function edit() {
        $view = 'form_entry_evaluasi';
        $id_reg = $this->uri->segment(4, 0);
        $id_proses = $this->uri->segment(5, 0);
        $registrasi = new Registrasi($id_reg);
        $proses = new Proses($id_proses);
        $jns_usulan = substr($registrasi->getJnsUsulan(), 1, 1);
        $qry = "SELECT * FROM tbl_direktorat_aktif WHERE status='Aktif'";
        $res_query = $this->db->query($qry);
        $direktorat = '';
        if ($res_query->num_rows() > 0) {
            $row = $res_query->row();
            if ($row->nama_direktorat == 'Akademik') {
                $direktorat = 'akademik';
            } else {
                $direktorat = 'vokasi';
            }
        }
        if ($proses->getTypeEvaluator() == '1') {//reviewer
            $sql = "SELECT * FROM dokumen_presentasi_baru " .
                    "WHERE bagian = '" . $direktorat . "' " .
                    "AND jns_usulan LIKE '%" . $jns_usulan . "%' " .
                    "AND aktor = 'Reviewer' " .
                    "AND periode = '" . $registrasi->getPeriode() . "'" .
                    "AND id_jns_file IN('1') " .
                    "AND id_jns_file NOT IN (" .
                    "SELECT id_jns_file FROM rekapitulasi_berita_acara WHERE id_registrasi = '" . $registrasi->getIdRegistrasi() . "')";

            $sql_check1 = "SELECT * FROM rekapitulasi_berita_acara WHERE id_registrasi = '" . $registrasi->getIdRegistrasi() . "' " .
                    "AND id_jns_file = 8";

            $sql_check2 = "SELECT * FROM rekapitulasi_berita_acara WHERE id_registrasi = '" . $registrasi->getIdRegistrasi() . "' " .
                    "AND id_jns_file = 8";
            //$temp_result = $this->db->query($sql2);
            //if($temp_result->num_rows()>0){
            //}else{
            //}

            $result = $this->db->query($sql);
        } else {
            $sql = "SELECT * FROM dokumen_presentasi_baru " .
                    "WHERE bagian = '" . $direktorat . "' " .
                    "AND jns_usulan LIKE '%" . $jns_usulan . "%' " .
                    "AND aktor = 'Tim Teknis' " .
                    "AND periode = '" . $registrasi->getPeriode() . "'" .
                    "AND id_jns_file IN('2','3','4','5','7','15') " .
                    "AND id_jns_file NOT IN (" .
                    "SELECT id_jns_file FROM rekapitulasi_berita_acara WHERE id_registrasi = '" . $registrasi->getIdRegistrasi() . "')";

            $result = $this->db->query($sql);
        }

        $opt_dokumen = array('0' => '-Pilih-');
        foreach ($result->result() as $value) {
            $opt_dokumen[$value->id] = $value->nama_file;
        }
        $data['opt_dokumen'] = $opt_dokumen;
        $data['registrasi'] = $registrasi;
        $data['flagInsert'] = 'false';
        $data['id_proses'] = $id_proses;
        showNewBackEnd($view, $data, 'index-1');
    }

    public function find() {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'list_rekapitulasi';

            $keyword = $this->input->post('keyword');
            $filter = $this->input->post('filter');
            $fdate = $this->input->post('tglawal');
            $ldate = $this->input->post('tglakhir');
            //echo $filter.','.$this->input->post('export');
            $uri_segment = '0';
            $segment = '0';
            $temp_post = $this->input->post(NULL, TRUE);
            if (!$temp_post) {
                $keyword = trim($this->session->flashdata('keyword'));
                $filter = trim($this->session->flashdata('filter'));
                $fdate = trim($this->session->flashdata('fdate'));
                $ldate = trim($this->session->flashdata('ldate'));
            }
            $temp_filter = array(
                'keyword' => $keyword,
                'filter' => $filter,
                'fdate' => $fdate,
                'ldate' => $ldate,
            );
            $this->session->set_flashdata($temp_filter);

            $rekapitulasi = new Rekapitulasi();
            $rekapitulasi->setIdStatusRegistrasi('0');
            //$segment = $this->uri->segment(4,0);
            $per_page = 20;
            $total_row = 0;
            $result = '';
            //echo $filter;
            if ($this->input->post('export')) {
                //echo 'is export</br>';
                if ($filter == 'nmpti') {
                    $result = $rekapitulasi->getByRelated('tbl_pti', $filter, $keyword, $per_page, $segment);
                } elseif ($filter == 'nama_penyelenggara') {
                    $result = $rekapitulasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword, $per_page, $segment);
                } elseif ($filter == 'id_registrasi') {
                    $result = $rekapitulasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
                } elseif ($filter == 'nama_status') {
                    $rekapitulasi->setIdStatusRegistrasi('');
                    $result = $rekapitulasi->getByRelated('status_registrasi', $filter, $keyword, $per_page, $segment);
                    $total_row = $rekapitulasi->getByRelated('status_registrasi', $filter, $keyword);
                } elseif ($filter == 'periode') {
                    $result = $rekapitulasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
                } elseif ($filter == 'all') {
                    $result = $rekapitulasi->get('0', '0');
                }
            } else {
                //echo 'is record</br>';
                if ($filter == 'nmpti') {
                    $result = $rekapitulasi->getByRelated('tbl_pti', $filter, $keyword, $per_page, $segment);
                    $total_row = $rekapitulasi->getByRelated('tbl_pti', $filter, $keyword);
                } elseif ($filter == 'nama_penyelenggara') {
                    $result = $rekapitulasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword, $per_page, $segment);
                    $total_row = $rekapitulasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword);
                } elseif ($filter == 'id_registrasi') {
                    $result = $rekapitulasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
                    $total_row = $rekapitulasi->getByRelated('registrasi', $filter, $keyword);
                } elseif ($filter == 'nama_status') {
                    $result = $rekapitulasi->getByRelated('status_registrasi', $filter, $keyword, $per_page, $segment);
                    $total_row = $rekapitulasi->getByRelated('status_registrasi', $filter, $keyword);
                } elseif ($filter == 'periode') {
                    $result = $rekapitulasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
                    $total_row = $rekapitulasi->getByRelated('registrasi', $filter, $keyword);
                } elseif ($filter == 'all') {
                    $result = $rekapitulasi->get($per_page, $segment);
                }
            }

            $base_url = base_url() . 'backoffice/kelolaevaluasi/find/' . $filter . '/' . $keyword . '/';
            setPagingTemplate($base_url, 4, $total_row, $per_page);
            $data['rekapitulasi'] = $result;
            $data['total_row'] = $total_row;
            $data['selected_filter'] = $filter;
            if ($this->input->post('export')) {
                $this->load->view('export_rekapitulasi', $data);
                //print_r($result);
            } else {
                add_footer_css('jquery-ui-1.12.1/jquery-ui.css');
                add_footer_js('jquery-ui-1.12.1/jquery-ui.js');
                showBackEnd($view, $data, 'index_new');
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function _index() {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'list_rekapitulasi';
            $u_id = $this->session->userdata('userid');
            $user = new ModUsers();
            $id_eva = $user->getIdEvaluator();
            $evaluasi = new Rekapitulasi();
            $segment = $this->uri->segment(4, 0);
            $per_page = 10;
            //$result = '';
            $total_row = 0;

            $periode = new Periode();
            $periode->getBy('status_periode', 'open');
            $current_periode = $periode->getOpenPeriode();

            //$evaluasi->setPeriode($current_periode[0]);
            $result = $evaluasi->get($per_page, $segment);
            $total_row = $evaluasi->get();

            $base_url = base_url() . 'backoffice/kelolaevaluasi/index';
            setPagingTemplate($base_url, 4, $total_row, $per_page);
            $data['rekapitulasi'] = $result;
            $data['total_row'] = $total_row;
            add_footer_css('jquery-ui-1.12.1/jquery-ui.css');
            add_footer_js('jquery-ui-1.12.1/jquery-ui.js');
            showBackEnd($view, $data, 'index_new');
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
            //$jns_usulan = trim($this->input->post('jns_usulan'));
            $evaluator = trim($this->input->post('evaluator'));
            $status_proses = trim($this->input->post('status_proses'));

            $segment = $this->uri->segment(4, 0);
            $temp_post = $this->input->post(NULL, TRUE);
            if (!$temp_post) {
                $id_registrasi = trim($this->session->flashdata('id_registrasi'));
                $yayasan = trim($this->session->flashdata('yayasan'));
                $pti = trim($this->session->flashdata('pti'));
                $jns_usulan = trim($this->session->flashdata('jns_usulan'));
                $evaluator = trim($this->session->flashdata('evaluator'));
                $status_proses = trim($this->session->flashdata('status_proses'));
            }
            $temp_filter = array(
                'id_registrasi' => $id_registrasi,
                'yayasan' => $yayasan,
                'pti' => $pti,
                //'jns_usulan' => $jns_usulan,
                'evaluator' => $evaluator,
                'status_proses' => $status_proses
            );
            $this->session->set_flashdata($temp_filter);

            $evaluasi = new Evaluasi();
            $periode = new Periode();
            $current_periode = $periode->getOpenPeriode();

            $params = [];
            if ($this->input->post('export')) {
                $params['paging'] = ['row' => 0, 'segment' => 0];
            } else {
                $params['paging'] = ['row' => 10, 'segment' => $segment];
            }
            $table = 'evaluasi';
            $params['join']['evaluasi_proses'] = ['INNER' => $table . '.id_evaluasi=evaluasi_proses.id_evaluasi'];
            $params['join']['proses'] = ['INNER' => 'proses.id_proses=evaluasi_proses.id_proses'];
            $params['join']['proses_registrasi'] = ['INNER' => 'proses.id_proses=proses_registrasi.id_proses'];
            $params['join']['registrasi'] = ['INNER' => 'registrasi.id_registrasi=proses_registrasi.id_registrasi'];
            $params['field']['registrasi.periode'] = ['=' => $current_periode[0]];
            if ($id_registrasi != '') {
                $params['field']['registrasi.id_registrasi'] = ['=' => $id_registrasi];
            }
            if ($yayasan != '') {
                $params['join']['tbl_badan_penyelenggara'] = ['INNER' => 'registrasi.kdpti = tbl_badan_penyelenggara.kdpti'];
                $params['field']['tbl_badan_penyelenggara.nama_penyelenggara'] = ['LIKE' => $yayasan];
            }
            if ($pti != '') {
                $params['join']['tbl_pti'] = ['INNER' => 'registrasi.kdpti = tbl_pti.kdpti'];
                $params['field']['tbl_pti.nmpti'] = ['LIKE' => $pti];
            }
            /* if ($jns_usulan != '') {
              $params['field']['registrasi.jns_usulan'] = $jns_usulan;
              } */
            if ($evaluator != '') {
                $params['join']['evaluator'] = ["INNER" => "proses.id_evaluator = evaluator.id_evaluator"];
                $params['field']['evaluator.nm_evaluator'] = ['LIKE' => $evaluator];
            }

            if ($status_proses != '') {
                $params['join']['status_proses'] = ["INNER" => "proses.id_status_proses = status_proses.id_status_proses"];
                $params['field']['status_proses.id_status_proses'] = ['=' => $status_proses];
            }
            $params['order'][$table . '.tgl_evaluasi'] = 'DESC';
            /* $user = new ModUsers($this->session->userdata('userid'));
              if($user->getIdEvaluator()!=''){
              $params['field']['proses.id_evaluator'] = ['=' => $user->getIdEvaluator()];
              $params['field']['proses.id_status_proses'] = ['IN' => ['1','2']];
              } */

            $result_evaluasi = $evaluasi->getResult($params);

            //config pagination                     
            $per_page = 10;
            $params['count'] = True;
            $total_row = $evaluasi->getResult($params);
            $base_url = base_url() . 'backoffice/kelolaevaluasi/index/';
            setPagingTemplate($base_url, 4, $total_row, $per_page);

            //data status
            $obj_status_registrasi = new StatusRegistrasi();
            $result_status = $obj_status_registrasi->get('0', '0');
            $option_status = array('' => '~Pilih~');
            foreach ($result_status->result() as $value) {
                $option_status[$value->id_status_registrasi] = $value->nama_status;
            }
            $obj_status_proses = new StatusProses();
            $result_status_proses = $obj_status_proses->get('0', '0');
            $option_status_proses = array('' => '~Pilih~');
            foreach ($result_status_proses->result() as $value) {
                $option_status_proses[$value->id_status_proses] = $value->nama_status;
            }
            $data['status_evaluasi'] = $option_status;
            $data['status_proses'] = $option_status_proses;
            $data['evaluasi'] = $result_evaluasi;
            $data['total_row'] = $total_row;
            $data['base_url'] = $base_url;
            $data['title'] = 'Daftar Hasil Evaluasi (Admin)';

            if ($this->input->post('export')) {
                $this->load->view('export_proses', $data);
                //print_r($result);
            } else {
                $view = 'list_evaluasi';
                add_footer_js('js/app/index_evaluasi.js');
                showNewBackEnd($view, $data, 'index-1');
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function indexEvaluator() {
        if ($this->sessionutility->validateAccess($this)) {
            $id_registrasi = trim($this->input->post('id_registrasi'));
            $yayasan = trim($this->input->post('yayasan'));
            $pti = trim($this->input->post('pti'));
            //$jns_usulan = trim($this->input->post('jns_usulan'));
            $evaluator = trim($this->input->post('evaluator'));
            $status_proses = trim($this->input->post('status_proses'));

            $segment = $this->uri->segment(4, 0);
            $temp_post = $this->input->post(NULL, TRUE);
            if (!$temp_post) {
                $id_registrasi = trim($this->session->flashdata('id_registrasi'));
                $yayasan = trim($this->session->flashdata('yayasan'));
                $pti = trim($this->session->flashdata('pti'));
                $jns_usulan = trim($this->session->flashdata('jns_usulan'));
                $evaluator = trim($this->session->flashdata('evaluator'));
                $status_proses = trim($this->session->flashdata('status_proses'));
            }
            $temp_filter = array(
                'id_registrasi' => $id_registrasi,
                'yayasan' => $yayasan,
                'pti' => $pti,
                //'jns_usulan' => $jns_usulan,
                'evaluator' => $evaluator,
                'status_proses' => $status_proses
            );
            $this->session->set_flashdata($temp_filter);

            $evaluasi = new Evaluasi();
            $periode = new Periode();
            $current_periode = $periode->getOpenPeriode();

            $params = [];
            if ($this->input->post('export')) {
                $params['paging'] = ['row' => 0, 'segment' => 0];
            } else {
                $params['paging'] = ['row' => 10, 'segment' => $segment];
            }
            $table = 'evaluasi';
            $params['join']['evaluasi_proses'] = ['INNER' => $table . '.id_evaluasi=evaluasi_proses.id_evaluasi'];
            $params['join']['proses'] = ['INNER' => 'proses.id_proses=evaluasi_proses.id_proses'];
            $params['join']['proses_registrasi'] = ['INNER' => 'proses.id_proses=proses_registrasi.id_proses'];
            $params['join']['registrasi'] = ['INNER' => 'registrasi.id_registrasi=proses_registrasi.id_registrasi'];
            $params['field']['registrasi.periode'] = ['=' => $current_periode[0]];
            if ($id_registrasi != '') {
                $params['field']['registrasi.id_registrasi'] = ['=' => $id_registrasi];
            }
            if ($yayasan != '') {
                $params['join']['tbl_badan_penyelenggara'] = ['INNER' => 'registrasi.kdpti = tbl_badan_penyelenggara.kdpti'];
                $params['field']['tbl_badan_penyelenggara.nama_penyelenggara'] = ['LIKE' => $yayasan];
            }
            if ($pti != '') {
                $params['join']['tbl_pti'] = ['INNER' => 'registrasi.kdpti = tbl_pti.kdpti'];
                $params['field']['tbl_pti.nmpti'] = ['LIKE' => $pti];
            }
            /* if ($jns_usulan != '') {
              $params['field']['registrasi.jns_usulan'] = $jns_usulan;
              } */
            if ($evaluator != '') {
                $params['join']['evaluator_evaluasi'] = ['INNER' => $table . '.id_evaluasi=evaluator_evaluasi.id_evaluasi'];
                $params['join']['evaluator'] = ["INNER" => "evaluator_evaluasi.id_evaluator = evaluator.id_evaluator"];
                $params['field']['evaluator.nm_evaluator'] = ['LIKE' => $evaluator];
            }

            if ($status_proses != '') {
                $params['join']['status_proses'] = ["INNER" => "proses.id_status_proses = status_proses.id_status_proses"];
                $params['field']['status_proses.id_status_proses'] = ['=' => $status_proses];
            }
            $params['order'][$table . '.tgl_evaluasi'] = 'DESC';
            $user = new ModUsers($this->session->userdata('userid'));
            if ($user->getIdEvaluator() != '') {
                $params['join']['evaluator_evaluasi'] = ['INNER' => $table . '.id_evaluasi=evaluator_evaluasi.id_evaluasi'];
                $params['field']['evaluator_evaluasi.id_evaluator'] = ['=' => $user->getIdEvaluator()];
                //$params['field']['proses.id_status_proses'] = ['IN' => ['1','2']];
            }

            $result_evaluasi = $evaluasi->getResult($params);

            //config pagination                     
            $per_page = 10;
            $params['count'] = True;
            $total_row = $evaluasi->getResult($params);
            $base_url = base_url() . 'backoffice/kelolaevaluasi/indexevaluator/';
            setPagingTemplate($base_url, 4, $total_row, $per_page);

            //data status
            $obj_status_registrasi = new StatusRegistrasi();
            $result_status = $obj_status_registrasi->get('0', '0');
            $option_status = array('' => '~Pilih~');
            foreach ($result_status->result() as $value) {
                $option_status[$value->id_status_registrasi] = $value->nama_status;
            }
            $obj_status_proses = new StatusProses();
            $result_status_proses = $obj_status_proses->get('0', '0');
            $option_status_proses = array('' => '~Pilih~');
            foreach ($result_status_proses->result() as $value) {
                $option_status_proses[$value->id_status_proses] = $value->nama_status;
            }
            $data['status_evaluasi'] = $option_status;
            $data['status_proses'] = $option_status_proses;
            $data['evaluasi'] = $result_evaluasi;
            $data['total_row'] = $total_row;
            $data['base_url'] = $base_url;
            $data['title'] = 'Daftar Hasil Evaluasi (Evaluator)';

            if ($this->input->post('export')) {
                $this->load->view('export_proses', $data);
                //print_r($result);
            } else {
                $view = 'list_evaluasi';
                add_footer_js('js/app/index_evaluasi.js');
                showNewBackEnd($view, $data, 'index-1');
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function findEvaluator() {
        //if ($this->sessionutility->validateAccess($this)) {
        $view = 'list_evaluasi';

        $keyword = $this->input->post('keyword');
        $filter = $this->input->post('filter');
        $fdate = $this->input->post('tglawal');
        $ldate = $this->input->post('tglakhir');
        //echo $filter.','.$this->input->post('export');
        $uri_segment = '0';
        $segment = '0';
        $u_id = $this->session->userdata('userid');
        $user = new ModUsers($u_id);
        $evaluator = new Evaluator($user->getIdEvaluator());
        if ($keyword == '') {//next page
            $keyword = str_replace('%20', ' ', $this->uri->segment(5));
            if ($filter != 'all') {//with date
                $filter = $this->uri->segment(4);
                $keyword = str_replace('%20', ' ', $this->uri->segment(5));
                $fdate = $this->uri->segment(6);
                $ldate = $this->uri->segment(7);
                $uri_segment = '8';
                $segment = $this->uri->segment(8);
            }
        } elseif ($filter == 'all') {
            if ($fdate == '' && $ldate == '') {
                $fdate = date("Y") . '-01-01';
                $ldate = date("Y-m-d");
            }
        }
        $evaluasi = new Evaluasi();
        $evaluasi->setEvaluator($evaluator);
        //$rekapitulasi->setIdStatusRegistrasi('0');
        //$segment = $this->uri->segment(4,0);
        $per_page = 20;
        $total_row = 0;
        $result = '';
        //echo $filter;
        //echo 'is record</br>';
        if ($filter == 'nmpti') {
            $result = $evaluasi->getByRelated('tbl_pti', $filter, $keyword, $per_page, $segment);
            $total_row = $evaluasi->getByRelated('tbl_pti', $filter, $keyword);
        } elseif ($filter == 'nama_penyelenggara') {
            $result = $evaluasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword, $per_page, $segment);
            $total_row = $evaluasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword);
        } elseif ($filter == 'id_registrasi') {
            $result = $evaluasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
            $total_row = $evaluasi->getByRelated('registrasi', $filter, $keyword);
        } elseif ($filter == 'nama_status') {
            $result = $evaluasi->getByRelated('status_registrasi', $filter, $keyword, $per_page, $segment);
            $total_row = $evaluasi->getByRelated('status_registrasi', $filter, $keyword);
        } elseif ($filter == 'all') {
            $result = $evaluasi->get($per_page, $segment);
        }


        $base_url = base_url() . 'backoffice/kelolaevaluasi/findevaluator/' . $filter . '/' . $keyword . '/';
        setPagingTemplate($base_url, 4, $total_row, $per_page);
        $data['evaluasi'] = $result;
        $data['total_row'] = $total_row;
        $data['selected_filter'] = $filter;
        if ($this->input->post('export')) {
            $this->load->view('export_rekapitulasi', $data);
            //print_r($result);
        } else {
            showBackEnd($view, $data, 'index_new');
        }
        /* } else {
          echo '<script>';
          echo 'alert("Validation Fail !");';
          echo 'window.history.back(1);';
          echo '</script>';
          } */
    }

    public function remove() {
        
    }

    public function removeDokumen() {
        $id = $this->uri->segment(4);
        $id_registrasi = $this->uri->segment(5);
        $rekap_ba = new RekapitulasiBeritaAcara($id);
        $rekap_ba->delete();
        redirect(base_url() . 'backoffice/kelolaproses/detaildocument/' . $id_registrasi);
    }

    public function save() {
        if ($this->sessionutility->validateAccess($this)) {
            if ($this->input->post('save')) {
                $this->form_validation->set_rules('idregistrasi', 'Registrasi', 'required|numeric');
                $this->form_validation->set_rules('jns_evaluasi', 'Jenis Evaluasi', 'required|numeric');
                $this->form_validation->set_rules('jns_file', 'Jenis Dokumen', 'required');
                //$this->form_validation->set_rules('userfile', 'File', 'required');

                $idregistrasi = $this->input->post('idregistrasi');
                $jns_evaluasi = $this->input->post('jns_evaluasi');
                $type_evaluator = $this->input->post('type_evaluator');
                $id_proses = $this->input->post('id_proses');
                $final = $this->input->post('final');
                $jns_file = $this->input->post('jns_file');
                if ($this->form_validation->run() == FALSE) {
                    $error = trim(strip_tags(validation_errors()));
                    echo '<script>';
                    echo 'alert("Warning! '.$error.'");';
                    echo 'window.history.back(1);';
                    echo '</script>';
                }else{
                    $thn = date("Y");
                    $bln = date("M");
                    //if($jns_evaluasi=='1'){
                    $file_path_excel = '/home/pppts/frontends/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/' . $bln . '/';
                    //}else{
                    $temp_file_path_excel = '/dokumen/hasil_evaluasi/' . $thn . '/' . $bln . '/';
                    //}               


                    if (!is_dir($file_path_excel)) {
                        mkdir($file_path_excel, 0777, true);
                    }
                    $config ['upload_path'] = $file_path_excel;
                    $config ['allowed_types'] = 'xls|xlsx|doc|docx|pdf';
                    $config ['max_size'] = '2000';

                    $this->load->library('upload', $config);

                    $this->objRegistrasi = new Registrasi($idregistrasi);

                    if (!$this->upload->do_upload()) { // upload excell penilaian
                        $error = trim(strip_tags($this->upload->display_errors()));
                        echo '<script>';
                        echo 'alert("Error File Excell Penilaian. ' . $error . '");';
                        echo 'window.history.back(1);';
                        echo '</script>';
                    } else {
                        echo 'file excel uploaded..</br>';
                        $data['upload_data'] = $this->upload->data();
                        $data['jns_evaluasi'] = $jns_evaluasi;
                        $data['type_evaluator'] = $type_evaluator;
                        $data['id_proses'] = $id_proses;
                        $data['final'] = $final;
                        $data['jns_file'] = $jns_file;
                        $data['temp_file_path'] = $temp_file_path_excel;
                        if (!$this->uploadInstrument($data)) {
                            //echo 'file tidak sesuai dengan prodi..</br>';
                            echo '<script>';
                            echo 'alert("Dokumen yang anda upload tidak sesuai dengan prodi yang dievaluasi!");';
                            echo 'window.history.back(1);';
                            echo '</script>';
                        }
                    }
                    if ($jns_evaluasi == '1') {
                        $this->rekapitulasi();
                    }
                    redirect(base_url() . 'backoffice/kelolaevaluasi/indexevaluator/');
                }
            }else{
                redirect(base_url() . 'backoffice/kelolaevaluasi/indexevaluator/');
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    private function uploadInstrument($data) {
        $evaluasi = new Evaluasi();
        $evaluasi_evaluator = new EvaluatorEvaluasi();
        $evaluasi_proses = new EvaluasiProses();
        $evaluator_evaluasi = new EvaluatorEvaluasi();
        $proses = new Proses();
        $rekapitulasi = new Rekapitulasi();
        $evaluasi_rekapitulasi = new EvaluasiRekapitulasi();
        $objNilai = new NilaiDetail('', '');
        $iduser = strtoupper($this->session->userdata('userid'));
        $user = new ModUsers($iduser);
        $upload_data = $data['upload_data'];
        $fullPath = $upload_data ['full_path'];
        $file_name = $upload_data ['file_name'];
        $final = $data['final'];
        $arr_file = explode('_', $file_name);

        echo 'processing instrument </br>';
        echo 'registrasi: ' . $arr_file [0] . '</br>';
        echo 'jns_evaluasi: ' . $data['jns_evaluasi'] . '</br>';
        if ($this->objRegistrasi->getIdRegistrasi() == trim($arr_file [0]) && $data['jns_evaluasi'] == '1') {
            //if($data['jns_evaluasi']=='1'){//evaluasi proposal
            echo 'jns evaluasi: 1..</br>';
            $skema = $this->objRegistrasi->getSchema();
            $skor = 0;
            $legalitas = '';
            $keterangan = '';
            //$result = null;
            $prodi_usulan = '';
            $nilaidetail = '';
            echo 'file path: ' . $fullPath . '</br>';
            //periode 2023
            //$result = $this->readInstrument2023($fullPath);
            //periode 2020
            $result = $this->readInstrument2022($fullPath);
            //$result = $this->readInstrument2021($fullPath);
            //echo 'instrument S1</br>';
            /* if($skema=='C'){
              $result = $this->readInstrument2019($fullPath);
              }elseif($skema=='B' || $skema=='A'){
              $result = $this->readInstrumentSkemaB2019($fullPath);
              } */

            //print_r($result);
            foreach ($result as $key => $value) {
                if ($key == 'skor') {
                    //echo $key.': '.$value.'</br>';
                    $skor = $value;
                } elseif ($key == 'nilaidetail') {
                    $nilaidetail = $value;
                } elseif ($key == 'keterangan') {
                    $keterangan = $value;
                } elseif ($key == 'prodi_usulan') {
                    $prodi_usulan = $value;
                }
            }
            $range = '';
            // rule skor

            if ($skor <= 300) {
                $range = 'yellow';
            } else {
                $range = 'green';
            }
            //$keterangan = '';
            //echo 'range:' . $range . '</br>';



            echo 'skor: ' . $skor . '</br>';
            //echo 'skor: ' . $keterangan . '</br>' . strlen($keterangan);
            if ($skor != '' && strlen($keterangan) > 250) {
                //$evaluasi->m_ModNilaiDetail = $nilaidetail;

                $rekapitulasi->getBy('id_registrasi', $this->objRegistrasi->getIdRegistrasi());
                $evaluasi_rekapitulasi->setIdRekapitulasi($rekapitulasi->getIdRekapitulasi());
                $proses->setIdEvaluator($user->getIdEvaluator());
                //$result_proses = $proses->getByRelated('registrasi', 'id_registrasi',
                //$this->objRegistrasi->getIdRegistrasi(),'0','0');
                $result_proses = $proses->getRecordProcess($this->objRegistrasi->getIdRegistrasi());
                $id_proses = '';
                if ($result_proses->num_rows() > 0) {
                    foreach ($result_proses->result() as $row) {
                        $id_proses = $row->id_proses;
                        $jns_evaluasi = $row->id_jns_evaluasi;
                    }
                } else {
                    echo ('Tidak ada penugasan!' . '</br>');
                }
                // check
                $temp_no_evaluasi = '';
                $isOk = false;

                // start transaction --------------------------------------------
                $this->db->trans_begin();
                echo 'transaction started..</br>';
                if ($evaluasi->isExist($id_proses)) {
                    echo 'exist..' . '</br>';
                    $temp_no_evaluasi = $evaluasi->getIdEvaluasi();
                    $objNilai->setIdEvaluasi($temp_no_evaluasi);
                    $evaluator_evaluasi->setIdEvaluasi($temp_no_evaluasi);
                    $evaluasi_proses->setIdEvaluasi($temp_no_evaluasi);

                    $evaluasi->getBy('id_evaluasi', $temp_no_evaluasi);
                    $evaluasi->setTglEvaluasi(date("Y-m-d"));
                    $evaluasi->setSkor($skor);
                    $evaluasi->setRange($range);
                    $evaluasi->setKeterangan(htmlentities(($keterangan)));
                    $evaluasi->setLastUpdate(date("Y-m-d"));
                    $evaluasi->setIdStatusRegistrasi('');
                    $evaluasi->setIdJnsEvaluasi($jns_evaluasi);
                    //$evaluasi->setFilePath( $fullPath );
                    $isOk = $evaluasi->update();

                    $objNilai->delete();
                    $evaluator_evaluasi->delete();
                    $evaluasi_proses->delete();
                    $rekapitulasi->delete();
                    $evaluasi_rekapitulasi->delete();
                    echo 'evaluasi, rekapitulasi & nilai detail deleted</br>';
                    $evaluasi->setIdEvaluasi($temp_no_evaluasi);
                } else {
                    $evaluasi->setIdEvaluasi($evaluasi->generateId($user->getIdEvaluator()));
                    $evaluasi->setTglEvaluasi(date("Y-m-d"));
                    $evaluasi->setSkor($skor);
                    $evaluasi->setRange($range);
                    $evaluasi->setKeterangan(htmlentities(($keterangan)));
                    $evaluasi->setLastUpdate(date("Y-m-d"));
                    $evaluasi->setIdStatusRegistrasi('');
                    $evaluasi->setFilePath($fullPath);
                    $isOk = $evaluasi->insert();
                }


                if ($isOk) {
                    echo 'evaluasi inserted..</br>';

                    foreach ($nilaidetail as $nilai) {

                        $nilai->setIdEvaluasi($evaluasi->getIdEvaluasi());

                        if ($nilai->insert()) {
                            //echo 'nilai detail inserted..</br>';
                        }
                    }

                    //insert evaluator
                    $evaluator_evaluasi->setIdEvaluasi($evaluasi->getIdEvaluasi());
                    $evaluator_evaluasi->setIdEvaluator($user->getIdEvaluator());
                    $evaluator_evaluasi->insert();
                    echo 'evaluator evaluasi inserted..</br>';

                    //insert evaluasi proses
                    $evaluasi_proses->setIdProses($id_proses);
                    $evaluasi_proses->setIdEvaluasi($evaluasi->getIdEvaluasi());
                    $evaluasi_proses->insert();
                    echo 'evaluasi proses inserted..</br>';
                    // update status proses
                    $proses->getBy('id_proses', $id_proses);
                    $proses->setIdStatusProses('3'); //selesai
                    $proses->update();
                    echo 'proces status updated..</br>';
                }

                if (!is_null($prodi_usulan)) {
                    $objprodi = new RegistrasiProdiUsulan();
                    $objprodi->setIdRegistrasi($this->objRegistrasi->getIdRegistrasi());
                    if ($objprodi->isExist()) {
                        $objprodi->delete();
                    }
                    /* foreach ($prodi_usulan as $prodi) {

                      $prodi->setIdRegistrasi($this->objRegistrasi->getIdRegistrasi());
                      if ($prodi->insert()) {
                      echo 'prodi usulan inserted!</br>';
                      } else {
                      echo 'prodi is not inserted!';
                      }
                      } */
                } else {
                    //print_r($prodi_usulan);
                    exit();
                }

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo 'all transaction rolled back!</br>';
                } else {
                    // commit transaction
                    $this->db->trans_commit();
                    echo 'all transaction commited..</br>';
                    return true;
                }
            } else {
                //exit("Skor kosong! atau Keterangan < 250!");
                echo '<script>';
                echo 'alert("Komentar Umum kosong atau kurang dari 50 karakter!");';
                echo 'window.history.back(1);';
                echo '</script>';
                //return false;
            }
        } else {
            if ($data['jns_evaluasi'] == '2') {
                echo 'jns evaluasi: 2..</br>';
                // start transaction -------------------------------------------
                $this->db->trans_begin();
                echo 'transaction started..</br>';
                // check
                $temp_no_evaluasi = '';
                $isOk = false;
                if ($evaluasi->isExist($data['id_proses'])) {
                    echo 'exist..' . '</br>';
                    $temp_no_evaluasi = $evaluasi->getIdEvaluasi();
                    echo 'temp no evaluasi: ' . $temp_no_evaluasi, '</br>';
                    $objNilai->setIdEvaluasi($temp_no_evaluasi);
                    $evaluator_evaluasi->setIdEvaluasi($temp_no_evaluasi);
                    $evaluasi_proses->setIdEvaluasi($temp_no_evaluasi);

                    $evaluasi->getBy('id_evaluasi', $temp_no_evaluasi);
                    $evaluasi->setTglEvaluasi(date("Y-m-d"));
                    $evaluasi->setSkor(0);
                    $evaluasi->setRange('green');
                    $evaluasi->setKeterangan('Evaluasi Program');
                    $evaluasi->setLastUpdate(date("Y-m-d"));
                    //$evaluasi->setIdStatusRegistrasi(7);
                    //$evaluasi->setFilePath( $fullPath );
                    $evaluasi->setIdJnsEvaluasi($data['jns_evaluasi']);
                    $isOk = $evaluasi->update();

                    //$objNilai->delete();
                    $evaluator_evaluasi->delete();
                    $evaluasi_proses->delete();
                    //$rekapitulasi->delete();
                    //$evaluasi_rekapitulasi->delete();
                    echo 'evaluasi, rekapitulasi & nilai detail deleted</br>';
                    $evaluasi->setIdEvaluasi($temp_no_evaluasi);
                } else {
                    $evaluasi->setIdEvaluasi($evaluasi->generateId($user->getIdEvaluator()));
                    $evaluasi->setTglEvaluasi(date("Y-m-d"));
                    $evaluasi->setSkor(0);
                    $evaluasi->setRange('green');
                    $evaluasi->setKeterangan('Evaluasi Program');
                    $evaluasi->setLastUpdate(date("Y-m-d"));
                    //$evaluasi->setIdStatusRegistrasi(7);
                    $evaluasi->setFilePath($fullPath);
                    $evaluasi->setIdJnsEvaluasi($data['jns_evaluasi']);
                    $isOk = $evaluasi->insert();
                    echo 'evaluasi inserted..</br>';
                }

                echo 'no evaluasi:' . $evaluasi->getIdEvaluasi() . '</br>';

                if ($isOk) {
                    echo 'evaluasi inserted..</br>';

                    //insert evaluator
                    $evaluator_evaluasi->setIdEvaluasi($evaluasi->getIdEvaluasi());
                    $evaluator_evaluasi->setIdEvaluator($user->getIdEvaluator());
                    $evaluator_evaluasi->insert();
                    echo 'evaluator evaluasi inserted..</br>';

                    //insert evaluasi proses
                    $evaluasi_proses->setIdProses($data['id_proses']);
                    $evaluasi_proses->setIdEvaluasi($evaluasi->getIdEvaluasi());
                    $evaluasi_proses->insert();
                    echo 'evaluasi proses inserted..</br>';
                }

                if ($final == 1) {
                    // update status proses
                    $proses = new Proses();
                    $proses->getBy('id_proses', $data['id_proses']);
                    $proses->setIdEvaluator($user->getIdEvaluator());
                    $proses->setTglTerima(date('Y-m-d'));
                    $proses->setIdStatusProses('3'); //selesai
                    $proses->update();
                    $status = 7;
                    //update registrasi --------------------------------------------
                    $this->objRegistrasi->setIdStatusRegistrasi($status);
                    $this->objRegistrasi->update();
                    //update rekapitulasi ------------------------------------------                
                    $rekapitulasi->getBy('id_registrasi', $this->objRegistrasi->getIdRegistrasi());
                    $rekapitulasi->setIdStatusRegistrasi($status);
                    $rekapitulasi->update();
                    echo 'rekapitulasi updated..</br>';
                }

                //update rekapitulasi berita acara -----------------------------
                $temp_id = explode('_', $data['jns_file']);
                $id_dp = $temp_id[0];
                $id_jns_file = $temp_id[1];
                $dokumen_presentasi = new DokumenPresentasi($id_dp);
                $rekapitulasi_ba = new RekapitulasiBeritaAcara();
                $rekapitulasi_ba->setIdRegistrasi($this->objRegistrasi->getIdRegistrasi());
                $rekapitulasi_ba->setIdJnsFile($dokumen_presentasi->getIdJnsFile());
                $rekapitulasi_ba->setReferensi('PPPTS');
                $rekapitulasi_ba->setIdDp($dokumen_presentasi->getId());
                $revisi = 0;
                $temp_file_path = $data['temp_file_path'];
                $fullPath = $temp_file_path . $file_name;
                if (!$rekapitulasi_ba->isExist()) {
                    $revisi = 1;
                    $rekapitulasi_ba->setRevisi($revisi);
                    $rekapitulasi_ba->setTglUpload(date('Y-m-d'));
                    $rekapitulasi_ba->setFilePath($fullPath);
                    $rekapitulasi_ba->insert();
                } else {
                    //$rekapitulasi_ba->setRevisi($revisi);                             
                    $rekapitulasi_ba->setTglUpload(date('Y-m-d'));
                    $rekapitulasi_ba->setFilePath($fullPath);
                    $rekapitulasi_ba->update();
                    $temp_revisi = $rekapitulasi_ba->getRevisi();
                    $temp_revisi++;
                    $revisi = $temp_revisi;
                }

                echo 'rekapitulasi berita acara inserted..</br>';

                echo 'registrasi updated..</br>';

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo 'all transaction rolled back!</br>';
                } else {
                    // commit transaction
                    $this->db->trans_commit();
                    echo 'all transaction commited..</br>';
                }
                return true;
            } else {
                unlink($fullPath);
                return false;
            }
        }
    }

    public function readInstrument($path) {
        $file_path = $path;
        if (!file_exists($file_path)) {
            exit("File unavailable!");
        }
        $objPHPExcel = PHPExcel_IOFactory::load($file_path);
        ;
        $objPHPExcel->setActiveSheetIndex(0);
        //echo 'Reading sheet '.$objPHPExcel->getActiveSheetIndex().'</br>';
        $objbobot = new BobotNilai();
        $nilaidetail = new ArrayObject ();
        $skor = $objPHPExcel->getActiveSheet()->getCell('J' . '44')->getCalculatedValue();
        $keterangan = $objPHPExcel->getActiveSheet()->getCell('B' . '47')->getCalculatedValue();
        //$legalitas = $objPHPExcel->getActiveSheet()->getCell('D'.'67')->getCalculatedValue();
        //$dosen_tetap = $objPHPExcel->getActiveSheet()->getCell('D'.'68')->getCalculatedValue();
        //$return_value = array('skor'=>$skor);

        for ($i = 14; $i <= 43; $i++) {
            $objNilai = new NilaiDetail('', '');
            echo 'Reading items..';
            $idbobot = 'Q';
            $butir = str_replace('.', '', $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
            if (strlen($butir) == 3 && is_numeric($butir)) {
                $idaspek = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $aspek = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $bobot = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
                $nilai = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
                $komentar = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue();
                if (!is_numeric($nilai)) {
                    echo '<script>';
                    echo 'alert("Nilai harus berisi angka!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit();
                }
                if ($komentar == '') {
                    echo '<script>';
                    echo 'alert("Komentar pada kolom Keterangan tidak boleh kosong!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit();
                }
                $objbobot->setIdBobot($idbobot . $butir);
                $objbobot->setIdAspek($idaspek);
                $objbobot->setNoAspek($butir);
                $objbobot->setAspek('');
                $objbobot->setKeteranganAspek($aspek);
                $objbobot->setBobot($bobot);
                $objbobot->setPeriode('2017');
                //$objbobot->insert();
                echo 'Butir: ' . $butir . ' inserted.</br>';

                //$objNilai->setNoEvaluasi ($noevaluasi);
                $objNilai->setNilai($nilai);
                $objNilai->setKomentar(htmlentities(($komentar)));
                $objNilai->setIdBobot($idbobot . $butir);
                $nilaidetail->append($objNilai);
            }
        }
        $return_value = array('skor' => $skor, 'nilaidetail' => $nilaidetail, 'keterangan' => $keterangan);
        return $return_value;
    }

    public function readInstrument2019($path) {
        $file_path = $path;
        if (!file_exists($file_path)) {
            exit("File unavailable!");
        }
        $objPHPExcel = PHPExcel_IOFactory::load($file_path);
        ;
        $objPHPExcel->setActiveSheetIndex(0);
        //echo 'Reading sheet '.$objPHPExcel->getActiveSheetIndex().'</br>';
        $objbobot = new BobotNilai();
        $nilaidetail = new ArrayObject ();
        $skor = $objPHPExcel->getActiveSheet()->getCell('J' . '44')->getCalculatedValue();
        $keterangan = $objPHPExcel->getActiveSheet()->getCell('A' . '47')->getCalculatedValue();
        //$legalitas = $objPHPExcel->getActiveSheet()->getCell('D'.'67')->getCalculatedValue();
        //$dosen_tetap = $objPHPExcel->getActiveSheet()->getCell('D'.'68')->getCalculatedValue();
        //$return_value = array('skor'=>$skor);

        for ($i = 14; $i <= 43; $i++) {
            $objNilai = new NilaiDetail('', '');
            echo 'Reading items..';
            $idbobot = 'Q';
            $butir = str_replace('.', '', $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
            if (strlen($butir) == 3 && is_numeric($butir)) {
                $idaspek = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $aspek = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $bobot = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
                $nilai = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
                $komentar = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue();
                if (!is_numeric($nilai)) {
                    echo '<script>';
                    echo 'alert("Nilai harus berisi angka!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit();
                }
                if (strlen($komentar) < 50) {
                    echo '<script>';
                    echo 'alert("Komentar pada kolom Keterangan kurang dari 50 karakter!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit();
                }
                $objbobot->setIdBobot($idbobot . $butir);
                $objbobot->setIdAspek($idaspek);
                $objbobot->setNoAspek($butir);
                $objbobot->setAspek('');
                $objbobot->setKeteranganAspek($aspek);
                $objbobot->setBobot($bobot);
                $objbobot->setPeriode('2017');
                //$objbobot->insert();
                echo 'Butir: ' . $butir . ' inserted.</br>';

                //$objNilai->setNoEvaluasi ($noevaluasi);
                $objNilai->setNilai($nilai);
                $objNilai->setKomentar(htmlentities(($komentar)));
                $objNilai->setIdBobot($idbobot . $butir);
                $nilaidetail->append($objNilai);
            }
        }
        $return_value = array('skor' => $skor, 'nilaidetail' => $nilaidetail, 'keterangan' => $keterangan);
        return $return_value;
    }

    public function readInstrument2020($path) {
        $file_path = $path;
        if (!file_exists($file_path)) {
            exit("File unavailable!");
        }
        $objPHPExcel = IOFactory::load($file_path);

        $objPHPExcel->setActiveSheetIndex(0);
        echo 'Reading sheet ' . $objPHPExcel->getActiveSheetIndex() . '</br>';
        $objbobot = new BobotNilai();
        $nilaidetail = new ArrayObject ();
        $prodiusulan = new ArrayObject();
        $skor = $objPHPExcel->getActiveSheet()->getCell('J' . '46')->getCalculatedValue();
        $keterangan = $objPHPExcel->getActiveSheet()->getCell('A' . '49')->getCalculatedValue();
        //$legalitas = $objPHPExcel->getActiveSheet()->getCell('D'.'67')->getCalculatedValue();
        //$dosen_tetap = $objPHPExcel->getActiveSheet()->getCell('D'.'68')->getCalculatedValue();
        //$return_value = array('skor'=>$skor);

        for ($i = 14; $i <= 45; $i++) {
            $objNilai = new NilaiDetail('', '');
            $registrasiprodi = new RegistrasiProdiUsulan();
            echo 'Reading items. row: ' . $i . '</br>';
            $idbobot = 'I';
            $butir = str_replace('.', '', $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
            if (strlen($butir) == 3 && is_numeric($butir)) {
                $idaspek = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $aspek = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $bobot = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
                $nilai = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
                $komentar = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue();

                if (!is_numeric($nilai)) {
                    echo '<script>';
                    echo 'alert("Nilai harus berisi angka!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit(1);
                }
                if ($nilai > 5) {
                    echo '<script>';
                    echo 'alert("Nilai > 5");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit(1);
                }
                if (strlen($komentar) < 50) {

                    echo '<script>';
                    echo 'alert("Komentar pada kolom Keterangan baris: ' . $i . ' kurang dari 50 karakter!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    //echo "<h3>Komentar pada kolom Keterangan baris: ".$i." kurang dari 50 karakter!</h3>";					
                    exit(1);
                }
                $objbobot->setIdBobot($idbobot . $butir);
                $objbobot->setIdAspek($idaspek);
                $objbobot->setNoAspek($butir);
                $objbobot->setAspek('');
                $objbobot->setKeteranganAspek($aspek);
                $objbobot->setBobot($bobot);
                $objbobot->setPeriode('20201');
                //$objbobot->insert();
                //echo 'Butir: ' . $butir . ' inserted.</br>';
                //$objNilai->setNoEvaluasi ($noevaluasi);
                $objNilai->setNilai($nilai);
                $objNilai->setKomentar(htmlentities(($komentar)));
                $objNilai->setIdBobot($idbobot . $butir);
                $nilaidetail->append($objNilai);
            }
        }
        $n = 57;
        $no = $objPHPExcel->getActiveSheet()->getCell('A' . $n)->getCalculatedValue();

        while (is_numeric($no)) {
            $registrasiprodi = new RegistrasiProdiUsulan();
            $registrasiprodi->setNamaProdi($objPHPExcel->getActiveSheet()->getCell('B' . $n)->getCalculatedValue());
            $registrasiprodi->setProgram($objPHPExcel->getActiveSheet()->getCell('C' . $n)->getCalculatedValue());
            $prodiusulan->append($registrasiprodi);
            $n++;
            $no = $objPHPExcel->getActiveSheet()->getCell('A' . $n)->getCalculatedValue();
        }
        $return_value = array(
            'skor' => $skor,
            'nilaidetail' => $nilaidetail,
            'keterangan' => $keterangan,
            'prodi_usulan' => $prodiusulan);
        return $return_value;
    }

    public function readInstrumentSkemaB2019($path) {
        $file_path = $path;
        if (!file_exists($file_path)) {
            exit("File unavailable!");
        }
        $objPHPExcel = PHPExcel_IOFactory::load($file_path);
        ;
        $objPHPExcel->setActiveSheetIndex(0);
        //echo 'Reading sheet '.$objPHPExcel->getActiveSheetIndex().'</br>';
        $objbobot = new BobotNilai();
        $nilaidetail = new ArrayObject ();
        $skor = $objPHPExcel->getActiveSheet()->getCell('J' . '41')->getCalculatedValue();
        $keterangan = $objPHPExcel->getActiveSheet()->getCell('A' . '44')->getCalculatedValue();
        //$legalitas = $objPHPExcel->getActiveSheet()->getCell('D'.'67')->getCalculatedValue();
        //$dosen_tetap = $objPHPExcel->getActiveSheet()->getCell('D'.'68')->getCalculatedValue();
        //$return_value = array('skor'=>$skor);

        for ($i = 14; $i <= 40; $i++) {
            $objNilai = new NilaiDetail('', '');
            echo 'Reading items..';
            $idbobot = 'B';
            $butir = str_replace('.', '', $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
            if (strlen($butir) == 3 && is_numeric($butir)) {
                $idaspek = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $aspek = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $bobot = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
                $nilai = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
                $komentar = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue();
                if (!is_numeric($nilai)) {
                    echo '<script>';
                    echo 'alert("Nilai harus berisi angka!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit();
                }
                if (strlen($komentar) < 100) {
                    echo '<script>';
                    echo 'alert("Komentar pada kolom Keterangan kurang dari 100 karakter!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit();
                }
                $objbobot->setIdBobot($idbobot . $butir);
                $objbobot->setIdAspek($idaspek);
                $objbobot->setNoAspek($butir);
                $objbobot->setAspek('B');
                $objbobot->setKeteranganAspek($aspek);
                $objbobot->setBobot($bobot);
                $objbobot->setPeriode('20192');
                //$objbobot->insert();
                echo 'Butir: ' . $butir . ' inserted.</br>';

                //$objNilai->setNoEvaluasi ($noevaluasi);
                $objNilai->setNilai($nilai);
                $objNilai->setKomentar(htmlentities(($komentar)));
                $objNilai->setIdBobot($idbobot . $butir);
                $nilaidetail->append($objNilai);
            }
        }
        $return_value = array('skor' => $skor, 'nilaidetail' => $nilaidetail, 'keterangan' => $keterangan);
        return $return_value;
    }

    public function readInstrument2021($path) {
        $file_path = $path;
        if (!file_exists($file_path)) {
            exit("File unavailable!");
        }
        $objPHPExcel = IOFactory::load($file_path);

        $objPHPExcel->setActiveSheetIndex(0);
        echo 'Reading sheet ' . $objPHPExcel->getActiveSheetIndex() . '</br>';
        $objbobot = new BobotNilai();
        $nilaidetail = new ArrayObject ();
        $prodiusulan = new ArrayObject();
        $skor = $objPHPExcel->getActiveSheet()->getCell('I' . '41')->getCalculatedValue();
        $keterangan = $objPHPExcel->getActiveSheet()->getCell('A' . '44')->getCalculatedValue();
        //$legalitas = $objPHPExcel->getActiveSheet()->getCell('D'.'67')->getCalculatedValue();
        //$dosen_tetap = $objPHPExcel->getActiveSheet()->getCell('D'.'68')->getCalculatedValue();
        //$return_value = array('skor'=>$skor);

        for ($i = 13; $i <= 40; $i++) {
            $objNilai = new NilaiDetail('', '');
            $registrasiprodi = new RegistrasiProdiUsulan();
            echo 'Reading items. row: ' . $i . '</br>';
            $idbobot = 'A';
            $butir = str_replace('.', '', $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
            if (strlen($butir) == 3 && is_numeric($butir)) {
                $idaspek = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $aspek = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $bobot = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
                $nilai = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
                $komentar = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();

                if (!is_numeric($nilai)) {
                    echo '<script>';
                    echo 'alert("Nilai harus berisi angka!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit(1);
                }
                if ($nilai > 5 || $nilai < 1) {
                    echo '<script>';
                    echo 'alert("Nilai pada baris: ' . $i . ' tidak boleh < 1 atau > 5");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit(1);
                }
                if (strlen($komentar) < 50) {

                    echo '<script>';
                    echo 'alert("Komentar pada kolom Keterangan baris: ' . $i . ' kurang dari 50 karakter!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    //echo "<h3>Komentar pada kolom Keterangan baris: ".$i." kurang dari 50 karakter!</h3>";					
                    exit(1);
                }
                $objbobot->setIdBobot($idbobot . $butir);
                $objbobot->setIdAspek($idaspek);
                $objbobot->setNoAspek($butir);
                $objbobot->setAspek('A');
                $objbobot->setKeteranganAspek($aspek);
                $objbobot->setBobot($bobot);
                $objbobot->setPeriode('20211');
                //$objbobot->insert();
                //echo 'Butir: ' . $butir . ' inserted.</br>';
                //$objNilai->setNoEvaluasi ($noevaluasi);
                $objNilai->setNilai($nilai);
                $objNilai->setKomentar(htmlentities(($komentar)));
                $objNilai->setIdBobot($idbobot . $butir);
                $nilaidetail->append($objNilai);
            }
        }
        /* $n = 57;
          $no = $objPHPExcel->getActiveSheet()->getCell('A' . $n)->getCalculatedValue();

          while (is_numeric($no)) {
          $registrasiprodi = new RegistrasiProdiUsulan();
          $registrasiprodi->setNamaProdi($objPHPExcel->getActiveSheet()->getCell('B' . $n)->getCalculatedValue());
          $registrasiprodi->setProgram($objPHPExcel->getActiveSheet()->getCell('C' . $n)->getCalculatedValue());
          $prodiusulan->append($registrasiprodi);
          $n++;
          $no = $objPHPExcel->getActiveSheet()->getCell('A' . $n)->getCalculatedValue();
          } */
        $return_value = array(
            'skor' => $skor,
            'nilaidetail' => $nilaidetail,
            'keterangan' => $keterangan);
        //'prodi_usulan' => $prodiusulan);
        return $return_value;
    }

    public function readInstrument2022($path) {
        $file_path = $path;
        if (!file_exists($file_path)) {
            exit("File unavailable!");
        }
        $objPHPExcel = IOFactory::load($file_path);

        $objPHPExcel->setActiveSheetIndex(0);
        echo 'Reading sheet ' . $objPHPExcel->getActiveSheetIndex() . '</br>';
        $objbobot = new BobotNilai();
        $nilaidetail = new ArrayObject ();
        $prodiusulan = new ArrayObject();
        $skor = $objPHPExcel->getActiveSheet()->getCell('G' . '34')->getCalculatedValue();
        $keterangan = $objPHPExcel->getActiveSheet()->getCell('A' . '37')->getCalculatedValue();
        //$legalitas = $objPHPExcel->getActiveSheet()->getCell('D'.'67')->getCalculatedValue();
        //$dosen_tetap = $objPHPExcel->getActiveSheet()->getCell('D'.'68')->getCalculatedValue();
        //$return_value = array('skor'=>$skor);

        for ($i = 13; $i <= 33; $i++) {
            $objNilai = new NilaiDetail('', '');
            $registrasiprodi = new RegistrasiProdiUsulan();
            //echo 'Reading items. row: ' . $i . '</br>';
            $idbobot = 'A';
            $butir = str_replace('.', '', $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
            if (strlen($butir) == 2 && is_numeric($butir)) {
                $idaspek = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $aspek = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $bobot = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                $nilai = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                $komentar = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();

                if (!is_numeric($nilai)) {
                    echo '<script>';
                    echo 'alert("Nilai harus berisi angka!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit(1);
                }
                if ($nilai > 5 || $nilai < 1) {
                    echo '<script>';
                    echo 'alert("Nilai pada baris: ' . $i . ' tidak boleh < 1 atau > 5");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit(1);
                }
                if (strlen($komentar) < 50) {

                    echo '<script>';
                    echo 'alert("Komentar pada kolom Keterangan baris: ' . $i . ' kurang dari 50 karakter!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    //echo "<h3>Komentar pada kolom Keterangan baris: ".$i." kurang dari 50 karakter!</h3>";					
                    exit(1);
                }
                $objbobot->setIdBobot($idbobot . $butir);
                $objbobot->setIdAspek($idaspek);
                $objbobot->setNoAspek($butir);
                $objbobot->setAspek('B');
                $objbobot->setKeteranganAspek($aspek);
                $objbobot->setBobot($bobot);
                $objbobot->setPeriode('20221');
                //$objbobot->insert();
                //echo 'Butir: ' . $butir . ' inserted.</br>';
                //$objNilai->setNoEvaluasi ($noevaluasi);
                $objNilai->setNilai($nilai);
                $objNilai->setKomentar(htmlentities(($komentar)));
                $objNilai->setIdBobot($idbobot . $butir);
                $nilaidetail->append($objNilai);
            }
        }
        /* $n = 57;
          $no = $objPHPExcel->getActiveSheet()->getCell('A' . $n)->getCalculatedValue();

          while (is_numeric($no)) {
          $registrasiprodi = new RegistrasiProdiUsulan();
          $registrasiprodi->setNamaProdi($objPHPExcel->getActiveSheet()->getCell('B' . $n)->getCalculatedValue());
          $registrasiprodi->setProgram($objPHPExcel->getActiveSheet()->getCell('C' . $n)->getCalculatedValue());
          $prodiusulan->append($registrasiprodi);
          $n++;
          $no = $objPHPExcel->getActiveSheet()->getCell('A' . $n)->getCalculatedValue();
          } */
        $return_value = array(
            'skor' => $skor,
            'nilaidetail' => $nilaidetail,
            'keterangan' => $keterangan);
        //'prodi_usulan' => $prodiusulan);
        return $return_value;
    }

    public function readInstrument2023($path) {
        $file_path = $path;
        if (!file_exists($file_path)) {
            exit("File unavailable!");
        }
        $objPHPExcel = IOFactory::load($file_path);

        $objPHPExcel->setActiveSheetIndex(0);
        echo 'Reading sheet ' . $objPHPExcel->getActiveSheetIndex() . '</br>';
        $objbobot = new BobotNilai();
        $nilaidetail = new ArrayObject ();
        $prodiusulan = new ArrayObject();
        $skor = $objPHPExcel->getActiveSheet()->getCell('G' . '34')->getCalculatedValue();
        $keterangan = $objPHPExcel->getActiveSheet()->getCell('A' . '37')->getCalculatedValue();
        //$legalitas = $objPHPExcel->getActiveSheet()->getCell('D'.'67')->getCalculatedValue();
        //$dosen_tetap = $objPHPExcel->getActiveSheet()->getCell('D'.'68')->getCalculatedValue();
        //$return_value = array('skor'=>$skor);

        for ($i = 13; $i <= 33; $i++) {
            $objNilai = new NilaiDetail('', '');
            $registrasiprodi = new RegistrasiProdiUsulan();
            //echo 'Reading items. row: ' . $i . '</br>';
            $idbobot = 'C';
            $butir = str_replace('.', '', $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
            if (strlen($butir) == 2 && is_numeric($butir)) {
                $idaspek = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $aspek = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $bobot = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                $nilai = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                $komentar = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();

                if (!is_numeric($nilai)) {
                    echo '<script>';
                    echo 'alert("Nilai harus berisi angka!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit(1);
                }
                if ($nilai > 5 || $nilai < 1) {
                    echo '<script>';
                    echo 'alert("Nilai pada baris: ' . $i . ' tidak boleh < 1 atau > 5");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    exit(1);
                }
                if (strlen($komentar) < 50) {

                    echo '<script>';
                    echo 'alert("Komentar pada kolom Keterangan baris: ' . $i . ' kurang dari 50 karakter!");';
                    echo 'window.history.back(0);';
                    echo '</script>';
                    //echo "<h3>Komentar pada kolom Keterangan baris: ".$i." kurang dari 50 karakter!</h3>";					
                    exit(1);
                }
                $objbobot->setIdBobot($idbobot . $butir);
                $objbobot->setIdAspek($idaspek);
                $objbobot->setNoAspek($butir);
                $objbobot->setAspek('B');
                $objbobot->setKeteranganAspek($aspek);
                $objbobot->setBobot($bobot);
                $objbobot->setPeriode('20221');
                //$objbobot->insert();
                //echo 'Butir: ' . $butir . ' inserted.</br>';
                //$objNilai->setNoEvaluasi ($noevaluasi);
                $objNilai->setNilai($nilai);
                $objNilai->setKomentar(htmlentities(($komentar)));
                $objNilai->setIdBobot($idbobot . $butir);
                $nilaidetail->append($objNilai);
            }
        }
        /* $n = 57;
          $no = $objPHPExcel->getActiveSheet()->getCell('A' . $n)->getCalculatedValue();

          while (is_numeric($no)) {
          $registrasiprodi = new RegistrasiProdiUsulan();
          $registrasiprodi->setNamaProdi($objPHPExcel->getActiveSheet()->getCell('B' . $n)->getCalculatedValue());
          $registrasiprodi->setProgram($objPHPExcel->getActiveSheet()->getCell('C' . $n)->getCalculatedValue());
          $prodiusulan->append($registrasiprodi);
          $n++;
          $no = $objPHPExcel->getActiveSheet()->getCell('A' . $n)->getCalculatedValue();
          } */
        $return_value = array(
            'skor' => $skor,
            'nilaidetail' => $nilaidetail,
            'keterangan' => $keterangan);
        //'prodi_usulan' => $prodiusulan);
        return $return_value;
    }

    private function rekapitulasi() {
        echo 'processing rekapitulasi</br>';
        $id_registrasi = $this->objRegistrasi->getIdRegistrasi();
        $evaluasi = new Evaluasi();
        $result_evaluasi = $evaluasi->getByRelated('registrasi', 'id_registrasi', $id_registrasi, '0', '0');
        if ($result_evaluasi->num_rows() == '2') {//jika 2, proses rekapitulasi
            $status_konsolidasi = false;
            $hasil_evaluasi = '';
            $skor = 0;
            $keterangan = '';
            $total_skor = 0;
            //check konsolidasi
            echo 'check konsolidasi</br>';
            foreach ($result_evaluasi->result() as $eva) {

                if ($skor != 0) {

                    if ($skor > $eva->skor) {
                        $range = $skor - $eva->skor;
                        if ($range >= 70) {
                            $status_konsolidasi = true;
                        }
                    } elseif ($skor < $eva->skor) {
                        $range = $eva->skor - $skor;
                        if ($range >= 70) {
                            $status_konsolidasi = true;
                        }
                    }
                } else {
                    $skor = $eva->skor;
                }
                $total_skor = $total_skor + $eva->skor;
            }

            if (!$status_konsolidasi) {//tidak ada konsolidasi
                echo 'no konsolidasi</br>';
                $rerata = $total_skor / 2;
                echo 'skor rerata: ' . $rerata . '</br>';
                if ($rerata >= 250) {
                    $hasil_evaluasi = '5';
                } else {
                    $hasil_evaluasi = '6';
                }
                //simpan ke rekapitulasi
                $rekapitulasi = new Rekapitulasi();
                $rekapitulasi->setIdRegistrasi($id_registrasi);
                $rekapitulasi->setIdStatusRegistrasi($hasil_evaluasi);
                $rekapitulasi->setNilaiTotal($rerata);
                $rekapitulasi->setKeterangan($keterangan);
                $rekapitulasi->setPublish('no');
                $rekapitulasi->setTglRekap(date('Y-m-d'));
                $rekapitulasi->insert();

                //simpan evaluasi rekapitulasi
                foreach ($result_evaluasi->result() as $eva) {
                    $evaluasi_rekapitulasi = new EvaluasiRekapitulasi();
                    $evaluasi_rekapitulasi->setIdEvaluasi($eva->id_evaluasi);
                    $evaluasi_rekapitulasi->setIdRekapitulasi($rekapitulasi->getIdRekapitulasi());
                    $evaluasi_rekapitulasi->insert();
                }

                //update status proses
                foreach ($result_evaluasi->result() as $row) {
                    $eva = new Evaluasi($row->id_evaluasi);
                    $pro = $eva->getProses();
                    $pro->setIdStatusProses('3'); //status selesai
                    $pro->update();
                }
            } else {//harus konsolidasi
                echo 'there is konsolidasi</br>';
                foreach ($result_evaluasi->result() as $row) {
                    $eva = new Evaluasi($row->id_evaluasi);
                    $pro = $eva->getProses();
                    $pro->setIdStatusProses('4'); //status konsolidasi
                    $pro->update();

                    //notifikasi ada konsolidasi---------------------------
                    $reg = $pro->getRegistrasi();
                    $pti = $reg->getPti();
                    $objEva = $eva->getEvaluator();
                    $email = $objEva->getEmail();

                    /* $this->load->library('email');
                      $config['useragent'] = "CodeIgniter";
                      $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                      $config['protocol'] = 'smtp';
                      $config['smtp_host'] = 'ssl://mail.dikti.go.id'; //change this
                      $config['smtp_port'] = '465';
                      $config['smtp_user'] = 'app@dikti.go.id';
                      $config['smtp_pass'] = 'SecretApp2016!';
                      $config['mailtype'] = 'html';
                      $config['charset'] = 'iso-8859-1';
                      $config['wordwrap'] = TRUE;
                      $config['newline'] = "\r\n";
                      $this->email->initialize($config); */
                    $config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.googlemail.com',
                        'smtp_port' => 465,
                        'smtp_user' => 'subditppt@gmail.com',
                        'smtp_pass' => 'nanassubang',
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1',
                        'newline' => '\r\n'
                    );
                    $this->load->library('email', $config);

                    $this->email->from('subdit_ppt@dikti.go.id', 'PPPTS');
                    $this->email->to($email);
                    $this->email->cc('ibnuakila@yahoo.com');
                    //$this->email->bcc('them@their-example.com');

                    $this->email->subject('Konsolidasi Evaluasi');
                    $this->email->message('Yth.' . $objEva->getNmEvaluator() . '\r\n' . 'Anda harus melakukan konsolidasi penilaian PPPTS. \r\n ' .
                            'Nama PT: ' . $pti->getNmPti() . '\r\n ' .
                            'Harap login di alamat: http://pppts.ristekdikti.go.id/backoffice , Terima Kasih.\r\n');

                    //$this->email->send();
                }
            }
        }
    }

    public function view($idregistrasi) {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'view_evaluasi';
            //$rekapitulasi = new Rekapitulasi();
            //$rekapitulasi->getBy('id_registrasi', $idregistrasi);
            //$result = $rekapitulasi->getEvaluasi();
            $evaluasi = new Evaluasi();
            $result = $evaluasi->getByRelated('registrasi', 'id_registrasi', $idregistrasi, '0', '0');

            //print_r($result);
            $data['evaluasi'] = $result;
            showNewBackEnd($view, $data, 'index-1');
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function dataBarang($id_reg) {
        $view = 'view_barang';
        $registrasi = new Registrasi($id_reg);
        $data['registrasi'] = $registrasi;

        showNewBackEnd($view, $data, 'index_new');
    }

    public function printDataBarang($id_reg) {
        $view = 'view_barang';
        $registrasi = new Registrasi($id_reg);
        $data['registrasi'] = $registrasi;
        $this->load->view($view, $data);
    }

    public function downloadDocument($id_upload) {
        $this->load->model('dokumenregistrasi');
        $this->load->helper('download');

        $dokumen_registrasi = new DokumenRegistrasi($id_upload);
        //$res_dok_reg = $dokumen_registrasi->getByRelated('registrasi', 'id_registrasi', '191120143718', '0', '0');
        if ($dokumen_registrasi->getFullPath() != '') {

            $filepath = $dokumen_registrasi->getFullPath();
            $base_path = '/home/pppts/frontends/frontend/web/' . $filepath;
            if (is_file($base_path)) {
                $data = file_get_contents($base_path);
                force_download('dokumen_' . $dokumen_registrasi->getIdForm() . '.pdf', $data);
            } else {
                echo 'File not found!';
            }
        }
    }

    public function downloadDocumentPerbaikan() {
        $this->load->model('dokumenregistrasi');
        $this->load->helper('download');
        $id_registrasi = $this->uri->segment(4);
        $id_form = $this->uri->segment(5);
        $params['id_form'] = $id_form;
        $params['id_registrasi'] = $id_registrasi;
        $dokumen_registrasi = new DokumenPerbaikanUpload($params);
        //$res_dok_reg = $dokumen_registrasi->getByRelated('registrasi', 'id_registrasi', '191120143718', '0', '0');
        if ($dokumen_registrasi->getFilePath() != '') {

            $filepath = $dokumen_registrasi->getFilePath();
            $base_path = '/home/pppts/frontends/frontend/web/' . $filepath;
            if (is_file($base_path)) {
                $data = file_get_contents($base_path);
                force_download('dokumen_' . $dokumen_registrasi->getIdForm() . '.pdf', $data);
            } else {
                echo 'File not found!';
            }
        }
    }

    public function downloadEvaluasi($id_evaluasi) {
        $this->load->model('dokumenregistrasi');
        $this->load->helper('download');
        $eval = $this->session->userdata('userid');
        $evaluasi = new Evaluasi($id_evaluasi);
        $proses = $evaluasi->getProses();
        $registrasi = $proses->getRegistrasi();
        $pt = $registrasi->getPti();
        //$res_dok_reg = $dokumen_registrasi->getByRelated('registrasi', 'id_registrasi', '191120143718', '0', '0');
        if ($evaluasi->getFilePath() != '') {

            $filepath = $evaluasi->getFilePath();
            //$base_path = '/home/pppts/frontends/frontend/web/'.$filepath;
            //echo 'file path: '.$filepath.'</br>';
            if (is_file($filepath)) {
                $data = file_get_contents($filepath);
                $name = $registrasi->getIdRegistrasi() . '_' . str_replace(' ', '_', $pt->getNmPti()) . '_' . $eval . '.xlsx';
                force_download($name, $data);
            } else {
                echo 'File not found!';
            }
        }
    }

    public function downloadFilePresentasi($id, $file) {

        $this->load->helper('download');
        //$eval = $this->session->userdata('userid');
        $rekapitulasi = new RekapitulasiBeritaAcara($id);
        $temp_file = $rekapitulasi->getFilePath();
        $dok_pres = new DokumenPresentasi($file);

        //echo 'file: '.$temp_file.'</br>';
        if ($temp_file != '') {

            if (is_file($temp_file)) {
                $ext = pathinfo($temp_file, PATHINFO_EXTENSION);
                $data = file_get_contents($temp_file);
                $name = $dok_pres->getNamaFile() . '.' . $ext;
                //echo 'name: '.$name;
                force_download($name, $data);
            } else {
                $temp_path = '/home/pppts/frontends/frontend/web/' . $temp_file;
                if (is_file($temp_path)) {
                    $ext = pathinfo($temp_path, PATHINFO_EXTENSION);
                    $data = file_get_contents($temp_path);
                    $name = $dok_pres->getNamaFile() . '.' . $ext;
                    //echo 'name: '.$name;
                    force_download($name, $data);
                } else {
                    echo 'File not found!';
                }
            }
        }
    }

    public function addComment() {
        $view = 'form_upload_komentar';
        $id_reg = $this->uri->segment(4, 0);
        $id_proses = $this->uri->segment(5, 0);
        $registrasi = new Registrasi($id_reg);
        $proses = new Proses($id_proses);
        $registrasi = new Registrasi($id_reg);
        $data['registrasi'] = $registrasi;
        $data['flagInsert'] = 'true';
        $data['id_proses'] = $id_proses;
        showNewBackEnd($view, $data, 'index-1');
    }

    public function saveComment() {
        $idregistrasi = $this->input->post('idregistrasi');
        $jns_evaluasi = $this->input->post('jns_evaluasi');
        $type_evaluator = $this->input->post('type_evaluator');
        $id_proses = $this->input->post('id_proses');
        $thn = date("Y");
        $bln = date("M");

        $file_path_excel = '/home/pppts/frontends/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/' . $bln . '/';

        if (!is_dir($file_path_excel)) {
            mkdir($file_path_excel, 0777, true);
        }
        $config ['upload_path'] = $file_path_excel;
        $config ['allowed_types'] = 'doc|docx|pdf';
        $config ['max_size'] = '2000';

        $this->load->library('upload', $config);

        $this->objRegistrasi = new Registrasi($idregistrasi);

        if (!$this->upload->do_upload()) { // upload excell penilaian
            $error = trim(strip_tags($this->upload->display_errors()));
            echo '<script>';
            echo 'alert("Error File Excell Penilaian. ' . $error . '");';
            echo 'window.history.back(1);';
            echo '</script>';
        } else {
            echo 'file excel uploaded..</br>';
            $data = $this->upload->data();

            $rekap = new Rekapitulasi();
            $rekap->getBy('id_registrasi', $idregistrasi);
            $rekap->setKeterangan($data['full_path']);
            $rekap->update();
            redirect(base_url() . 'backoffice/kelolaevaluasi/indexevaluator/');
        }
    }
    public function addBapMonev() {
        $view = 'form_upload_bap';
        $id_reg = $this->uri->segment(4, 0);
        $id_proses = $this->uri->segment(5, 0);
        //$registrasi = new Registrasi($id_reg);
        //$proses = new Proses($id_proses);
        $registrasi = new Registrasi($id_reg);
        $data['registrasi'] = $registrasi;
        $data['flagInsert'] = 'true';
        $data['id_proses'] = $id_proses;
        showNewBackEnd($view, $data, 'index-1');
    }
    
    public function uploadBapMonev(){
        $id_registrasi = $this->input->post('id_registrasi');
        $id_proses = $this->input->post('id_proses');
        $thn = date("Y");
        $bln = date("M");

        $file_path_excel = '/home/pppts/frontends/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/' . $bln . '/';

        if (!is_dir($file_path_excel)) {
            mkdir($file_path_excel, 0777, true);
        }
        $config ['upload_path'] = $file_path_excel;
        $config ['allowed_types'] = 'doc|docx|pdf';
        $config ['max_size'] = '2000';

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) { // upload excell penilaian
            $error = trim(strip_tags($this->upload->display_errors()));
            echo '<script>';
            echo 'alert("Error. ' . $error . '");';
            echo 'window.history.back(1);';
            echo '</script>';
        } else {
            echo 'file excel uploaded..</br>';
            $data = $this->upload->data();

            $rekap = new Rekapitulasi();
            $rekap->getBy('id_registrasi', $id_registrasi);
            $rekap->setFileBeritaAcara($data['full_path']);
            $rekap->update();
            $proses = new Proses($id_proses);
            $proses->setIdStatusProses(3);
            $proses->update();
            
            $registrasi = new Registrasi($id_registrasi);
            $registrasi->setIdStatusRegistrasi(9);
            $registrasi->update();
            
            redirect(base_url() . 'backoffice/kelolaevaluasi/indexevaluator/');
        }
    }

}

?>