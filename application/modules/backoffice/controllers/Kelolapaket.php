<?php

require_once ('Icontroll.php');
//require_once APPPATH . 'third_party/PHPExcel.php';
//require_once APPPATH . 'third_party/PHPExcel/IOFactory.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//use ;
/**
 * @author siti
 * @version 1.0
 * @created 19-Jun-2017 14:53:14
 */
class KelolaPaket extends MX_Controller implements IControll {

    function __construct() {
        parent::__construct();
        $this->load->library('sessionutility');
        $this->load->library('form_validation');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
        $this->load->model('Paket');
        $this->load->model('Detailpakethibah');
        $this->load->model('Kirim');
        $this->load->model('Detailkirim');
        $this->load->model('Supplier');
        $this->load->model('Itemhibah');
        $this->load->model('Registrasi');
        $this->load->model('Barang');        
        $this->load->model('Itembarang');
        $this->load->model('Periode');
        $this->load->model('Terimabarang');
        $this->load->model('Rekapitulasi');
    }

    function __destruct() {
        
    }

    public function add() {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'form_paket';

            $data['flagInsert'] = 0;
            add_footer_css('jquery-ui-1.12.1/jquery-ui.css');
            add_footer_js('jquery-ui-1.12.1/jquery-ui.js');
            add_footer_js('js/app/index_paket.js');
            showNewBackEnd($view, $data, 'index-1');
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function edit() {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'form_paket';
            $id = $this->uri->segment(4);
            $paket = new Paket($id);

            $detail_paket = new DetailPaketHibah();
            $result = $detail_paket->getByRelated('tbl_detail_paket_hibah', 'id_paket', $paket->getId(), '0', '0');
            //print_r($result);
            $data['flagInsert'] = '1';
            $data['paket'] = $paket;
            $data['detail_paket'] = $result;
            add_footer_css('jquery-ui-1.12.1/jquery-ui.css');
            add_footer_js('jquery-ui-1.12.1/jquery-ui.js');
            add_footer_js('js/app/index_paket.js');
            showNewBackEnd($view, $data, 'index-1');
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function find() {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'list_paket';

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

            /* if($keyword==''){//next page
              $keyword = str_replace('%20',' ',$this->uri->segment(5));
              if($filter != 'all'){//with date
              $filter = $this->uri->segment(4);
              $keyword = str_replace('%20',' ',$this->uri->segment(5));
              $fdate = $this->uri->segment(6);
              $ldate = $this->uri->segment(7);
              $uri_segment = '8';
              $segment = $this->uri->segment(8);

              }
              }elseif ($filter=='all') {
              if($fdate=='' && $ldate==''){
              $fdate = date("Y").'-01-01';
              $ldate = date("Y-m-d");
              }
              } */
            $paket = new Paket();
            //$registrasi->setIdStatusRegistrasi('0');
            //$segment = $this->uri->segment(4,0);
            $per_page = 20;
            $total_row = 0;
            $result = '';
            //echo $filter;
            if ($this->input->post('export')) {
                //echo 'is export</br>';
                if ($filter == 'nama_supplier') {
                    $result = $paket->getByRelated('tbl_supplier', $filter, $keyword, $per_page, $segment);
                } elseif ($filter == 'nmpti') {
                    $result = $paket->getByRelated('tbl_pti', $filter, $keyword, $per_page, $segment);
                } elseif ($filter == 'id_registrasi') {
                    $result = $paket->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
                } elseif ($filter == 'no_kontrak') {
                    $result = $paket->getByRelated('tbl_paket', $filter, $keyword, $per_page, $segment);
                    $total_row = $paket->getByRelated('tbl_paket', $filter, $keyword);
                }
            } else {
                //echo 'is record</br>';
                if ($filter == 'nama_supplier') {
                    $result = $paket->getByRelated('tbl_supplier', $filter, $keyword, $per_page, $segment);
                    $total_row = $paket->getByRelated('tbl_supplier', $filter, $keyword);
                } elseif ($filter == 'nmpti') {
                    $result = $paket->getByRelated('tbl_pti', $filter, $keyword, $per_page, $segment);
                    $total_row = $paket->getByRelated('tbl_pti', $filter, $keyword);
                } elseif ($filter == 'id_registrasi') {
                    $result = $paket->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
                    $total_row = $paket->getByRelated('registrasi', $filter, $keyword);
                } elseif ($filter == 'no_kontrak') {
                    $result = $paket->getByRelated('tbl_paket', $filter, $keyword, $per_page, $segment);
                    $total_row = $paket->getByRelated('tbl_paket', $filter, $keyword);
                }
            }

            $base_url = base_url() . 'backoffice/kelolapaket/find/' . $filter . '/' . $keyword . '/';
            setPagingTemplate($base_url, 4, $total_row, $per_page);
            $data['paket'] = $result;
            $data['total_row'] = $total_row;
            $data['selected_filter'] = $filter;
            if ($this->input->post('export')) {
                $this->load->view('export_registrasi', $data);
                //print_r($result);
            } else {
                add_footer_js('js/app/list_paket.js');
                showNewBackEnd($view, $data, 'index-1');
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function index() {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'list_paket';

            $paket = new Paket();

            $segment = $this->uri->segment(4, 0);
            $per_page = 20;
            $result = $paket->get($per_page, $segment);
            $total_row = $paket->get();
            $base_url = base_url() . 'backoffice/kelolapaket/index';
            setPagingTemplate($base_url, 4, $total_row, $per_page);
            $data['paket'] = $result;
            $data['total_row'] = $total_row;
            add_footer_js('js/app/list_paket.js');
            showNewBackEnd($view, $data, 'index-1');
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function remove() {
        if ($this->sessionutility->validateAccess($this)) {
            $id = $this->uri->segment(4);
            $paket = new Paket($id);
            $paket->delete();
            $detail_paket = new DetailPaketHibah();
            $detail_paket->setIdPaket($id);
            $detail_paket->delete();
            redirect(base_url() . 'backoffice/kelolapaket/');
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function save() {
        if ($this->sessionutility->validateAccess($this)) {
            if ($this->input->is_ajax_request()) {
                $flag = trim($this->input->post('flaginsert'));
                $thn = date("Y");
                $bln = date("M");
                $file_path_excel = '/home/pppts/frontends/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/' . $bln . '/';

                if (!is_dir($file_path_excel)) {
                    mkdir($file_path_excel, 0777, true);
                }
                $config ['upload_path'] = $file_path_excel;
                $config ['allowed_types'] = 'doc|docx|pdf';
                $config ['max_size'] = 1024 * 4;
                $config ['encrypt_name'] = true;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('kontrakfile')) {
                    $error = trim(strip_tags($this->upload->display_errors()));
                    $response['response'] = 'false';
                    $response['error'] = $error;
                    echo json_encode($response);
                } else {
                    //echo 'file excel uploaded..</br>';
                    $data = $this->upload->data();
                    $this->form_validation->set_rules('id_supplier', 'Supplier', 'trim|required');
                    $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'trim|required');
                    $this->form_validation->set_rules('no_kontrak', 'No Kontrak', 'trim|required');
                    $this->form_validation->set_rules('adendum', 'Adendum', 'trim|required');

                    $nama_paket = trim($this->input->post('nama_paket'));
                    $idsupplier = trim($this->input->post('id_supplier'));
                    $no_kontrak = trim($this->input->post('no_kontrak'));
                    $tgl_kontrak = trim($this->input->post('tgl_kontrak'));
                    $tgl_akhir_kontrak = trim($this->input->post('tgl_akhir_kontrak'));
                    $adendum = trim($this->input->post('adendum'));

                    $id_paket = trim($this->input->post('id_paket'));

                    $bukti_kontrak = $data['full_path'];

                    $supplier = new Supplier($idsupplier);

                    if ($this->form_validation->run()) {
                        $paket = new Paket($id_paket);
                        //$paket->setId($id_paket);
                        $paket->setNamaPaket($nama_paket);
                        $paket->setSupplier($supplier);
                        $paket->setNoKontrak($no_kontrak);
                        $paket->setTglKontrak($tgl_kontrak);
                        $paket->setTglAkhirKontrak($tgl_akhir_kontrak);
                        $paket->setAdendum($adendum);
                        $paket->setFileBuktiKontrak($bukti_kontrak);
                        if ($flag == '0') {
                            $paket->insert();
                        } else {
                            $paket->update();
                        }
                        /* $view = 'form_paket';

                          $data['flagInsert'] = FALSE;
                          $data['paket'] = $paket;
                          showBackEnd($view, $data); */
                        $response['response'] = 'true';

                        $response['flaginsert'] = 1;
                        $response['id_paket'] = $paket->getId();
                        echo json_encode($response);
                    } else {
                        $error = trim(strip_tags(validation_errors()));
                        $response['error'] = $error;
                        $response['response'] = 'false';
                        echo json_encode($response);
                        /* echo '<script>';
                          echo 'alert("Error. ' . $error . '");';
                          echo 'window.history.back(1);';
                          echo '</script>'; */
                    }
                }
            } else {
                //$id_paket = trim($this->input->post('id_paket'));
                //$paket = new Paket($id_paket);
                //$paket->delete();
                redirect(base_url() . 'backoffice/kelolapaket/');
            }
        } else {
            echo "Validation Fail !";
        }
    }

    public function autocompleteSupplier() {
        if ($this->sessionutility->validateSession()) {
            $keyword = strtolower($this->input->post('term'));
            $supplier = new Supplier();


            $result = $supplier->getByRelated('tbl_supplier', 'nama_supplier', $keyword, '0', '0');
            $data['response'] = 'false';
            if (($result->num_rows()) > 0) {
                $data['response'] = 'true'; //Set response
                $data['message'] = array(); //Create array
                foreach ($result->result() as $row) {
                    $data['message'][] = array('label' => $row->nama_supplier, 'value' => $row->nama_supplier,
                        'kode' => $row->id);
                }
            }
            echo json_encode($data);
        } else {
            echo '<script>';
            echo 'alert("Session run out !");';
            echo '</script>';
        }
    }

    public function autocompletePt() {
        if ($this->sessionutility->validateSession()) {
            $keyword = strtolower($this->input->post('term'));

            $registrasi = new Registrasi();

            $result = $registrasi->getByRelated('pti', 'nmpti', $keyword, '0', '0');
            $data['response'] = 'false';
            if (($result->num_rows()) > 0) {
                $data['response'] = 'true'; //Set response
                $data['message'] = array(); //Create array
                foreach ($result->result() as $row) {
                    $data['message'][] = array('label' => $row->nmpti, 'value' => $row->nmpti,
                        'kode' => $row->id_registrasi);
                }
            }
            echo json_encode($data);
        } else {
            echo '<script>';
            echo 'alert("Session run out !");';
            echo '</script>';
        }
    }

    public function autocompleteBarang() {
        if ($this->sessionutility->validateSession()) {
            $keyword = strtolower($this->input->post('idregistrasi'));
            $supplier = new ItemHibah();
            $result = $supplier->getByRelated('tbl_item_hibah', 'id_registrasi', $keyword, '0', '0');
            $data['response'] = 'false';
            if (($result->num_rows()) > 0) {
                $data['response'] = 'true'; //Set response
                $data['message'] = array(); //Create array
                foreach ($result->result() as $row) {
                    $data['message'][] = array('label' => $row->barang, 'value' => $row->id_item,
                        'kode' => $row->id);
                }
            }
            echo json_encode($data);
        } else {
            echo '<script>';
            echo 'alert("Session run out !");';
            echo '</script>';
        }
    }

    public function saveDetail() {
        if ($this->input->is_ajax_request()) {
            $flag = trim($this->input->post('flag_detail'));
            $id_paket = trim($this->input->post('id_paket'));
            $no_kontrak = trim($this->input->post('no_kontrak'));
            $kontrak_adendum = trim($this->input->post('kontrak_adendum'));
            $thn = date("Y");
            $bln = date("M");
            $file_path_excel = '/home/pppts/frontends/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/' . $bln . '/';

            if (!is_dir($file_path_excel)) {
                mkdir($file_path_excel, 0777, true);
            }
            $config ['upload_path'] = $file_path_excel;
            $config ['allowed_types'] = 'xlsx|xls';
            $config ['max_size'] = '2000';

            $this->load->library('upload', $config);
            $detail_hibah = new DetailPaketHibah();
            if (!$this->upload->do_upload('userfiledetail')) {
                $error = trim(strip_tags($this->upload->display_errors()));
                $response['response'] = 'false';
                $response['error'] = $error;
                echo json_encode($response);
            } else {
                $data = $this->upload->data();
                $path = $data['full_path'];
                
                if($flag=='1'){
                    $detail_hibah->setIdPaket($id_paket);
                    $detail_hibah->delete();
                }

                //$objPHPExcel = PHPExcel_IOFactory::load($path);
                $objPHPExcel = IOFactory::load($path);
                $objPHPExcel->setActiveSheetIndex(0);
                $i = 2;
                $no = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                while (is_numeric($no)) {

                    $no = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                    $id_item = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                    $spek = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
                    $merk = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                    $type = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                    $kota = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
                    $volume = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
                    $kdpti = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
                    $hps = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();

                    $biaya_kirim = 0;
                    $total = $volume + $hps + $biaya_kirim;
                    if (!is_null($kdpti)) {
                        $registrasi = new Registrasi();
                        $registrasi->getBy('kdpti', $kdpti);
                        $id_registrasi = $registrasi->getIdRegistrasi();
                        $item_hibah = new ItemHibah();
                        $arr = array('id_item' => $id_item,
                            'id_registrasi' => $id_registrasi);
                        $item_hibah->getByArray($arr);
                        $ongkir = $item_hibah->getOngkirSatuan();
                        $total = $volume * $hps; // + $ongkir;

                        $detail_hibah->setId(0);
                        $detail_hibah->setIdPaket($id_paket);
                        $detail_hibah->setIdItem($id_item);
                        $detail_hibah->setIdRegistrasi($id_registrasi);
                        $detail_hibah->setMerk($merk);
                        $detail_hibah->setType($type);
                        $detail_hibah->setSpesifikasi($spek);
                        $detail_hibah->setVolume($volume);
                        $detail_hibah->setOnkir($ongkir);
                        $detail_hibah->setHps($hps);
                        $detail_hibah->setKdPti($kdpti);
                        $detail_hibah->setKota($kota);
                        $detail_hibah->setAdendumKe($kontrak_adendum);
                        $detail_hibah->setNoKontrak($no_kontrak);
                        $detail_hibah->setStatus('0');
                        $detail_hibah->setTotal($total);
                        $detail_hibah->insert();
                    }
                    $i++;
                }
                $response['response'] = 'true';
                $response['message'] = 'Data inserted!';
            }


            $record_detail = $detail_hibah->getByRelated('tbl_detail_paket_hibah', 'id_paket', $id_paket, '0', '0');
            if ($record_detail->num_rows() > 0) {
                foreach ($record_detail->result() as $row) {
                    $registrasi = new Registrasi($row->id_registrasi);
                    //$res_reg = $registrasi->getByRelated('registrasi', 'id_registrasi', $row->id_registrasi, '0', '0')->row();

                    $item_hibah = new ItemHibah();
                    $item_hibah->setIdRegistrasi($row->id_registrasi);
                    $item_hibah->getByArray(array('id_item' => $row->id_item, 
                        'id_registrasi' => $row->id_registrasi));
                    //$row_bar = $res_bar->result()->row();
                    $params = ['id_item' => $row->id_item, 'periode' => $registrasi->getPeriode()];
                    $barang = new ItemBarang($params);
                    //if (is_object($res_reg) && is_object($res_bar)) {
                        $response['record_detail'][] = array(
                            'id_registrasi' => $row->id_registrasi,
                            'adendum_ke' => $row->adendum_ke,
                            'id_detail_paket' => $row->id,
                            'kdpti' => $registrasi->getKdPti(),
                            'nama_barang' => $barang->getBarang(),
                            'merk' => $row->merk,
                            'type' => $row->type,
                            'volume' => $row->volume,
                            'biaya_kirim' => $item_hibah->getOngkirSatuan(),
                            'hps' => $row->hps,
                            'total' => $row->total,
                            'no_kontrak' => $row->no_kontrak);
                    //}
                }
            }else{
                $response['rows'] = $record_detail->num_rows();
            }
            //
            //$response['flaginsert'] = 1;
            //$response['id_detail_paket'] = $detail_hibah->getId();
            //$response['id_item'] = $id_item;

            echo json_encode($response);
        }
    }

    public function detail($id) {
        $view = 'detail_paket';

        $paket = new Paket($id);

        $detail_paket = new DetailPaketHibah();
        $result = $detail_paket->getByRelated('tbl_detail_paket_hibah', 'id_paket', $paket->getId(), '0', '0');
        //print_r($result);
        //$data['flagInsert'] = '1';
        $data['paket'] = $paket;
        $data['detail_paket'] = $result;
        showNewBackEnd($view, $data, 'index-1');
    }

    public function createForm() {
        $view = 'form_pemeriksaan';
        shownewBackEnd($view);
    }

    public function getForm() {
        //error_reporting(E_ALL);

        $id_reg = $this->uri->segment(4); //$this->input->post('kdpti');

        $kirim = new Kirim();

        $result = $kirim->getByRelated('tbl_kirim', 'id_registrasi', $id_reg, '0', '0');

        if ($result->num_rows() > 0) {
            $row = $result->row();
            $pts = new Pti($row->kdpti);
            $yys = new BadanPenyelenggara($row->kdpti);
            $detail = new DetailKirim();
            $nama_yys = $yys->getNamaPenyelenggara();

            // Create new PHPExcel object
            //$objPHPExcel = new PHPExcel();
            $objPHPExcel = new Spreadsheet();

            // Set document properties
            $objPHPExcel->getProperties()->setCreator("pppts.ristekdikti.go.id")
                    ->setLastModifiedBy("Admin")
                    ->setTitle("Form Monitoring PPPTS 2023")
                    ->setSubject("Laporan Monitoring PPPTS 2023");
            // Add some data
            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'BERITA ACARA MONITORING DAN EVALUASI');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', 'PEMBERIAN BANTUAN BARANG ');
            $objPHPExcel->getActiveSheet()->setCellValue('A3', 'PP-PTS TAHUN ANGGARAN 2023');
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Badan Hukum Penyelenggara: ' . $nama_yys);
            $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Kode PT: ' . $pts->getKdPti());
            $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Nama PT: ' . $pts->getNmPti());
            $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Kemajuan Fisik ( sesuai tanggal monev )');
            $objPHPExcel->getActiveSheet()->setCellValue('A10', 'No');
            $objPHPExcel->getActiveSheet()->setCellValue('B10', 'Nama Barang');
            $objPHPExcel->getActiveSheet()->setCellValue('C10', 'Merk & Spesifikasi');
            $objPHPExcel->getActiveSheet()->setCellValue('D10', 'Volume');
            $objPHPExcel->getActiveSheet()->setCellValue('E10', 'Kesesuaian');
            $objPHPExcel->getActiveSheet()->setCellValue('G10', 'Fungsi');
            $objPHPExcel->getActiveSheet()->setCellValue('I10', 'Tgl Terima');
            $objPHPExcel->getActiveSheet()->setCellValue('J10', 'Keterangan ( Garansi, Nomor Seri, Dll )');
            $objPHPExcel->getActiveSheet()->setCellValue('E11', 'Ya');
            $objPHPExcel->getActiveSheet()->setCellValue('F11', 'Tidak');
            $objPHPExcel->getActiveSheet()->setCellValue('G11', 'Ya');
            $objPHPExcel->getActiveSheet()->setCellValue('H11', 'Tidak');
            $r = 12;
            $no = 0;
            $mperiode = new Periode();
            $current_periode = $mperiode->getOpenPeriode();
            foreach ($result->result() as $row) {


                $result_detail = $detail->getByRelated('tbl_detail_kirim', 'id_kirim', $row->id, '0', '0');
                //isi data

                foreach ($result_detail->result() as $obj) {
                    $detail_hibah = new DetailPaketHibah();
                    $detail_hibah->getBy('id', trim($obj->id_detail_paket_hibah));
                    $params = ['id_item' => trim($detail_hibah->getIdItem()), 'periode' => $current_periode[0]];
                    $barang = new ItemBarang($params);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $r, ++$no);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $r, $barang->getBarang());
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $r, $detail_hibah->getMerk() . ' | ' . $detail_hibah->getType());
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $r)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $r, $obj->jumlah);
                    $r++;
                }
            }
            $bottom = $r - 1;

            $objPHPExcel->getActiveSheet()->setCellValue('A' . ++$r, 'Foto barang yang sudah diterima (terlampir)');
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ++$r, 'Catatan lainnya:');
            $r = $r + 7;
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $r, 'Team Monitoring Hibah PPPTS 2017');
            $objPHPExcel->getActiveSheet()->getStyle('A' . $r)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $r, 'Perwakilan dari');
            $objPHPExcel->getActiveSheet()->getStyle('E' . $r)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ++$r, 'Kementerian Riset Teknologi dan Pendidikan Tinggi');
            $objPHPExcel->getActiveSheet()->getStyle('A' . $r)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $r, $nama_yys);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $r)->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->setCellValue('A' . ++$r, 'No');
            $btop = $r;
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $r, 'Nama');
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $r, 'Tanda Tangan');

            $objPHPExcel->getActiveSheet()->setCellValue('E' . $r, 'No');
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $r, 'Nama');
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $r, 'Tanda Tangan');

            $objPHPExcel->getActiveSheet()->setCellValue('A' . ++$r, '1');
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $r, '1');
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ++$r, '2');
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $r, '2');
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ++$r, '3');
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $r, '3');
            $bbot = $r;


            //formating the look
            //merge cells
            $objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:J2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:J3');
            $objPHPExcel->getActiveSheet()->mergeCells('A10:A11');
            $objPHPExcel->getActiveSheet()->mergeCells('B10:B11');
            $objPHPExcel->getActiveSheet()->mergeCells('C10:C11');
            $objPHPExcel->getActiveSheet()->mergeCells('D10:D11');
            $objPHPExcel->getActiveSheet()->mergeCells('E10:F10');
            $objPHPExcel->getActiveSheet()->mergeCells('G10:H10');
            $objPHPExcel->getActiveSheet()->mergeCells('I10:I11');
            $objPHPExcel->getActiveSheet()->mergeCells('J10:J11');

            //column width
            //$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);

            //fonts
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E11')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F11')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('G11')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('H11')->getFont()->setBold(true);

            /*$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
            $thn = date("Y");
            $file_path_excel = '/home/pppts/frontends/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/temp/';
            if (!is_dir($file_path_excel)) {
                mkdir($file_path_excel, 0777, true);
            }
            $writer->save($file_path_excel . $pts->getNmPti() . '.xlsx');*/
            /* $objPHPExcel->getActiveSheet()->getStyle('A10:J11')->applyFromArray(
              array(
              'font'    => array(
              'bold'      => true
              ),
              'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              ),

              'fill' => array(
              'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
              'rotation'   => 90,
              'startcolor' => array(
              'argb' => 'FFA0A0A0'
              ),
              'endcolor'   => array(
              'argb' => 'FFFFFFFF'
              )
              )
              )
              );
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
              ); */
            //$objPHPExcel->getActiveSheet()->getStyle('A10:J'.$bottom)->applyFromArray($styleThinBlackBorderOutline);
            //$objPHPExcel->getActiveSheet()->getStyle('A'.$btop.':C'.$bbot)->applyFromArray($styleThinBlackBorderOutline);
            //$objPHPExcel->getActiveSheet()->getStyle('E'.$btop.':G'.$bbot)->applyFromArray($styleThinBlackBorderOutline);
            
            ////download
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $pts->getNmPti() . '.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('php://output');
        } else {
            echo '<script>';
            echo 'alert("Data tidak tersedia!");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function indexTerima() {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'list_terima_barang';

            $registrasi = new Registrasi();
            //$registrasi->setIdStatusRegistrasi('0');
            $segment = $this->uri->segment(4, 0);
            $per_page = 10;
            $periode = new Periode();
            $periode->getBy('status_periode', 'open');
            $current_periode = $periode->getOpenPeriode();
            $registrasi->setPeriode($current_periode);
            $registrasi->setIdStatusRegistrasi('9');

            $result = $registrasi->get($per_page, $segment);
            $total_row = $registrasi->get();
            $base_url = base_url() . 'backoffice/kelolapaket/indexterima';
            setPagingTemplate($base_url, 4, $total_row, $per_page);
            $data['registrasi'] = $result;
            $data['total_row'] = $total_row;
            add_footer_js('js/app/list_terima_barang.js');
            showNewBackEnd($view, $data, 'index-1');
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function findTerima() {
        if ($this->sessionutility->validateAccess($this)) {
            $view = 'list_terima_barang';

            $keyword = $this->input->post('keyword');
            $filter = $this->input->post('filter');
            $fdate = $this->input->post('tglawal');
            $ldate = $this->input->post('tglakhir');
            //echo $filter.','.$this->input->post('export');
            $uri_segment = '0';
            $segment = '0';

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
            $registrasi = new Registrasi();
            $registrasi->setIdStatusRegistrasi('0');
            $periode = new Periode();
            //$record_periode = $periode->get('0', '0');
            $current_periode = $periode->getOpenPeriode();

            $registrasi->setPeriode($current_periode);
            //$segment = $this->uri->segment(4,0);
            $per_page = 20;
            $total_row = 0;
            $result = '';
            //echo $filter;
            if ($this->input->post('export')) {
                //echo 'is export</br>';
                if ($filter == 'nmpti') {
                    $result = $registrasi->getByRelated('tbl_pti', $filter, $keyword, $per_page, $segment);
                } elseif ($filter == 'nama_penyelenggara') {
                    $result = $registrasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword, $per_page, $segment);
                } elseif ($filter == 'id_registrasi') {
                    $result = $registrasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
                } elseif ($filter == 'nama_status') {
                    $registrasi->setIdStatusRegistrasi('');
                    $result = $registrasi->getByRelated('status_registrasi', $filter, $keyword, $per_page, $segment);
                    $total_row = $registrasi->getByRelated('status_registrasi', $filter, $keyword);
                } elseif ($filter == 'all') {
                    $result = $registrasi->get('0', '0');
                }
            } else {
                //echo 'is record</br>';
                if ($filter == 'nmpti') {
                    $result = $registrasi->getByRelated('tbl_pti', $filter, $keyword, $per_page, $segment);
                    $total_row = $registrasi->getByRelated('tbl_pti', $filter, $keyword);
                } elseif ($filter == 'nama_penyelenggara') {
                    $result = $registrasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword, $per_page, $segment);
                    $total_row = $registrasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword);
                } elseif ($filter == 'id_registrasi') {
                    $result = $registrasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
                    $total_row = $registrasi->getByRelated('registrasi', $filter, $keyword);
                } elseif ($filter == 'nama_status') {
                    $result = $registrasi->getByRelated('status_registrasi', $filter, $keyword, $per_page, $segment);
                    $total_row = $registrasi->getByRelated('status_registrasi', $filter, $keyword);
                } elseif ($filter == 'all') {
                    $result = $registrasi->get($per_page, $segment);
                }
            }

            $base_url = base_url() . 'backoffice/kelolaregistrasi/find/' . $filter . '/' . $keyword . '/';
            setPagingTemplate($base_url, 4, $total_row, $per_page);
            $data['registrasi'] = $result;
            $data['total_row'] = $total_row;
            $data['selected_filter'] = $filter;
            if ($this->input->post('export')) {
                $this->load->view('export_registrasi', $data);
                //print_r($result);
            } else {
                //showBackEnd($view, $data, 'index_new');
                showNewBackEnd($view, $data, 'index-1');
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }
    
    public function listTerima($id_registrasi)
    {
        $this->db->select('tbl_detail_paket_hibah.*, tbl_terima_barang.id_terima, tbl_terima_barang.receive_date');
        $this->db->from('tbl_detail_paket_hibah');
        $this->db->join('tbl_terima_barang', 'tbl_detail_paket_hibah.id = tbl_terima_barang.id_detail_paket', 'left');
        $this->db->where('tbl_detail_paket_hibah.id_registrasi', $id_registrasi);
        $result = $this->db->get();
        
        //var_dump($result->result());
        $registrasi = new Registrasi($id_registrasi);
        $periode = new Periode();
        $current_periode = $periode->getOpenPeriode();
        $data['result'] = $result;   
        $data['registrasi'] = $registrasi;
        $data['periode'] = $current_periode;
        $view = 'list_kirim_terima';
        showNewBackEnd($view, $data, 'index-1');
    }

    public function detailTerima($id_terima) {
        $view = 'detail_terima_barang';

        $terima_barang = new TerimaBarang($id_terima);
        //$terima_barang->getBy('id_detail_paket', $id_detail_paket);
        
        $detail_kirim = new DetailKirim($terima_barang->getIdDetailKirim());
        $kirim = new Kirim($detail_kirim->getIdKirim());
        
        $data['kirim'] = $kirim;
        $data['terima_barang'] = $terima_barang;
        showNewBackEnd($view, $data, 'index-1');
    }

    public function getBuktiTerima($id_terima) {
        $this->load->helper('download');
        $terima = new TerimaBarang($id_terima);
        
        $doc_path = "/home/pppts/frontends/frontend/web/";
        if ($terima->getFileTerima()!='') {
            $path = $doc_path . $terima->getFileTerima();
        } else {
            $path = "";
        }
        $filepath = $path;
        if (is_file($filepath)) {
            $ext = pathinfo($filepath, PATHINFO_EXTENSION);
            $name = "bukti_terima.".$ext;
            $data = file_get_contents($filepath);
            force_download($name, $data);
        } else {
            echo 'File not found!';
        }
    }

    public function getFotoBarang($id_terima) {
        $this->load->helper('download');
        $terima = new TerimaBarang($id_terima);
        //$obj = $this->db->get()->row();
        $doc_path = "/home/pppts/frontends/frontend/web/";
        if ($terima->getFotoBarang()!='') {
            $path = $doc_path . $terima->getFotoBarang();
            
        } else {
            $path = "";
        }
        $filepath = $path;
        //echo 'path: '.$filepath;
        if (is_file($filepath)) {
            $ext = pathinfo($filepath, PATHINFO_EXTENSION);
            $name = "barang.".$ext;
            $data = file_get_contents($filepath);            
            force_download($name, $data);
        } else {
            echo '<script>';
            echo 'alert("Maaf belum tersedia!");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }
    
    public function getBapMonev($id_registrasi)
    {
        $this->load->helper('download');
        $rekapitulasi = new Rekapitulasi();
        $rekapitulasi->getBy('id_registrasi', $id_registrasi);
        $doc_path = "/home/pppts/frontends/frontend/web/";
        $file_path = "";
        if($rekapitulasi->getFileBeritaAcara() != ''){
            $file_path = $rekapitulasi->getFileBeritaAcara();
        }
        if (is_file($file_path)) {
            $ext = pathinfo($file_path, PATHINFO_EXTENSION);
            $name = $id_registrasi."_bap_monev.".$ext;
            $data = file_get_contents($file_path);            
            force_download($name, $data);
        } else {
            echo '<script>';
            echo 'alert("Maaf belum tersedia!");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function getPath() {
        echo 'App path:'.APPPATH;
        echo 'up:'.'./'.APPPATH;
    }

}

?>
