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
        $this->load->model('registrasi');
        
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
            $file_path = $data['full_path'];
            $this->readLaporan($file_path);
            
            redirect(base_url() . 'backoffice/kelolaevaluasi/indexevaluator/');
        }
    }
    
    public function readLaporan($file_path){
        if(is_file($file_path)){
            $objPHPExcel = IOFactory::load($file_path);
            $objPHPExcel->setActiveSheetIndex(0);
            
        }
    }
}
