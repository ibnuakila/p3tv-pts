<?php

require_once ('Icontroll.php');

//require_once APPPATH . 'third_party/PHPExcel.php';
//require_once APPPATH . 'third_party/PHPExcel/IOFactory.php';
require 'vendor/autoload.php';
use \PhpOffice\PhpSpreadsheet\IOFactory;

//use ;
/**
 * @author akil
 * @version 1.0
 * @created 26-Mar-2016 19:15:18
 */
class KelolaRekapitulasi extends MX_Controller implements IControll {

    function __construct() {
        parent::__construct();
        $this->load->library('sessionutility');
        $this->load->library('form_validation');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
        $this->load->model('paket');
        $this->load->model('detailpakethibah');
        $this->load->model('detailpaketkirim');
        $this->load->model('supplier');
        $this->load->model('itemhibah');
        $this->load->model('registrasi');
        $this->load->model('barang');
        $this->load->model('Rekapitulasi');
        $this->load->model('Periode');
    }

    function __destruct() {
        
    }

    public function add() {
        
    }

    public function edit() {
        
    }

    public function find() {
        //if ($this->sessionutility->validateAccess($this)) {
        if ($this->input->post('export')) {
            $detail_hibah = new DetailPaketHibah();
            $result = $detail_hibah->getRekap('0', '0');
            // Create new PHPExcel object
            //$objPHPExcel = new PHPExcel();
            
            $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("pppts.ristekdikti.go.id")
                    ->setLastModifiedBy("Admin")
                    ->setTitle("Form Monitoring PPPTS 2017")
                    ->setSubject("Laporan Monitoring PPPTS 2017");
            // Add some data
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Kota');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Nama PT');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Sub Total');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'PPN 10%');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Total Anggaran');
            $r = 2;
            $no = 0;
            foreach ($result->result() as $row) {
                $pt = new PTI($row->kdpti);
                $ppn = $row->total * 0.1;
                $total_anggaran = $row->total + $ppn;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $r, ++$no);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $r, ucfirst($pt->getKota()));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $r, $pt->getNmPti());
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $r, $row->total);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $r, $ppn);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $r, $total_anggaran);

                $objPHPExcel->getActiveSheet()->getStyle('D' . $r)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $objPHPExcel->getActiveSheet()->getStyle('E' . $r)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $r)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $r++;
            }
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

            //download
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
            $objWriter->save('php://output');
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
        /* } else {
          echo '<script>';
          echo 'alert("Validation Fail !");';
          echo 'window.history.back(1);';
          echo '</script>';
          } */
    }

    public function index() {
        if ($this->sessionutility->validateAccess($this)) {
            $id_registrasi = trim($this->input->post('id_registrasi'));
            $yayasan = trim($this->input->post('yayasan'));
            $pti = trim($this->input->post('pti'));
            $opt_periode = trim($this->input->post('periode'));
            $evaluator = trim($this->input->post('evaluator'));
            $status_registrasi = trim($this->input->post('status_registrasi'));


            $segment = $this->uri->segment(4, 0);
            $temp_post = $this->input->post(NULL, TRUE);
            if (!$temp_post) {
                $id_registrasi = trim($this->session->flashdata('id_registrasi'));
                $yayasan = trim($this->session->flashdata('yayasan'));
                $pti = trim($this->session->flashdata('pti'));
                $opt_periode = trim($this->session->flashdata('periode'));
                $evaluator = trim($this->session->flashdata('evaluator'));
                $status_registrasi = trim($this->session->flashdata('status_registrasi'));
            }
            $temp_filter = array(
                'id_registrasi' => $id_registrasi,
                'yayasan' => $yayasan,
                'pti' => $pti,
                'periode' => $opt_periode,
                'evaluator' => $evaluator,
                'status_registrasi' => $status_registrasi
            );
            $this->session->set_flashdata($temp_filter);

            $evaluasi = new Rekapitulasi();
            $periode = new Periode();
            //$current_periode = $periode->getOpenPeriode();
            $temp_current_periode = $periode->getOpenPeriode();
            
            if($opt_periode == ''){                
                $current_periode = $temp_current_periode->periode;
            }else{
                $current_periode = $opt_periode;
            }
            $params = [];
            if ($this->input->post('export')) {
                $params['paging'] = ['row' => 0, 'segment' => 0];
            } else {
                $params['paging'] = ['row' => 10, 'segment' => $segment];
            }
                        
            $params['join']['registrasi'] = ['INNER' => Rekapitulasi::table.'.id_registrasi=registrasi.id_registrasi'];
            //$params['field']['registrasi.periode'] = ['=' => $current_periode->periode];
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
                $params['join']['evaluator'] = ["INNER" => "proses.id_evaluator = evaluator.id_evaluator"];
                $params['field']['evaluator.nm_evaluator'] = ['LIKE' => $evaluator];
            }

            if ($status_registrasi != '') {
                $params['join']['status_registrasi'] = ["INNER" => "rekapitulasi.id_status_registrasi = status_registrasi.id_status_registrasi"];
                $params['field']['status_registrasi.id_status_registrasi'] = ['=' => $status_registrasi];
            }
            $params['order'][Rekapitulasi::table . '.tgl_rekap'] = 'DESC';
            
            $result_evaluasi = $evaluasi->getResult($params);

            //config pagination                     
            $per_page = 10;
            $params['count'] = True;
            $total_row = $evaluasi->getResult($params);
            $base_url = base_url() . 'backoffice/kelolarekapitulasi/index/';
            setPagingTemplate($base_url, 4, $total_row, $per_page);

            //data status
            $obj_status_registrasi = new StatusRegistrasi();
            $result_status = $obj_status_registrasi->get('0', '0');
            $option_status = array('' => '~Pilih~');
            foreach ($result_status->result() as $value) {
                $option_status[$value->id_status_registrasi] = $value->nama_status;
            }
            
            $data['status_evaluasi'] = $option_status;
            $data['status_registrasi'] = $option_status;
            $data['evaluasi'] = $result_evaluasi;
            $data['total_row'] = $total_row;

            if ($this->input->post('export')) {
                $this->load->view('export_proses', $data);
                //print_r($result);
            } else {
                $view = 'list_rekap_evaluasi';
                //add_footer_js('js/app/index_evaluasi.js');
                add_footer_js('js/app/list_rekap_evaluasi.js');
                showNewBackEnd($view, $data, 'index-1');
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }

    public function remove() {
        
    }

    public function save() {
        
    }

    public function testExcel()
    {
        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet(); //Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Maarten Balliauw')
            ->setLastModifiedBy('Maarten Balliauw')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

        // Miscellaneous glyphs, UTF-8
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

    }
    
    public function downloadComment($id_registrasi){
        $this->load->helper('download');
        $rekap = new Rekapitulasi();
        $rekap->getBy('id_registrasi', $id_registrasi);
        $filepath = $rekap->getKeterangan();
        $registrasi = new Registrasi($id_registrasi);
        $pt = $registrasi->getPti();
        echo $filepath;
        if (is_file($filepath)) {
            $data = file_get_contents($filepath);
            $name = $registrasi->getIdRegistrasi() . '_' . str_replace(' ', '_', $pt->getNmPti()) . '_coco.pdf';
            force_download($name, $data);
        } else {
            echo 'File not found!';
        }           
        
    }
    
    public function publish() {
        if ($this->sessionutility->validateAccess($this)) {
            $id_registrasi = $this->input->post('id_reg');
            $status = $this->input->post('status');
            $rekapitulasi = new Rekapitulasi();
            $rekapitulasi->getBy('id_registrasi', $id_registrasi);
            $registrasi = new Registrasi($id_registrasi);
                        
            if ($status == 'true') {
                $rekapitulasi->setPublish('yes');
                $rekapitulasi->setTglPublish(date("Y-m-d"));
                $rekapitulasi->update();
                
                $registrasi->setIdStatusRegistrasi($rekapitulasi->getIdStatusRegistrasi()); 
                if($rekapitulasi->getIdStatusRegistrasi() == 10){
                    $revision = $registrasi->getRevisiProposal();
                    $registrasi->setRevisiProposal($revision + 1);
                }
                $registrasi->setPenugasan(0);
                $result = $registrasi->update();
            } else {
                $rekapitulasi->setPublish('no');
                $rekapitulasi->setTglPublish(null);
                $rekapitulasi->update();
                
                $registrasi->setIdStatusRegistrasi('3');                
                $result = $registrasi->update();
            }
            if ($result) {
                echo "Usulan Telah Diumumkan";
            } else {
                echo "Publish Gagal";
            }
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';
        }
    }
    
    public function updateStatus(){
        if ($this->sessionutility->validateAccess($this)) {
            $id_rekapitulasi = $this->input->post('id_rekapitulasi');
            $status = $this->input->post('id_status_registrasi');
            $rekapitulasi = new Rekapitulasi($id_rekapitulasi);
            $rekapitulasi->setIdStatusRegistrasi($status);            
            
            $rekapitulasi->setPublish('no');
            $rekapitulasi->setTglPublish(null);
            $result = $rekapitulasi->update();                
                
            if ($result) {
                $data[] = array(
                'message'=>'Status Telah diupdate. Silahkan di publish ulang untuk mengumumkan!');
                echo json_encode($data);
            } else {
                $data[] = array(
                'message'=>'Update Gagal!');
                echo json_encode($data);
            }
        } else {
            /*echo '<script>';
            echo 'alert("Validation Fail !");';
            echo 'window.history.back(1);';
            echo '</script>';*/
            $data[] = array(
                'message'=>'Validation Fail!');
                echo json_encode($data);
        }
    }
}

?>