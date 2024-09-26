<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
/**
 * Description of KelolaLaporan
 *
 * @author ibnua
 */
class KelolaLaporan extends MX_Controller{
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('sessionutility');
        $this->load->library('form_validation');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
        $this->load->model('Registrasi');
        $this->load->model('Registrasilaporanakhir');
        $this->load->model('Laporanakhiriku');
        $this->load->model('Laporanakhirpemanfaatan');
        $this->load->model('Laporanakhirdanapendamping');
    }
    
    public function postLaporan(){
        $id_registrasi = $this->input->post('id_registrasi');
        $thn = date("Y");
        $bln = date("M");

        $file_path_excel = '/home/pppts/frontends/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/' . $bln . '/';

        if (!is_dir($file_path_excel)) {
            mkdir($file_path_excel, 0777, true);
        }
        $config ['upload_path'] = $file_path_excel;
        $config ['allowed_types'] = 'xlsx';
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
            $objPHPExcel = IOFactory::load($data['full_path']);
            $objPHPExcel->setActiveSheetIndex(0);            
            
            redirect(base_url() . 'backoffice/kelolaevaluasi/indexevaluator/');
        }
    }
    
    public function readLaporan($params){
        if(is_array($params)){
            $file_path = $params['file_path'];
            $id_registrasi = $params['id_registrasi'];
            if(is_file($file_path)){
                $objPHPExcel = IOFactory::load($file_path);
                $objPHPExcel->setActiveSheetIndex(0);
                //for($i=14; $i<=18; $i++){
                    $badan_penyelenggara = $objPHPExcel->getActiveSheet()->getCell('F14')->getCalculatedValue();
                    $perguruan_tinggi = $objPHPExcel->getActiveSheet()->getCell('F15')->getCalculatedValue();
                    $ketua_pelaksana = $objPHPExcel->getActiveSheet()->getCell('F16')->getCalculatedValue();
                    $program_studi = $objPHPExcel->getActiveSheet()->getCell('F17')->getCalculatedValue();
                    $dana_pendamping = $objPHPExcel->getActiveSheet()->getCell('F18')->getCalculatedValue();
                //}
                    $reg_lap_akhir = new RegistrasiLaporanAkhir($id_registrasi);
                    $reg_lap_akhir->badan_penyelenggara = $badan_penyelenggara;
                    $reg_lap_akhir->perguruan_tinggi = $perguruan_tinggi;
                    $reg_lap_akhir->ketua_pelaksana = $ketua_pelaksana;
                    $reg_lap_akhir->program_studi = $program_studi;
                    $reg_lap_akhir->dana_pendamping = $dana_pendamping;
                    if($reg_lap_akhir->id_registrasi != ''){
                        $reg_lap_akhir->insert();
                    }
                    
                $objPHPExcel->setActiveSheetIndex(1);
                for($i=15; $i<=18; $i++){
                    $indikator_kinerja = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                    $base_line = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                    $target = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                    $capaian = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                    $kendala = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                    $solusi = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
                    $lap_akhir_iku = new LaporanAkhirIku($id_registrasi);
                    $lap_akhir_iku->base_line = $base_line;
                    $lap_akhir_iku->target = $target;
                    $lap_akhir_iku->capaian = $capaian;
                    $lap_akhir_iku->kendala = $kendala;
                    $lap_akhir_iku->solusi = $solusi;
                    $lap_akhir_iku->insert();
                }
            }
        }
    }
}
