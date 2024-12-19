<?php

require_once ('Icontroll.php');

require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Field;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\SimpleType\TblWidth;

//require_once APPPATH . 'third_party/PhpWord/TemplateProcessor.php';
/**
 * @author akil
 * @version 1.0
 * @created 26-Mar-2016 19:15:02
 */
class KelolaProses extends MX_Controller implements IControll {

    function __construct() {
        parent::__construct();
        $this->load->library('sessionutility');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
        $this->load->model('proses');
        $this->load->model('registrasi');
        $this->load->model('account');
        $this->load->model('pti');
        $this->load->model('verifikasi');
        $this->load->model('periode');
        $this->load->model('dokumenperbaikan');
        $this->load->model('dokumenperbaikanupload');
        $this->load->model('rekapitulasiberitaacara');
        $this->load->model('jenisusulan');
        $this->load->model('ProdiPelaporanPddikti');
        $this->load->model('Registrasiprodi');
        $this->load->model('Penanggungjawab');
        $this->load->model('LaporanPernyataan');
        $this->load->model('LaporanCapaian');
        $this->load->model('LaporanIndikator');
        $this->load->model('Jenisevaluasi');
        $this->load->model('Laporanakhiriku');
        $this->load->model('Laporankemajuan');
        $this->load->model('Danapendamping');
        $this->load->model('Rekapitulasi');
        $this->load->model('Luaranprogram');
        $this->load->helper('download');
        $this->load->model('Paket');
        $this->load->model('Detailpakethibah');
        $this->load->model('Kirim');
        $this->load->model('Detailkirim');
        $this->load->model('Supplier');
        $this->load->model('Itemhibah');
        $this->load->model('Registrasi');
        $this->load->model('Barang');        
        $this->load->model('Itembarang');
        //$this->load->model('Periode');
        $this->load->model('Terimabarang');
    }

    function __destruct() {
        
    }

    public function add() {
        
    }

    public function edit() {
        
    }

    public function find() {
        $view = 'list_proses';

        $id_registrasi = trim($this->input->post('id_registrasi'));
        $yayasan = trim($this->input->post('yayasan'));
        $pti = trim($this->input->post('pti'));
        $jns_usulan = trim($this->input->post('jns_usulan'));
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
            'jns_usulan' => $jns_usulan,
            'evaluator' => $evaluator,
            'status_proses' => $status_proses
        );
        $this->session->set_flashdata($temp_filter);

        $proses = new Proses();
        $periode = new Periode();
        $periode->getBy('status_periode', 'open');
        $current_periode = $periode->getOpenPeriode();
        //print_r($current_periode);
        $proses->setPeriode($current_periode[0]);

        if ($this->input->post('export')) {
            $params = array(
                'paging' => array('row' => '0', 'segment' => '0')
            );
        } else {
            $params = array(
                'paging' => array('row' => 10, 'segment' => $segment)
            );
        }
        $params['field']['registrasi.periode'] = $current_periode[0];
        if ($id_registrasi != '') {
            $params['field']['registrasi.id_registrasi'] = $id_registrasi;
        }
        if ($yayasan != '') {
            $params['join']['tbl_badan_penyelenggara'] = 'registrasi.kdpti = tbl_badan_penyelenggara.kdpti';
            $params['field']['tbl_badan_penyelenggara.nama_penyelenggara'] = $yayasan;
        }
        if ($pti != '') {
            $params['join']['tbl_pti'] = 'registrasi.kdpti = tbl_pti.kdpti';
            $params['field']['tbl_pti.nmpti'] = $pti;
        }
        if ($jns_usulan != '') {
            $params['field']['registrasi.jns_usulan'] = $jns_usulan;
        }
        if ($evaluator != '') {
            $params['join']['evaluator'] = "proses.id_evaluator = evaluator.id_evaluator";
            $params['field']['evaluator.nm_evaluator'] = $evaluator;
        }

        if ($status_proses != '') {
            $params['join']['status_proses'] = "proses.id_status_proses = status_proses.id_status_proses";
            $params['field']['status_proses.id_status_proses'] = $status_proses;
        }

        $user = new ModUsers($this->session->userdata('userid'));
        if ($user->getIdEvaluator() != '') {
            //  $params['field']['proses.id_evaluator'] = $user->getIdEvaluator();
            //  $params['field']['proses.id_status_proses'] = array('1','2');
        }

        $result_proses = $proses->search($params);

        //config pagination                     
        $per_page = 10;
        $params['count'] = array('1');
        $total_row = $proses->search($params);
        $base_url = base_url() . 'backoffice/kelolaproses/find/';
        setPagingTemplate($base_url, 4, $total_row, $per_page);

        //data jns_usulan
        $this->db->select('*');
        $this->db->from('jenis_usulan');
        $res_jns_usulan = $this->db->get();
        $option_jns_usulan = array('' => '~Pilih~');
        foreach ($res_jns_usulan->result() as $value) {
            $option_jns_usulan[$value->jns_usulan] = $value->nm_usulan;
        }

        //data status
        $obj_status_proses = new StatusProses();
        $result_status = $obj_status_proses->get('0', '0');
        $option_status = array('' => '~Pilih~');
        foreach ($result_status->result() as $value) {
            $option_status[$value->id_status_proses] = $value->nama_status;
        }
        $data['status_proses'] = $option_status;
        $data['jns_usulan'] = $option_jns_usulan;
        $data['proses'] = $result_proses;
        $data['total_row'] = $total_row;

        if ($this->input->post('export')) {
            $this->load->view('export_proses', $data);
            //print_r($result);
        } else {
            showNewBackEnd($view, $data, 'index-1');
        }
    }

    public function _index() {
        $view = 'list_proses';

        $proses = new Proses();
        $segment = $this->uri->segment(4, 0);
        $per_page = 10;
        $periode = new Periode();
        $periode->getBy('status_periode', 'open');
        $current_periode = $periode->getOpenPeriode();
        //print_r($current_periode);
        $proses->setPeriode($current_periode[0]);

        $params = array(
            'paging' => array('row' => 10, 'segment' => $segment)
        );
        $params['field']['registrasi.periode'] = $current_periode[0];
        $result = $proses->search($params);
        $params['count'] = array('1');
        $total_row = $proses->search($params);
        $base_url = base_url() . 'backoffice/kelolaproses/index';
        setPagingTemplate($base_url, 4, $total_row, $per_page);

        //data status
        $status_proses = new StatusProses();
        $result_status = $status_proses->get('0', '0');
        $option_status = array('' => '~Pilih~');
        foreach ($result_status->result() as $value) {
            $option_status[$value->id_status_proses] = $value->nama_status;
        }

        //data jns_usulan
        $this->db->select('*');
        $this->db->from('jenis_usulan');
        $res_jns_usulan = $this->db->get();
        $option_jns_usulan = array('' => '~Pilih~');
        foreach ($res_jns_usulan->result() as $value) {
            $option_jns_usulan[$value->jns_usulan] = $value->nm_usulan;
        }
        $data['jns_usulan'] = $option_jns_usulan;
        $data['status_proses'] = $option_status;
        $data['proses'] = $result;
        $data['total_row'] = $total_row;
        showBackEnd($view, $data, 'index_new');
    }

    public function index() {
        $id_registrasi = trim($this->input->post('id_registrasi'));
        $yayasan = trim($this->input->post('yayasan'));
        $pti = trim($this->input->post('pti'));
        $jns_usulan = trim($this->input->post('jns_usulan'));
        $evaluator = trim($this->input->post('evaluator'));
        $status_proses = trim($this->input->post('status_proses'));
        $opt_periode = trim($this->input->post('periode'));
        $segment = $this->uri->segment(4, 0);
        $temp_post = $this->input->post(NULL, TRUE);
        if (!$temp_post) {
            $id_registrasi = trim($this->session->flashdata('id_registrasi'));
            $yayasan = trim($this->session->flashdata('yayasan'));
            $pti = trim($this->session->flashdata('pti'));
            $jns_usulan = trim($this->session->flashdata('jns_usulan'));
            $evaluator = trim($this->session->flashdata('evaluator'));
            $status_proses = trim($this->session->flashdata('status_proses'));
            $opt_periode = trim($this->session->flashdata('periode'));
        }
        $temp_filter = array(
            'id_registrasi' => $id_registrasi,
            'yayasan' => $yayasan,
            'pti' => $pti,
            'jns_usulan' => $jns_usulan,
            'evaluator' => $evaluator,
            'status_proses' => $status_proses,
            'periode' => $opt_periode
        );
        $this->session->set_flashdata($temp_filter);

        $proses = new Proses();
        $periode = new Periode();
        //$current_periode = $periode->getOpenPeriode();
        $temp_current_periode = $periode->getOpenPeriode();

        if ($opt_periode == '') {
            $current_periode = $temp_current_periode->periode;
        } else {
            $current_periode = $opt_periode;
        }
        $params = [];
        if ($this->input->post('export')) {
            $params['paging'] = ['row' => 0, 'segment' => 0];
        } else {
            $params['paging'] = ['row' => 10, 'segment' => $segment];
        }
        $table = 'proses';
        $params['join']['proses_registrasi'] = ['INNER' => $table . '.id_proses=proses_registrasi.id_proses'];
        $params['join']['registrasi'] = ['INNER' => 'registrasi.id_registrasi=proses_registrasi.id_registrasi'];
        //$params['field']['registrasi.periode'] = ['=' => $current_periode];

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
        if ($current_periode != '') {
            $params['field']['registrasi.periode'] = ['=' => $current_periode];
        }
        if ($evaluator != '') {
            $params['join']['evaluator'] = ['INNER' => "proses.id_evaluator = evaluator.id_evaluator"];
            $params['field']['evaluator.nm_evaluator'] = ['LIKE' => $evaluator];
        }

        if ($status_proses != '') {
            $params['join']['status_proses'] = ['INNER' => "proses.id_status_proses = status_proses.id_status_proses"];
            $params['field']['status_proses.id_status_proses'] = ['=' => $status_proses];
        }
        $params['order'] = ['tgl_kirim'=> 'DESC'];
        $result_proses = $proses->getResult($params);

        //config pagination                     
        $per_page = 10;
        $params['count'] = True;
        $total_row = $proses->getResult($params);
        $base_url = base_url() . 'backoffice/kelolaproses/index/';
        setPagingTemplate($base_url, 4, $total_row, $per_page);

        //data status
        $obj_status_proses = new StatusProses();
        $result_status = $obj_status_proses->get('0', '0');
        $option_status = array('' => '~Pilih~');
        foreach ($result_status->result() as $value) {
            $option_status[$value->id_status_proses] = $value->nama_status;
        }
        $data['status_proses'] = $option_status;
        $data['base_url'] = $base_url;
        $data['proses'] = $result_proses;
        $data['total_row'] = $total_row;
        $data['title'] = 'Daftar Proses Penilaian (Admin)';

        if ($this->input->post('export')) {
            $this->load->view('export_proses', $data);
            //print_r($result);
        } else {
            $view = 'list_proses';
            add_footer_js('js/app/index_proses.js');
            showNewBackEnd($view, $data, 'index-1');
        }
    }

    public function remove() {
        
    }

    public function save() {
        
    }

    public function indexEvaluator() {
        $id_registrasi = trim($this->input->post('id_registrasi'));
        $yayasan = trim($this->input->post('yayasan'));
        $pti = trim($this->input->post('pti'));
        $jns_usulan = trim($this->input->post('jns_usulan'));
        $evaluator = trim($this->input->post('evaluator'));
        $status_proses = trim($this->input->post('status_proses'));
        $opt_periode = trim($this->input->post('periode'));
        $segment = $this->uri->segment(4, 0);
        $temp_post = $this->input->post(NULL, TRUE);
        if (!$temp_post) {
            $id_registrasi = trim($this->session->flashdata('id_registrasi'));
            $yayasan = trim($this->session->flashdata('yayasan'));
            $pti = trim($this->session->flashdata('pti'));
            $jns_usulan = trim($this->session->flashdata('jns_usulan'));
            $evaluator = trim($this->session->flashdata('evaluator'));
            $status_proses = trim($this->session->flashdata('status_proses'));
            $opt_periode = trim($this->session->flashdata('periode'));
        }
        $temp_filter = array(
            'id_registrasi' => $id_registrasi,
            'yayasan' => $yayasan,
            'pti' => $pti,
            'jns_usulan' => $jns_usulan,
            'evaluator' => $evaluator,
            'status_proses' => $status_proses
        );
        $this->session->set_flashdata($temp_filter);

        $proses = new Proses();
        $periode = new Periode();
        $temp_current_periode = $periode->getOpenPeriode();
        $user = new ModUsers($this->session->userdata('userid'));
        $params = [];
        if ($this->input->post('export')) {
            $params['paging'] = ['row' => 0, 'segment' => 0];
        } else {
            $params['paging'] = ['row' => 10, 'segment' => $segment];
        }
        $table = 'proses';
        $params['join']['proses_registrasi'] = ['INNER' => $table . '.id_proses=proses_registrasi.id_proses'];
        $params['join']['registrasi'] = ['INNER' => 'registrasi.id_registrasi=proses_registrasi.id_registrasi'];
        //$params['field']['registrasi.periode'] = ['=' => $current_periode[0]];
        if ($opt_periode == '') {
            $current_periode = $temp_current_periode->periode;
        } else {
            $current_periode = $opt_periode;
        }
        $params['field']['proses.id_evaluator'] = ['=' => $user->getIdEvaluator()];
        $params['field'][$table . '.id_status_proses'] = ['IN' => [1, 2, 4]];
        if ($current_periode != '') {
            //$params['field']['registrasi.periode'] = ['=' => $current_periode];
        }

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

        if ($evaluator != '') {
            $params['join']['evaluator'] = ['INNER' => "proses.id_evaluator = evaluator.id_evaluator"];
            $params['field']['evaluator.nm_evaluator'] = ['LIKE' => $evaluator];
        }

        if ($status_proses != '') {
            $params['join']['status_proses'] = ['INNER' => "proses.id_status_proses = status_proses.id_status_proses"];
            $params['field']['status_proses.id_status_proses'] = ['=' => $status_proses];
        }
        //order
        $params['order'] = ['tgl_kirim'=> 'DESC'];

        $result_proses = $proses->getResult($params);

        //config pagination                     
        $per_page = 10;
        $params['count'] = True;
        $total_row = $proses->getResult($params);
        $base_url = base_url() . 'backoffice/kelolaproses/indexevaluator/';
        setPagingTemplate($base_url, 4, $total_row, $per_page);

        //data status
        $obj_status_proses = new StatusProses();
        $result_status = $obj_status_proses->get('0', '0');
        $option_status = array('' => '~Pilih~');
        foreach ($result_status->result() as $value) {
            $option_status[$value->id_status_proses] = $value->nama_status;
        }
        $data['status_proses'] = $option_status;
        //$data['jns_usulan'] = $option_jns_usulan;
        $data['proses'] = $result_proses;
        $data['total_row'] = $total_row;
        $data['base_url'] = $base_url;
        $data['title'] = 'Daftar Proses Penilaian (Evaluator)';

        if ($this->input->post('export')) {
            $this->load->view('export_proses', $data);
        } else {
            $view = 'list_proses';
            add_footer_js('js/app/index_proses.js');
            showNewBackEnd($view, $data, 'index-1');
        }
    }

    public function downloadInstrument() {
        //if($this->sessionutility->validateAccess($this)){
        //$this->load->library('zip');
        $id_proses = $this->uri->segment(4, 0);
        $proses = new Proses($id_proses);
        $registrasi = $proses->getRegistrasi(); //new Registrasi($id_reg);
        //$proses = $registrasi->getProses();
        $eval = $this->session->userdata('userid');
        //$account = $registrasi->getAccount();
        //$yayasan = $account->getYayasan();
        $pt = $registrasi->getPti();
        //$status = $registrasi->getStatusRegistrasi();
        $schema = $registrasi->getSchema();
        $filepath = '';
        /* if($schema=='C'){
          $filepath = realpath(APPPATH . '../assets/documents/template_penilaian_2019.xlsx');
          }elseif($schema=='B' || $schema=='A'){
          $filepath = realpath(APPPATH . '../assets/documents/template_penilaian_skema_b.xlsx');
          } */
        $filepath = realpath(APPPATH . '../assets/documents/Template-Penilaian-P3TV-PTS-2024.xlsx');

        $name = $registrasi->getIdRegistrasi() . '_' . str_replace(' ', '_', $pt->getNmPti()) . '_' . $eval . '.xlsx';
        //$archive = realpath(APPPATH . '../assets/documents/');
        if (is_file($filepath)) {
            $proses->setIdStatusProses('2'); //proses penilaian
            $proses->setTglTerima(date('Y-m-d'));
            $proses->update();
            $registrasi->setIdStatusRegistrasi('3'); //evaluasi
            $registrasi->update();
            $data = file_get_contents($filepath);
            force_download($name, $data);
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Gagal membuka file, atau instrumen tidak tersedia!");';
            echo 'window.history.back(1)';
            echo '</script>';
        }
        /* }else{
          echo '<script>';
          echo 'alert("Validation Fail !");';
          echo 'window.history.back(1);';
          echo '</script>';
          } */
    }

    public function detailDocument($id_reg) {
        $view = 'detail_registrasi';
        //$registrasi = new Registrasi($id_reg);
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

        $this->db->select('tbl_detail_paket_hibah.*, tbl_terima_barang.id_terima, tbl_terima_barang.receive_date');
        $this->db->from('tbl_detail_paket_hibah');
        $this->db->join('tbl_terima_barang', 'tbl_detail_paket_hibah.id = tbl_terima_barang.id_detail_paket', 'left');
        $this->db->where('tbl_detail_paket_hibah.id_registrasi', $id_reg);
        $terima_barang = $this->db->get();

        $data['data_prodi'] = $prodi;
        $data['registrasi'] = $registrasi;
        $data['danas'] = $res_dana;
        $data['terima_barang'] = $terima_barang;
        add_footer_js('tinymce/tinymce.min.js');
        add_footer_js('js/app/registrasi.js');
        showNewBackEnd($view, $data, 'index-1');
    }

    public function getLinkMonitoring() {

        $id_proses = $this->uri->segment(4, 0);
        $kdpti = $this->uri->segment(5, 0);
        //$user = $this->session->userdata('userid');
        $proses = new Proses($id_proses);
        $proses->setIdStatusProses('2'); //proses penilaian
        $proses->setTglTerima(date('Y-m-d'));
        $proses->update();

        $registrasi = $proses->getRegistrasi();
        $status = array('7', '9');
        if (!in_array($registrasi->getIdStatusRegistrasi(), $status)) {
            $registrasi->setIdStatusRegistrasi('4'); //presentasi
            $registrasi->update();
        }

        $base_url = 'http://pppts.kemdikbud.go.id/'; //base_url();
        $url_monitoring = $base_url . 'site/alias-login-detail-usulan?id=' . $kdpti . '&admin=idc&id_registrasi=' . $registrasi->getIdRegistrasi();
        //$url_monitoring = $base_url.'registrasi/detail?id='.$registrasi->getIdRegistrasi();
        //echo 'url: '.$url_monitoring;
        redirect($url_monitoring);
    }

    public function getLinkBeritaAcara() {

        $id_proses = $this->uri->segment(4, 0);
        $kdpti = $this->uri->segment(5, 0);
        //$user = $this->session->userdata('userid');
        $proses = new Proses($id_proses);
        $proses->setIdStatusProses('2'); //proses penilaian
        $proses->setTglTerima(date('Y-m-d'));
        //$proses->update();

        $registrasi = $proses->getRegistrasi();
        $registrasi->setIdStatusRegistrasi('4'); //presentasi
        //$registrasi->update();
        $base_url = 'http://pppts.kemdikbud.go.id/'; //base_url();
        $url_monitoring = $base_url . 'download/berita-acara?id=' . $registrasi->getIdRegistrasi();
        redirect($url_monitoring);
    }

    public function getLinkBeritaAcaraFinal() {

        $id_proses = $this->uri->segment(4, 0);
        $kdpti = $this->uri->segment(5, 0);
        //$user = $this->session->userdata('userid');
        $proses = new Proses($id_proses);
        $proses->setIdStatusProses('2'); //proses penilaian
        $proses->setTglTerima(date('Y-m-d'));
        //$proses->update();

        $registrasi = $proses->getRegistrasi();
        $registrasi->setIdStatusRegistrasi('4'); //presentasi
        //$registrasi->update();
        $base_url = 'http://pppts.kemdikbud.go.id/'; //base_url();
        $url_monitoring = $base_url . 'download/berita-acara?id=' . $registrasi->getIdRegistrasi();
        redirect($url_monitoring);
    }

    public function getBeritaAcaraFinal() {
        $id_registrasi = $this->uri->segment(4);
        $registrasi = new Registrasi($id_registrasi);
        $jns_usulan = $registrasi->getJnsUsulan();

        $dokumen_template = '';
        //$qry = "SELECT * FROM tbl_direktorat_aktif WHERE status='Aktif'";
        //$res_query = $this->db->query($qry);
        //if ($res_query->num_rows() > 0) {
        //$row = $res_query->row();
        /* if($row->nama_direktorat=='Akademik'){
          if($jns_usulan=='01' || $jns_usulan=='03'){//barang
          $dokumen_template = './assets/documents/akademik/Format_Berita_Acara_Hasil_Final_Barang_dan_Gedung.docx';
          }elseif($jns_usulan=='02'){//gedung
          $dokumen_template = './assets/documents/akademik/Format_Berita_Acara_Hasil_Final_Gedung.docx';
          }
          }else{ */

        //}
        //}
        $periode = new Periode();
        $current_periode = $periode->getOpenPeriode();
        if ($current_periode->periode >= '20241') {
            $dokumen_template = './assets/documents/vokasi/BA-P3TV-PTS-2024 V2.docx';
        } else {
            if ($jns_usulan == '01' || $jns_usulan == '03') {//barang
                $dokumen_template = './assets/documents/vokasi/Format Berita Acara Finalisasi Program dan Anggaran 2023.docx';
            } elseif ($jns_usulan == '02') {//gedung
                $dokumen_template = './assets/documents/vokasi/Format_Berita_Acara_Hasil_Final_Gedung.docx';
            }
        }
        if (is_file($dokumen_template)) {
            $templateProcessor = new TemplateProcessor($dokumen_template);
        } else {
            exit("File not found!");
        }

        $yys = $registrasi->getPenyelenggara();
        $nama_yys = $yys->getNamaPenyelenggara();
        $pti = $registrasi->getPti();
        $periode = $registrasi->getPeriode();
        //$prodi = new Prodi();
        $nama_pt = str_replace('&', 'Dan', $pti->getNmPti());
        $reviewer_1 = ''; $reviewer_2 = '';
        $t_teknis = '';
        $result_proses = $registrasi->getProses2();
        //var_dump($result_proses->result());
        $r=0;
        foreach ($result_proses->result() as $row) {
            if ($row->type_evaluator == '1') {
                $evaluator = new Evaluator($row->id_evaluator);
                if($reviewer_1 == ''){
                    $reviewer_1 = $evaluator->getNmEvaluator();
                }else{
                    $reviewer_2 = $evaluator->getNmEvaluator();
                }
                
            } elseif ($row->type_evaluator == '2') {
                $evaluator = new Evaluator($row->id_evaluator);
                $t_teknis = $evaluator->getNmEvaluator();
            }
            $r++;
        }
        $lab_ipa = 0;
        $lab_kes = 0;
        $lab_teknik = 0;
        $lab_micro = 0;
        $lab_bahasa = 0;
        $alat_ti = 0;
        $kitchen = 0;
        $kelas = 0;
        $laboratorium = 0;
        $total = 0;
        if ($jns_usulan == '01' || $jns_usulan == '03') {//barang
            $query = "SELECT
            ti.kd_sub2_kategori,ti.nm_sub2_kategori,
            IF (harga_satuan > 1, '1', '-') AS paket,
             harga_satuan,
             jumlah_biaya
            FROM
                    tbl_item_sub2kategori ti
            JOIN tbl_item_subkategori c ON ti.kd_sub_kategori = c.kd_sub_kategori
            LEFT JOIN (
                    SELECT
                            SUM(
                                    a.subtotal - (a.ongkir_satuan * a.jml_item)
                            ) AS harga_satuan,
                            SUM(a.subtotal) AS jumlah_biaya,
                            b.kd_barang
                    FROM
                            tbl_item_hibah a
                    JOIN tbl_item_barang b ON a.id_item = b.id_item
                    WHERE
                            id_registrasi = '" . $id_registrasi . "' AND periode='" . $periode . "'
                    GROUP BY
                            LEFT (a.id_item, 6)
            ) AS a ON ti.kd_sub2_kategori = LEFT (a.kd_barang, 6)
            WHERE
                    c.skema = 'A'
                    GROUP BY ti.kd_sub2_kategori";

            $result = $this->db->query($query);
            //print_r($result->result());
            foreach ($result->result() as $row) {

                if ($row->kd_sub2_kategori == '013301') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_teknik = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '013401') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $alat_ti = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '013101') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_ipa = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '0132001') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_bahasa = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '013201') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_kes = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '0130401') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_micro = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '020501') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $kelas = $row->jumlah_biaya;
                }
                if ($row->kd_sub2_kategori == '020601') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $laboratorium = $row->jumlah_biaya;
                }
                if ($row->kd_sub2_kategori == '013501') {
                    $kitchen = $row->jumlah_biaya;
                }
            }

            //$ppn = ($total * 10)/100;
            //$temp_total_ppn = $total + $ppn ;

            $templateProcessor->setValue('lab_ipa', number_format($lab_ipa, 2));
            $templateProcessor->setValue('lab_kes', number_format($lab_kes, 2));
            $templateProcessor->setValue('lab_teknik', number_format($lab_teknik, 2));
            $templateProcessor->setValue('lab_micro', number_format($lab_micro, 2));
            $templateProcessor->setValue('lab_bahasa', number_format($lab_bahasa, 2));
            $templateProcessor->setValue('alat_ti', number_format($alat_ti, 2));
            $templateProcessor->setValue('kitchen', number_format($kitchen, 2));
            $templateProcessor->setValue('kelas', number_format($kelas, 2));
            $templateProcessor->setValue('laboratorium', number_format($laboratorium, 2));

            $templateProcessor->setValue('yys', $nama_yys);
            $templateProcessor->setValue('pt', $nama_pt);
            $templateProcessor->setValue('reviewer_1', $reviewer_1);
            $templateProcessor->setValue('reviewer_2', $reviewer_2);
            $templateProcessor->setValue('t_teknis', $t_teknis);

            //date_default_timezone_set("Asia/Bangkok");
            $templateProcessor->setValue('dd', date('d'));
            $templateProcessor->setValue('mm', date('m'));
            $templateProcessor->setValue('yyyy', date('Y'));
            //bagian gedung
            $qry = "SELECT a.id_item,SUM(a.subtotal) AS jumlah_biaya 
            FROM tbl_item_hibah a
            JOIN tbl_item_gedung b ON a.id_item = b.kd_gedung
            WHERE id_registrasi = '" . $id_registrasi . "'
            GROUP BY a.id_item";
            $result2 = $this->db->query($qry);
            if ($result2->num_rows() > 0) {
                foreach ($result2->result() as $row) {
                    if ($row->id_item = '020501') {//kelas
                        $kelas = $row->jumlah_biaya;
                    } else {
                        $laboratorium = $row->jumlah_biaya;
                    }
                    $total = $total + $row->jumlah_biaya;
                }
                $templateProcessor->setValue('kelas', number_format($kelas, 2));
                $templateProcessor->setValue('laboratorium', number_format($laboratorium, 2));
                //$templateProcessor->setValue('total', $total);
            }
            $total = ($lab_ipa + $lab_kes + $lab_teknik + 
                    $lab_micro + $lab_bahasa + $alat_ti + 
                    $kelas + $laboratorium + $kitchen);
            $total_ppn = number_format($total, 2);
            $templateProcessor->setValue('total', $total_ppn);
            
            //output table luaran
            $luaran = new LuaranProgram();
            $params['paging'] = ['row' => 0, 'segment' => 0];
            $params['field'][LuaranProgram::table.'.id_registrasi'] = ['=' => $id_registrasi];
            $result = $luaran->getResult($params);
            $table = new Table(['borderSize' => 5, 'borderColor' => 'blue', 'unit' => TblWidth::AUTO]);
            if($result->num_rows()>0){
                //$table = new Table(['borderSize' => 5, 'borderColor' => 'blue', 'unit' => TblWidth::AUTO]);
                $table->addRow();
                
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Nama Prodi', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Ruang Lingkup', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Program Pengembangan', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Bentuk Luaran', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Jumlah Luaran', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Tahun Luaran', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Waktu Pelaksanaan', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Biaya', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Target IKU', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Keterangan', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $total = 0;
                foreach ($result->result() as $row) {
                    $table->addRow();
                    $table->addCell()->addText($row->nama_prodi);
                    $table->addCell()->addText($row->ruang_lingkup);
                    $table->addCell()->addText($row->program_pengembangan);
                    $table->addCell()->addText($row->bentuk_luaran);
                    $table->addCell()->addText($row->jumlah_luaran);
                    $table->addCell()->addText($row->tahun);
                    $table->addCell()->addText($row->waktu_pelaksanaan);
                    $table->addCell()->addText(number_format($row->biaya,2), ['bold'=>true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT]);
                    $table->addCell()->addText($row->target_iku);
                    $table->addCell()->addText($row->keterangan);
                    $total = $total + $row->biaya;
                }
                $table->addRow();
                $table->addCell(null, ['gridSpan' => 7, 'valign' => 'center'])
                        ->addText('Total (Rupiah):', ['bold'=>true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
                $table->addCell()->addText(number_format($total, 2), ['bold'=>true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT]);
                $table->addCell();
                $table->addCell();
                
            }else{
                
                $table->addRow();
                
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Nama Prodi', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Ruang Lingkup', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Program Pengembangan', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Bentuk Luaran', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Jumlah Luaran', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Tahun Luaran', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Waktu Pelaksanaan', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Biaya', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Target IKU', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(null, ['bgColor' => '#B4C6E7', 'valign' => 'center'])->addText('Keterangan', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addRow();
                $table->addCell();
                $table->addCell();
                $table->addCell();
                $table->addCell();
                $table->addCell();
                $table->addCell();
                $table->addCell();
                $table->addCell();
                $table->addCell();
                $table->addCell();
            }
            /*$title = new TextRun();
            $title->addText('This title has been set ', ['bold' => true, 'italic' => true, 'color' => 'blue']);
            $title->addText('dynamically', ['bold' => true, 'italic' => true, 'color' => 'red', 'underline' => 'single']);
            $templateProcessor->setComplexBlock('title', $title);

            $inline = new TextRun();
            $inline->addText('by a red italic text', ['italic' => true, 'color' => 'red']);
            $templateProcessor->setComplexValue('inline', $inline);*/
            $templateProcessor->setComplexBlock('table', $table);
            
            
        } elseif ($jns_usulan == '02') {
            $qry = "SELECT a.id_item,SUM(a.subtotal) AS jumlah_biaya 
            FROM tbl_item_hibah a
            JOIN tbl_item_gedung b ON a.id_item = b.kd_gedung
            WHERE id_registrasi = '" . $id_registrasi . "'
            GROUP BY a.id_item";
            $result = $this->db->query($qry);
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $row) {
                    if ($row->id_item == '020501') {//kelas
                        $kelas = $row->jumlah_biaya;
                    } elseif ($row->id_item == '020601') {
                        $laboratorium = $row->jumlah_biaya;
                    }
                    $total = $total + $row->jumlah_biaya;
                }
                $templateProcessor->setValue('yys', $nama_yys);
                $templateProcessor->setValue('pt', $nama_pt);
                $templateProcessor->setValue('reviewer', $reviewer);
                $templateProcessor->setValue('t_teknis', $t_teknis);
                $templateProcessor->setValue('kelas', number_format($kelas, 2));
                $templateProcessor->setValue('laboratorium', number_format($laboratorium, 2));
                $templateProcessor->setValue('total', number_format($total, 2));
                $templateProcessor->setValue('dd', date('d'));
                $templateProcessor->setValue('mm', date('F'));
                $templateProcessor->setValue('yyyy', date('Y'));
            }
        }
        $filename = $id_registrasi . '_' . str_replace(' ', '_', $nama_pt) . '_berita_acara_final.docx';

        header('Content-Type: application/msword');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $templateProcessor->saveAs('php://output');
    }

    public function getDraftBeritaAcara() {
        $id_registrasi = $this->uri->segment(4);
        $registrasi = new Registrasi($id_registrasi);
        $jns_usulan = $registrasi->getJnsUsulan();

        $dokumen_template = '';
        $qry = "SELECT * FROM tbl_direktorat_aktif WHERE status='Aktif'";
        $res_query = $this->db->query($qry);
        if ($res_query->num_rows() > 0) {
            $row = $res_query->row();
            /* if($row->nama_direktorat=='Akademik'){
              if($jns_usulan=='01' || $jns_usulan=='03'){//barang
              $dokumen_template = './assets/documents/akademik/Format_Draf_Berita_Acara_Barang_dan_Gedung.docx';
              }elseif($jns_usulan=='02'){//gedung
              $dokumen_template = './assets/documents/akademik/Format_Draf_Berita_Acara_Gedung.docx';
              }
              }else{ */
            if ($jns_usulan == '01' || $jns_usulan == '03') {//barang
                $dokumen_template = './assets/documents/vokasi/Format_Berita_Acara_Finalisasi_Program_dan_Anggaran_2022';
            } elseif ($jns_usulan == '02') {//gedung
                //$dokumen_template = './assets/documents/vokasi/Format_Draf_Berita_Acara_Gedung.docx';
            }

            //}
        }

        if (is_file($dokumen_template)) {
            $templateProcessor = new TemplateProcessor($dokumen_template);
        } else {
            exit("File not found!");
        }

        $yys = $registrasi->getPenyelenggara();
        $nama_yys = $yys->getNamaPenyelenggara();
        $pti = $registrasi->getPti();
        $nama_pt = $pti->getNmPti();
        $reviewer = '';
        $t_teknis = '';
        $result_proses = $registrasi->getProses2();
        foreach ($result_proses as $obj) {
            if ($obj->getTypeEvaluator() == '1') {
                $evaluator = $obj->getEvaluator();
                $reviewer = $evaluator->getNmEvaluator();
            } elseif ($obj->getTypeEvaluator() == '2') {
                $evaluator = $obj->getEvaluator();
                $t_teknis = $evaluator->getNmEvaluator();
            }
        }
        $lab_ipa = 0;
        $lab_kes = 0;
        $lab_teknik = 0;
        $lab_micro = 0;
        $lab_bahasa = 0;
        $alat_ti = 0;
        $kelas = 0;
        $laboratorium = 0;
        $total = 0;
        if ($jns_usulan == '01' || $jns_usulan == '03') {//barang
            $query = "SELECT
            ti.kd_sub2_kategori,ti.nm_sub2_kategori,
            IF (harga_satuan > 1, '1', '-') AS paket,
             harga_satuan,
             jumlah_biaya
            FROM
                    tbl_item_sub2kategori ti
            JOIN tbl_item_subkategori c ON ti.kd_sub_kategori = c.kd_sub_kategori
            LEFT JOIN (
                    SELECT
                            SUM(
                                    a.subtotal - (a.ongkir_satuan * a.jml_item)
                            ) AS harga_satuan,
                            SUM(a.subtotal) AS jumlah_biaya,
                            b.kd_barang
                    FROM
                            tbl_item_hibah a
                    JOIN tbl_item_barang b ON a.id_item = b.id_item
                    WHERE
                            id_registrasi = '" . $id_registrasi . "'
                    GROUP BY
                            LEFT (a.id_item, 6)
            ) AS a ON ti.kd_sub2_kategori = LEFT (a.kd_barang, 6)
            WHERE
                    c.skema = 'A'";

            $result = $this->db->query($query);
            //print_r($result->result());
            foreach ($result->result() as $row) {
                if ($row->kd_sub2_kategori == '013501') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_teknik = $row->jumlah_biaya; // + $ppn;
                }
                if ($row->kd_sub2_kategori == '013601') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $alat_ti = $row->jumlah_biaya; // + $ppn;
                }
                if ($row->kd_sub2_kategori == '013101') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_ipa = $row->jumlah_biaya; // + $ppn;
                }
                if ($row->kd_sub2_kategori == '013201') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_bahasa = $row->jumlah_biaya; // + $ppn;
                }
                if ($row->kd_sub2_kategori == '013301') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_kes = $row->jumlah_biaya; // + $ppn;
                }
                if ($row->kd_sub2_kategori == '013401') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_micro = $row->jumlah_biaya; // + $ppn;
                }
                if ($row->kd_sub2_kategori == '020501') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $kelas = $row->jumlah_biaya;
                }
                if ($row->kd_sub2_kategori == '020601') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $laboratorium = $row->jumlah_biaya;
                }
            }

            //$ppn = ($total * 10)/100;
            //$temp_total_ppn = $total + $ppn ;

            $templateProcessor->setValue('lab_ipa', number_format($lab_ipa, 2));
            $templateProcessor->setValue('lab_kes', number_format($lab_kes, 2));
            $templateProcessor->setValue('lab_teknik', number_format($lab_teknik, 2));
            $templateProcessor->setValue('lab_micro', number_format($lab_micro, 2));
            $templateProcessor->setValue('lab_bahasa', number_format($lab_bahasa, 2));
            $templateProcessor->setValue('alat_ti', number_format($alat_ti, 2));
            $templateProcessor->setValue('kelas', number_format($kelas, 2));
            $templateProcessor->setValue('laboratorium', number_format($laboratorium, 2));

            $templateProcessor->setValue('yys', $nama_yys);
            $templateProcessor->setValue('pt', $nama_pt);
            $templateProcessor->setValue('reviewer', $reviewer);
            $templateProcessor->setValue('t_teknis', $t_teknis);
            $templateProcessor->setValue('dd', date('d'));
            $templateProcessor->setValue('mm', date('F'));
            $templateProcessor->setValue('yyyy', date('Y'));
            //bagian gedung
            $qry = "SELECT a.id_item,SUM(a.subtotal) AS jumlah_biaya 
            FROM tbl_item_hibah a
            JOIN tbl_item_gedung b ON a.id_item = b.kd_gedung
            WHERE id_registrasi = '" . $id_registrasi . "'
            GROUP BY a.id_item";
            $result2 = $this->db->query($qry);
            if ($result2->num_rows() > 0) {
                foreach ($result2->result() as $row) {
                    if ($row->id_item = '020501') {//kelas
                        $kelas = $row->jumlah_biaya;
                    } else {
                        $laboratorium = $row->jumlah_biaya;
                    }
                    $total = $total + $row->jumlah_biaya;
                }
                $templateProcessor->setValue('kelas', number_format($kelas, 2));
                $templateProcessor->setValue('laboratorium', number_format($laboratorium, 2));
                //$templateProcessor->setValue('total', $total);
            }
            $total = ($lab_ipa + $lab_kes + $lab_teknik + $lab_micro + $lab_bahasa + $alat_ti + $kelas + $laboratorium);
            $total_ppn = number_format($total, 2);
            $templateProcessor->setValue('total', $total_ppn);
        } elseif ($jns_usulan == '02') {
            $qry = "SELECT a.id_item,SUM(a.subtotal) AS jumlah_biaya 
            FROM tbl_item_hibah a
            JOIN tbl_item_gedung b ON a.id_item = b.kd_gedung
            WHERE id_registrasi = '" . $id_registrasi . "'
            GROUP BY a.id_item";
            $result = $this->db->query($qry);
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $row) {
                    if ($row->id_item == '020501') {//kelas
                        $kelas = $row->jumlah_biaya;
                    } elseif ($row->id_item == '020601') {
                        $laboratorium = $row->jumlah_biaya;
                    }
                    $total = $total + $row->jumlah_biaya;
                }
                $templateProcessor->setValue('yys', $nama_yys);
                $templateProcessor->setValue('pt', $nama_pt);
                $templateProcessor->setValue('reviewer', $reviewer);
                $templateProcessor->setValue('t_teknis', $t_teknis);
                $templateProcessor->setValue('kelas', number_format($kelas, 2));
                $templateProcessor->setValue('laboratorium', number_format($laboratorium, 2));
                $templateProcessor->setValue('total', number_format($total, 2));
                $templateProcessor->setValue('dd', date('d'));
                $templateProcessor->setValue('mm', date('F'));
                $templateProcessor->setValue('yyyy', date('Y'));
            }
        }
        $filename = $id_registrasi . '_' . str_replace(' ', '_', $nama_pt) . '_draft_berita_acara.docx';

        header('Content-Type: application/msword');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $templateProcessor->saveAs('php://output');
    }

    public function getPaktaKesepakatan() {
        $id_registrasi = $this->uri->segment(4);
        $registrasi = new Registrasi($id_registrasi);
        $pt = $registrasi->getPti();
        $dokumen_template = '';
        //$qry = "SELECT * FROM tbl_direktorat_aktif WHERE status='Aktif'";
        //$res_query = $this->db->query($qry);
        /* if ($res_query->num_rows() > 0) {
          $row = $res_query->row();
          if ($row->nama_direktorat == 'Akademik') {
          //$dokumen_template = realpath(APPPATH . '../assets/documents/akademik/Format_Pakta_Kesepakatan_Pengadaan_Barang_PP-PTS_2020.docx');
          } else {
          $dokumen_template = realpath(APPPATH . '../assets/documents/vokasi/Format Pakta Kesepakatan Pengadaan Barang PPPTV-PTS 2023.docx');
          //$dokumen_template = realpath(APPPATH . '../assets/documents/vokasi/Format_Pakta_Kesepakatan_Pengadaan_Barang_PPPTV-PTS_2021.docx');
          }

          } */
        $periode = new Periode();
        $current_periode = $periode->getOpenPeriode();
        if ($current_periode->periode >= '20241') {
            $dokumen_template = realpath(APPPATH . '../assets/documents/vokasi/Format Pakta Kesepakatan Pengadaan Barang PPPTV-PTS 2024.docx');
        } else {
            $dokumen_template = realpath(APPPATH . '../assets/documents/vokasi/Format Pakta Kesepakatan Pengadaan Barang PPPTV-PTS 2023.docx');
        }
        $name = $registrasi->getIdRegistrasi() . '_' . str_replace(' ', '_', $pt->getNmPti()) . '_pakta_kesepakatan' . '.docx';
        $nama_pt = str_replace('&', 'Dan', $pt->getNmPti());
        if (is_file($dokumen_template)) {
            $templateProcessor = new TemplateProcessor($dokumen_template);
            $this->db->select('*');
            $this->db->from('jadwal_presentasi');
            $this->db->where('id_registrasi', $id_registrasi);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $templateProcessor->setValue('noSurat', $row->no_surat);
                $templateProcessor->setValue('nmpti', $pt->getNmPti());
            } else {
                $templateProcessor->setValue('noSurat', '-');
            }
            $lab_ipa = 0;
            $lab_kes = 0;
            $lab_teknik = 0;
            $lab_micro = 0;
            $lab_bahasa = 0;
            $alat_ti = 0;
            $kitchen = 0;
            $kelas = 0;
            $laboratorium = 0;
            $total = 0;
            //if ($jns_usulan == '01' || $jns_usulan == '03') {//barang
            $query = "SELECT
            ti.kd_sub2_kategori,ti.nm_sub2_kategori,
            IF (harga_satuan > 1, '1', '-') AS paket,
             harga_satuan,
             jumlah_biaya
            FROM
                    tbl_item_sub2kategori ti
            JOIN tbl_item_subkategori c ON ti.kd_sub_kategori = c.kd_sub_kategori
            LEFT JOIN (
                    SELECT
                            SUM(
                                    a.subtotal - (a.ongkir_satuan * a.jml_item)
                            ) AS harga_satuan,
                            SUM(a.subtotal) AS jumlah_biaya,
                            b.kd_barang
                    FROM
                            tbl_item_hibah a
                    JOIN tbl_item_barang b ON a.id_item = b.id_item
                    WHERE
                            id_registrasi = '" . $id_registrasi . "' AND periode='" . $registrasi->getPeriode() . "'
                    GROUP BY
                            LEFT (a.id_item, 6)
            ) AS a ON ti.kd_sub2_kategori = LEFT (a.kd_barang, 6)
            WHERE
                    c.skema = 'A'
                    GROUP BY ti.kd_sub2_kategori";

            $result2 = $this->db->query($query);
            //print_r($result->result());
            foreach ($result2->result() as $row) {


                //     013301	Laboratorium Teknologi Informasi dan Desain Komunikasi
                //013101	Laboratorium IPA Dasar
                // 013201	Laboratorium Kesehatan Dasar
                // 013401	Laboratorium Teknik Dasar
                if ($row->kd_sub2_kategori == '013301') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_teknik = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '013401') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $alat_ti = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '013101') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_ipa = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '0132001') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_bahasa = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '013201') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_kes = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '0130401') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $lab_micro = $row->jumlah_biaya; //+ $ppn;
                }
                if ($row->kd_sub2_kategori == '020501') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $kelas = $row->jumlah_biaya;
                }
                if ($row->kd_sub2_kategori == '020601') {
                    //$ppn = ($row->jumlah_biaya * 10) / 100;
                    $laboratorium = $row->jumlah_biaya;
                }
                if ($row->kd_sub2_kategori == '013501') {
                    $kitchen = $row->jumlah_biaya;
                }
            }

            //$ppn = ($total * 10)/100;
            //$temp_total_ppn = $total + $ppn ;

            $templateProcessor->setValue('lab_ipa', number_format($lab_ipa, 2));
            $templateProcessor->setValue('lab_kes', number_format($lab_kes, 2));
            $templateProcessor->setValue('lab_teknik', number_format($lab_teknik, 2));
            $templateProcessor->setValue('lab_micro', number_format($lab_micro, 2));
            $templateProcessor->setValue('lab_bahasa', number_format($lab_bahasa, 2));
            $templateProcessor->setValue('alat_ti', number_format($alat_ti, 2));
            $templateProcessor->setValue('kitchen', number_format($kitchen, 2));
            $templateProcessor->setValue('kelas', number_format($kelas, 2));
            //$templateProcessor->setValue('laboratorium', number_format($laboratorium, 2));
            $total = ($lab_ipa + $lab_kes + $lab_teknik + $lab_micro + $lab_bahasa + $alat_ti + $kelas + $laboratorium + $kitchen);
            $total_ppn = number_format($total, 2);
            $templateProcessor->setValue('total', $total_ppn);
            //$templateProcessor->setValue('yys', $nama_yys);
            //$templateProcessor->setValue('nmpti', $nama_pt);
            //$templateProcessor->setValue('reviewer', $reviewer);
            //$templateProcessor->setValue('t_teknis', $t_teknis);

            header('Content-Type: application/msword');
            header('Content-Disposition: attachment;filename="' . $name . '"');
            header('Cache-Control: max-age=0');
            $templateProcessor->saveAs('php://output');
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Gagal membuka file, atau instrumen tidak tersedia!");';
            echo 'window.history.back(1)';
            echo '</script>';
        }
    }

    public function getSuratTugas() {
        //$qry = "SELECT * FROM tbl_direktorat_aktif WHERE status='Aktif'";
        //$res_query = $this->db->query($qry);
        //$filepath = '';
        //if ($res_query->num_rows() > 0) {
        //$row = $res_query->row();
        /* if($row->nama_direktorat=='Akademik'){
          $filepath = realpath(APPPATH . '../assets/documents/Format_Surat_Tugas_Penerimaan_Barang_2020.docx');
          }else{
          $filepath = realpath(APPPATH . '../assets/documents/vokasi/Format Surat Tugas Penerimaan Barang PPPTV-PTS 2023.docx');

          //}
          } */
        $periode = new Periode();
        $current_periode = $periode->getOpenPeriode();
        if ($current_periode->periode >= '20241') {
            $filepath = realpath(APPPATH . '../assets/documents/vokasi/Format Surat Tugas Penerimaan Barang PPPTV-PTS 2024.docx');
        } else {
            $filepath = realpath(APPPATH . '../assets/documents/vokasi/Format Surat Tugas Penerimaan Barang PPPTV-PTS 2023.docx');
        }
        $id_registrasi = $this->uri->segment(4);
        $registrasi = new Registrasi($id_registrasi);
        $pt = $registrasi->getPti();
        $name = $registrasi->getIdRegistrasi() . '_' . str_replace(' ', '_', $pt->getNmPti()) . '_surat_tugas' . '.docx';
        //$archive = realpath(APPPATH . '../assets/documents/');
        if (is_file($filepath)) {

            $data = file_get_contents($filepath);
            force_download($name, $data);
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Gagal membuka file, atau instrumen tidak tersedia!");';
            echo 'window.history.back(1)';
            echo '</script>';
        }
    }

    public function getPernyataanPersetujuan() {
        //$qry = "SELECT * FROM tbl_direktorat_aktif WHERE status='Aktif'";
        //$res_query = $this->db->query($qry);
        //$filepath = '';
        /* if ($res_query->num_rows() > 0) {
          $row = $res_query->row();
          /* if($row->nama_direktorat=='Akademik'){
          $filepath = realpath(APPPATH . '../assets/documents/vokasi/Format_Pernyataan_Persetujuan.docx');
          }else{
          $filepath = realpath(APPPATH . '../assets/documents/vokasi/Format Surat Kesediaan Penerimaan Bantuan PPPTV-PTS 2023.docx');
          //}
          } */
        $periode = new Periode();
        $current_periode = $periode->getOpenPeriode();

        if ($current_periode->periode >= '20241') {
            $filepath = realpath(APPPATH . '../assets/documents/vokasi/Format Surat Kesediaan Penerimaan Bantuan PPPTV-PTS 2024.docx');
        } else {
            $filepath = realpath(APPPATH . '../assets/documents/vokasi/Format Surat Kesediaan Penerimaan Bantuan PPPTV-PTS 2023.docx');
        }
        $id_registrasi = $this->uri->segment(4);
        $registrasi = new Registrasi($id_registrasi);
        $pt = $registrasi->getPti();
        $name = $registrasi->getIdRegistrasi() . '_' . str_replace(' ', '_', $pt->getNmPti()) . '_pernyataan_persetujuan' . '.docx';
        //$archive = realpath(APPPATH . '../assets/documents/');
        if (is_file($filepath)) {

            $data = file_get_contents($filepath);
            force_download($name, $data);
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Gagal membuka file, atau instrumen tidak tersedia!");';
            echo 'window.history.back(1)';
            echo '</script>';
        }
    }

    public function getBapMonev() {

        //2023//$filepath = realpath(APPPATH . '../assets/documents/vokasi/Berita_Acara_monev_P3TVTS_2023.docx');
        $filepath = realpath(APPPATH . '../assets/documents/vokasi/Template BA Monev P3TV-PTS 2024.docx');

        $id_registrasi = $this->uri->segment(4);
        $registrasi = new Registrasi($id_registrasi);
        $pt = $registrasi->getPti();
        $name = $registrasi->getIdRegistrasi() . '_' . str_replace(' ', '_', $pt->getNmPti()) . '_bap' . '.docx';
        //$archive = realpath(APPPATH . '../assets/documents/');
        if (is_file($filepath)) {

            $data = file_get_contents($filepath);
            force_download($name, $data);
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Gagal membuka file, atau instrumen tidak tersedia!");';
            echo 'window.history.back(1)';
            echo '</script>';
        }
    }
}

?>