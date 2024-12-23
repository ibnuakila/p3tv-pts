<?php
require 'Icontroll.php';
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Kelolaluaran
 *
 * @author ibnua
 */
class KelolaLuaran extends CI_Controller implements IControll{
    
    function __construct() {
        parent::__construct();
        $this->load->library('sessionutility');
        $this->load->library('form_validation');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
        $this->load->model('proses');
        $this->load->model('registrasi');
        $this->load->model('Luaranprogram');
        $this->load->model('pti');        
        $this->load->model('periode');        
        $this->load->model('Rekapitulasi');
        $this->load->model('Laporankemajuan');
        $this->load->helper('download');
    }

    public function add() {
        $view = 'form_luaran';
        $id_registrasi = $this->uri->segment(4, 0);
        $registrasi = new Registrasi($id_registrasi);
        $luaran = new LuaranProgram();
        $params['paging'] = ['row' => 0, 'segment' => 0];
        $params['field'][LuaranProgram::table.'.id_registrasi'] = ['=' => $id_registrasi];
        $result = $luaran->getResult($params);
        $data['registrasi'] = $registrasi;
        $data['result'] = $result;
        add_footer_css('jquery-ui-1.12.1/jquery-ui.css');
        add_footer_js('jquery-ui-1.12.1/jquery-ui.js');
        add_footer_js('js/app/form_luaran.js');
        showNewBackEnd($view, $data, 'index-1');        
    }

    public function edit() {
        $id = trim($this->input->post('id'));
        $luaran = new LuaranProgram($id);
        if($luaran->id_registrasi != ''){
            $data['response'] = true;
            $data['data'] = [
                'id' => $luaran->id,
                'id_registrasi' => $luaran->id_registrasi,
                'nama_prodi' => $luaran->nama_prodi,
                'ruang_lingkup' => $luaran->ruang_lingkup,
                'program_pengembangan' => $luaran->program_pengembangan,
                'bentuk_luaran' => $luaran->bentuk_luaran,
                'jumlah_luaran' => $luaran->jumlah_luaran,
                'tahun' => $luaran->tahun,
                'waktu_pelaksanaan' => $luaran->waktu_pelaksanaan,
                'biaya' => $luaran->biaya,
                'target_iku' => $luaran->target_iku,
                'keterangan' => $luaran->keterangan];
        }else{
            $data['response'] = false;
        }
        echo json_encode($data);
    }

    public function find() {
        
    }

    public function index() {
        
    }

    public function remove() {
        $id = $this->input->post('id');
        $luaran = new LuaranProgram($id);
        $return = $luaran->delete($id);
        $data['response'] = $return;
        echo json_encode($data);
    }

    public function save() {
        $id = trim($this->input->post('id'));
        $id_registrasi = trim($this->input->post('id_registrasi'));
        $nama_prodi = $this->input->post('nama_prodi');
        $ruang_lingkup = $this->input->post('ruang_lingkup');
        $program = $this->input->post('program');
        $bentuk_luaran = $this->input->post('bentuk_luaran');
        $jumlah_luaran = $this->input->post('jumlah_luaran');
        $tahun = $this->input->post('tahun');
        $waktu_laksana = $this->input->post('waktu_laksana');
        $biaya = $this->input->post('biaya');
        $target_iku = $this->input->post('target_iku');
        $keterangan = $this->input->post('keterangan');
        
        $this->form_validation->set_rules('id_registrasi', 'ID Registrasi', 'trim|required');
        $this->form_validation->set_rules('nama_prodi', 'Nama Prodi', 'trim|required');
        if($this->form_validation->run()){
            $luaran = new LuaranProgram();
            $luaran->id = $id;
            $luaran->id_registrasi = $id_registrasi;
            $luaran->nama_prodi = $nama_prodi;
            $luaran->ruang_lingkup = $ruang_lingkup;
            $luaran->program_pengembangan = $program;
            $luaran->bentuk_luaran = $bentuk_luaran;
            $luaran->jumlah_luaran = $jumlah_luaran;
            $luaran->tahun = $tahun;
            $luaran->waktu_pelaksanaan = $waktu_laksana;
            $luaran->biaya = $biaya;
            $luaran->target_iku = $target_iku;
            $luaran->keterangan = $keterangan;
            if($id == ''){
                $return = $luaran->insert();
            }else{
                $return = $luaran->update($id);
            }
            $params['paging'] = ['row' => 0, 'segment' => 0];
            $params['field'][LuaranProgram::table.'.id_registrasi'] = ['=' => $id_registrasi];
            $result = $luaran->getResult($params);
            $response['response'] = $return;
            $response['result'] = $result->result('array');
            echo json_encode($response);        
        }else{
            $error = trim(strip_tags(validation_errors()));
            $response['error'] = $error;
            $response['response'] = false;
            echo json_encode($response);
        }
        
    }

    public function downloadBukti($id){
        $this->load->helper('download');
        $lapKemajuan = new Laporankemajuan($id);
        if ($lapKemajuan->id != '') {
            $path = $lapKemajuan->filePath;
            $dokumen_name = $lapKemajuan->namaDokumen;
            if (is_file($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $name = $dokumen_name . $ext;
                //echo 'name: '.$name;
                force_download($name, $data);
            } else {
                $temp_path = '/home/pppts/frontends/frontend/web/' . $path;
                //echo $temp_path;
                if (is_file($temp_path)) {
                    $ext = pathinfo($temp_path, PATHINFO_EXTENSION);
                    $data = file_get_contents($temp_path);
                    $name = $dokumen_name . '.' . $ext;
                    //echo 'name: '.$name;
                    force_download($name, $data);
                } else {
                    echo 'File not found!';
                }
            }
        }
    }

    public function downloadKuitansi($id)
    {
        $this->load->helper('download');
        $luaran = new LuaranProgram($id);
        $file_path = $luaran->kwitansi;
        if (is_file($file_path)) {
            $ext = pathinfo($file_path, PATHINFO_EXTENSION);
            $data = file_get_contents($file_path);
            $name = $luaran->id_registrasi."_kwitansi" . $ext;
            //echo 'name: '.$name;
            force_download($name, $data);
        } else {
            $temp_path = '/home/pppts/frontends/frontend/web/' . $file_path;
            //echo $temp_path;
            if (is_file($temp_path)) {
                $ext = pathinfo($temp_path, PATHINFO_EXTENSION);
                $data = file_get_contents($temp_path);
                $name = $luaran->id_registrasi."_kwitansi" . $ext;
                //echo 'name: '.$name;
                force_download($name, $data);
            } else {
                echo 'File not found!';
            }
        }
    }
}
