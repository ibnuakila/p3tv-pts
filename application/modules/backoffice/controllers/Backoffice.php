<?php

//require_once APPPATH . 'third_party/PHPExcel.php';
//require_once APPPATH . 'third_party/PHPExcel/IOFactory.php';

/**
 * @author akil
 * @version 1.0
 * @created 14-Mar-2016 11:12:35
 */
class BackOffice extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Modusers');
        $this->load->library('sessionutility');
    }

    function __destruct() {

    }

    public function index() {
        if (!$this->sessionutility->validateSession()) {
            //showBackEnd('form_login',null,'index_login');
            //$this->load->view('form_login');
            showNewBackEnd('form_login',null,'index-2');
        } else {

            //if($this->sessionutility->validateAccess($this)){
            showNewBackEnd('backoffice/welcome',null,'index-1');
            //}else{
            //showBackEnd('form_login');
            /* echo '<script>';
              echo 'alert("Validation Fail !");';
              echo 'window.history.back(1);';
              echo '</script>'; */
            //}
        }
    }

    public function login() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('userid', 'UserId', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $userid = strtoupper($this->clearField(htmlentities($this->input->post('userid'))));
            $password = $this->clearField(htmlentities($this->input->post('password')));

            $user = new ModUsers('');
            $user->setUserId($userid);
            $user->setPassword($password);
            if ($user->login()) {

                $session = array('userid' => $userid,
                    'is_loged_in' => true,
                    'unitid' => $user->getUnitId());
                $this->session->set_userdata($session);
                showNewBackEnd('backoffice/welcome',null,'index-1');
                //$this->index();
                //echo 'You are login';
            } else {
                $data['message'] = 'Userid or Username Invalid!';
                showNewBackEnd('form_login',null,'index-2');
                //$this->load->view('form_login_new',$data);
            }
        } else {
            echo validation_errors();
            //showBackEnd('form_login');
        }
    }

    private function clearField($string) {
        $string = str_replace("'", "", $string);
        $string = str_replace("\"", "", $string);
        $string = str_replace("--", "", $string);
        $string = str_replace("/", "", $string);
        $string = str_replace("=", "", $string);
        $string = str_replace("%", "", $string);
        $string = str_replace("&", "", $string);
        $string = str_replace("$", "", $string);
        $string = str_replace("drop", "", $string);
        $string = str_replace("table", "", $string);
        return $string;
    }

    public function logout() {
        //$this->session->sess_destroy();
        //redirect(base_url().'backoffice');
        if ($this->session->userdata('temp_user')) {
            $user_id = $this->session->userdata('temp_user');
            $temp_data = array('temp_user' => '');
            $this->session->unset_userdata($temp_data);
            $user = new ModUsers($user_id);
            $session = array(
                'userid' => $user_id,
                'is_loged_in' => TRUE,
                'unitid' => $user->getUnitId(),
            );
            $this->session->set_userdata($session);
            //$unitkerja = new ModUnitKerja($user->getUnitId());
            //$user->m_ModUnitKerja = $unitkerja;
            //$type = new ModUserType($user->getUserType());
            //$user->m_ModUserType = $type;

            redirect(base_url() . 'backoffice');
        } else {
            $id = $this->session->userdata('userid');
            $data = array('userid' => '', 'is_loged_in' => FALSE);
            $this->session->unset_userdata($data);

            $this->session->sess_destroy();
            redirect(base_url() . 'backoffice');
        }
    }

    public function upload() {

        echo '<form class="form-horizontal" method="post" action="' . base_url() . 'backoffice/backoffice/processupload" accept-charset="utf-8" enctype="multipart/form-data">';
        echo '<input type="file" class="btn btn-file" name="userfile" id="userfile"/> ';
        echo '<button type="submit" name="save" value="save" class="btn btn-success">Unggah</button>';
        echo '</form>';
    }

    public function processUpload() {
        $thn = date("Y");
        $bln = date("M");
        $file_path_excel = '/home/usrlembaga/frontend/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/' . $bln . '/';
        $archive = '/home/usrlembaga/frontend/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/';
        if (!is_dir($file_path_excel)) {
            mkdir($file_path_excel, 0777, true);
        }
        $config ['upload_path'] = $file_path_excel;
        $config ['allowed_types'] = 'xls|xlsx';
        $config ['max_size'] = '2000';

        $this->load->library('upload', $config);
        $this->load->helper('download');
        $this->load->library('zip');
        $this->load->model('registrasi');
        $this->load->model('proses');
        $this->load->model('evaluasi');

        $this->upload->do_upload();
        $data = $this->upload->data();
        $file_path = $data['full_path'];
        if (!file_exists($file_path)) {
            exit("File unavailable!");
        }
        $objPHPExcel = PHPExcel_IOFactory::load($file_path);
        $objPHPExcel->setActiveSheetIndex(0);

        $i = 1;
        $number = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        //echo 'A'.$i.':'.$number.'</br>';
        $files = array();
        while ($number != '') {
            if (is_numeric($number)) {
                //echo 'A'.$i.' is numeric.</br>';
                $id_registrasi = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                //echo 'id registrasi: '.$id_registrasi.'</br>';
                $registrasi = new Registrasi($id_registrasi);
                $proseses = $registrasi->getProses();
                //print_r($proseses);

                foreach ($proseses as $p) {
                    $evaluasi = $p->getEvaluasi();
                    if (is_object($evaluasi)) {
                        $temp_path = $evaluasi->getFilePath();
                        //$arr_path = explode('/', $temp_path);
                        //$name = $arr_path[10];
                        //echo $id_registrasi.' | '.$name.'</br>';
                        //$data = file_get_contents($temp_path);
                        //array_push($files, array($name => $data)) ;
                        $this->zip->read_file($temp_path);
                        //echo 'File name: '.$name1;
                    }
                }
            }
            $i++;
            $number = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        }
        //print_r($files);
        $this->zip->add_data($files);
        $this->zip->archive($archive . 'templates.zip');
        $this->zip->download('templates.zip');
    }

    public function loginAsUser($user_id) {
        if ($this->sessionutility->validateSession()) {
            $temp_user = $this->session->userdata('userid');
            $user = new ModUsers($user_id);
            $session = array(
                'userid' => $user_id,
                'is_loged_in' => true,
                'unitid' => $user->getUnitId(),
                'temp_user' => $temp_user
            );
            $this->session->set_userdata($session);
            //$unitkerja = new ModUnitKerja($user->getUnitId());
            //$user->m_ModUnitKerja = $unitkerja;
            //$type = new ModUserType($user->getUserType());
            //$user->m_ModUserType = $type;

            redirect(base_url() . 'backoffice');
        } else {
            echo '<script>';
            echo 'alert("Validation Fail !");';
            echo '</script>';
        }
    }

    public function datatables()
    {
        $view = 'data_tables';
        showBackEnd($view);
    }

    public function getDataTables()
    {
        $this->load->model('registrasi');
        $registrasi = new Registrasi();
        print_r($_POST);

    }

    public function getForm()
    {

        //error_reporting(E_ALL);

        $idregistrasi = $this->uri->segment(3); //$this->input->post('kdpti');
        redirect(base_url().'kelolapaket/getbestmonev/'.$idregistrasi);
        /*
        $this->load->model('kirim');
        $kirim = new Kirim();

        $result = $kirim->getByRelated('tbl_kirim', 'id_registrasi', $idregistrasi, '0', '0');

        if($result->num_rows()>0){
            $row = $result->row();
            $pts = new Pti($row->kdpti);
            $yys = new BadanPenyelenggara($row->kdpti);
            $detail = new DetailKirim();
            $nama_yys = $yys->getNamaPenyelenggara();

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();

            // Set document properties
            $objPHPExcel->getProperties()->setCreator("pppts.ristekdikti.go.id")
                                        ->setLastModifiedBy("Admin")
                                        ->setTitle("Form Monitoring PPPTS 2019")
                                        ->setSubject("Laporan Monitoring PPPTS 2019");
            // Add some data
            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'BERITA ACARA MONITORING DAN EVALUASI');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', 'PEMBERIAN BANTUAN BARANG ');
            $objPHPExcel->getActiveSheet()->setCellValue('A3', 'PP-PTS TAHUN ANGGARAN 2019');
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Badan Hukum Penyelenggara: '.$nama_yys);
            $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Kode PT: '.$pts->getKdPti());
            $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Nama PT: '.$pts->getNmPti());
            $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Kemajuan Fisik ( sesuai tanggal monev )');
            $objPHPExcel->getActiveSheet()->setCellValue('A10', 'No');
            $objPHPExcel->getActiveSheet()->setCellValue('B10', 'Nama Barang');
            $objPHPExcel->getActiveSheet()->setCellValue('C10', 'Merk & Spesifikasi');
            $objPHPExcel->getActiveSheet()->setCellValue('D10', 'Volume');
            $objPHPExcel->getActiveSheet()->setCellValue('E10', 'Kesesuaian');
            $objPHPExcel->getActiveSheet()->setCellValue('G10', 'Fungsi');
            $objPHPExcel->getActiveSheet()->setCellValue('I10', 'Pemanfaatan untuk Mata Kuliah terkait');
            $objPHPExcel->getActiveSheet()->setCellValue('J10', 'Penempatan');
            $objPHPExcel->getActiveSheet()->setCellValue('K10', 'Tgl Diterima');
            $objPHPExcel->getActiveSheet()->setCellValue('L10', 'Keterangan (garansi dan no seri)');

            $objPHPExcel->getActiveSheet()->setCellValue('E11', 'Ya');
            $objPHPExcel->getActiveSheet()->setCellValue('F11', 'Tidak');
            $objPHPExcel->getActiveSheet()->setCellValue('G11', 'Ya');
            $objPHPExcel->getActiveSheet()->setCellValue('H11', 'Tidak');
            $r=12; $no = 0;
            foreach ($result->result() as $row) {


                $result_detail = $detail->getByRelated('tbl_detail_kirim', 'id_kirim', $row->id, '0', '0');
                //isi data

                foreach ($result_detail->result() as $obj){
                    $detail_hibah = new DetailPaketHibah();
                    $detail_hibah->getBy('id', trim($obj->id_detail_paket_hibah));
                    $barang = new Barang(trim($detail_hibah->getIdItem()));
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$r, ++$no);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$r, $barang->getNmBarang());
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$r, $detail_hibah->getMerk().' | '.$detail_hibah->getType());
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$r)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$r, $obj->jumlah);
                    $r++;
                }
            }
                $bottom = $r-1;

                $objPHPExcel->getActiveSheet()->setCellValue('A'.++$r, 'Foto barang yang sudah diterima (terlampir)');
                $objPHPExcel->getActiveSheet()->setCellValue('A'.++$r, 'Catatan lainnya:');
                $r = $r+7;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$r, 'Team Monitoring Hibah PPPTS 2019');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$r)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$r, 'Perwakilan dari');
                $objPHPExcel->getActiveSheet()->getStyle('E'.$r)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('A'.++$r, 'Kementerian Riset Teknologi dan Pendidikan Tinggi');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$r)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$r, $nama_yys);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$r)->getFont()->setBold(true);

                $objPHPExcel->getActiveSheet()->setCellValue('A'.++$r, 'No');$btop = $r;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$r, 'Nama');
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$r, 'Tanda Tangan');

                $objPHPExcel->getActiveSheet()->setCellValue('E'.$r, 'No');
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$r, 'Nama');
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$r, 'Tanda Tangan');

                $objPHPExcel->getActiveSheet()->setCellValue('A'.++$r, '1');
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$r, '1');
                $objPHPExcel->getActiveSheet()->setCellValue('A'.++$r, '2');
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$r, '2');
                $objPHPExcel->getActiveSheet()->setCellValue('A'.++$r, '3');
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$r, '3');$bbot = $r;


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
			$objPHPExcel->getActiveSheet()->mergeCells('K10:K11');
			$objPHPExcel->getActiveSheet()->mergeCells('L10:L11');


            //column width
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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


            $objPHPExcel->getActiveSheet()->getStyle('A10:L11')->applyFromArray(
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
            );
            $objPHPExcel->getActiveSheet()->getStyle('A10:L'.$bottom)->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$btop.':C'.$bbot)->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$btop.':G'.$bbot)->applyFromArray($styleThinBlackBorderOutline);
            //download
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$pts->getNmPti().'.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        }else{
            echo 'No Data';
        }*/
    }

    public function phpinfo(){
        echo phpinfo();
    }

}

?>
