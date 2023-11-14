<?php

/**
 * @author akil
 * @version 1.0
 * @created 14-Mar-2016 11:12:35
 */
class Suplier extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Modusers');
        $this->load->library('sessionutility');
        $this->load->helper('datatables');
        $this->load->helper('download');
    }

    function __destruct() {
        
    }
    
    
    

    public function index() {
        if (!$this->sessionutility->validateSession()) {
            showBackEndadh('form_login_new',null,'index_new');
        } else {

//if($this->sessionutility->validateAccess($this)){
            //showBackEnd('welcome');
            showBackEndadh('welcome',null,'index_new');
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

        $this->form_validation->set_rules('userid', 'User Id', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $userid = strtoupper($this->clearField(htmlentities($this->input->post('userid'))));
            $password = $this->clearField(htmlentities($this->input->post('password')));

            $user = new ModUsers('');
            $user->setUserId($userid);
            $user->setPassword($password);

            if ($user->login()) {
                $userss = $this->db->query("select * from users where user_id='$userid'")->row();
                $session = array('userid' => $userid, 'is_loged_in' => true, 'unitid' => '27', 'id_suplier' => $userss->user_status);
                $this->session->set_userdata($session);
                if ($password == 'suplier2019') {
                    $id = $this->session->userdata('userid');
                    $data['user'] = new ModUsers($id);
                    $data['baru'] = 'Password Masih Standar, Segera ';
                    showBackEndadh('ubah', $data,'index_new');
                    
                } else              
               $this->index();               
            } else {
                $data['message'] = 'Userid or Username Invalid!';
                showBackEndadh('form_login_new', $data,'index_new');
            }
            //  $userss = $this->db->query("select * from users where user_id='$userid' and password=md5('$password')")->get();
       /*    if ($userss->num_rows() > 0) {
                $id = $userss->row();
                $session = array('userid' => $userid, 'is_loged_in' => true, 'unitid' => '27', 'id_suplier' => $id->user_status);
                $this->session->set_userdata($session);
                if ($userss->user_status == '0') {
                    $id = $this->session->userdata('userid');
                    $data['user'] = new ModUsers($id);
                    $data['baru'] = 'Password Masih Standar, Segera ';
                    showBackEndadh('ubah', $data);
                } else {
                    $id = $this->session->userdata('id_suplier');
                    //echo 'tess:  '.$id ;
                    $this->index();
//echo 'You are login';
                }
            } else {
                $data['message'] = 'Userid or Username Invalid!';
                showBackEndadh('form_login');
            } */
        } else {

            showBackEndadh('form_login_new');
        }
    }

    function ubahpassword() {
        $id = $this->session->userdata('userid');
        $data['user'] = new ModUsers($id);
        $data['baru'] = '';
        showBackEndadh('ubah', $data);
    }

    function simpan() {
        $id = $this->session->userdata('userid');
        $user = new ModUsers($id);        
        $pass = $user->getPassword() ;
        $newpas = md5(trim($this->input->post('passwordLama')));
        $newpas1 = md5(trim($this->input->post('passwordBaru')));
        
       // echo $pass . '==' . $newpas  ;
        
        //  echo $user->getPassword() . "==" . md5($this->input->post('passwordLama')) . "==" . $this->input->post('passwordBaru') . "==" . md5($this->input->post('passwordBaru'));
       
        
        if ($pass == $newpas) {
           
           
            $user->setPassword($this->input->post('passwordBaru'));
            $user->setUserStatus('1');
            $qry = "update users SET password='$newpas1',user_status='1' where user_id='$id'";
            $this->db->query($qry);
           redirect('suplier/suplier/index');
            
        } else {
                     
         redirect('suplier/suplier/suplier/', 'location', 301);
        }
        
        echo 'tambahin dibawah';
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

    public function datakontrak() {
        if (!$this->sessionutility->validateSession()) {
            showBackEndadh('form_login');
        } else {
        if ($this->sessionutility->validateAccess($this)) {

            // echo 'login oke';  
            echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
            echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
            echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
            echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
            echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
            echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');

            $data['title'] = "Data Kontrak";
            $id = $this->session->userdata('id_suplier');
            $data['sup'] = $id;
            showBackEndadh('list_paket', $data);
        } else {

          //  showBackEnd('form_login');
             echo '<script>';
              echo 'alert("Validation Fail !");';
              echo 'window.history.back(1);';
              echo '</script>'; 
        }
        }
    }

    public function detail($id) {
        // echo 'login oke';  
        echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
        echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
        echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
        echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
        echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
        echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');

        $a = $this->db->query("SELECT * from tbl_paket where id='$id'")->row();

        $data['title'] = "Detail Kontrak " . $a->no_kontrak;
        $data['id'] = $id;
        showBackEndadh('list_detail', $data);
    }

    public function kirim($id) {
        // echo 'login oke';  
        echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
        echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
        echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
        echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
        echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
        echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');
        $kdpt = substr($id, 0, 6);
        $idpaket = substr($id, 6, strlen($id) - 6);
        $data['barang'] = $this->db->query("
           SELECT id_item,spesifikasi AS barang,spesifikasi, merk,volume - IF(volume_terkirim IS NULL,0, volume_terkirim) AS volume,id 
 FROM tbl_detail_paket_hibah  WHERE id_paket='$idpaket' AND kdpti='$kdpt' AND (volume - volume_terkirim) <> 0 ")->result();
        $data['pt'] = $this->db->query("SELECT kdpti,nmpti,alamat,kota FROM tbl_pti where kdpti='$kdpt'")->row();
        $data['title'] = "Kirim Barang ";
        $data['id'] = $id;
        showBackEndadh('kirim', $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'suplier');
    }

    public function tessimpan() {
        $volume = $this->input->post('volume');
        $volume1 = $this->input->post('volume1');
        $check = $this->input->post('check_list');
        $i = 0;
        foreach ((array) $check as $obj) {
            echo $obj . '&br';
            echo $this->input->post($obj) . '&br';
            echo $this->input->post($obj . 'a' . '&br');
            $i = $i + 1;
        }
    }

    public function simpankirim() {
        $kdpt = $this->input->post('kdpti');
        $alamat = $this->input->post('alamat');
        $kota = $this->input->post('kota');
        $ekspedisi = $this->input->post('ekspedisi');
        $tglkirim = $this->input->post('tglkirim');
        $noresi = $this->input->post('resi');
        $kdsuplier = strtoupper($this->session->userdata('id_suplier'));
        $thn = date("Y");
        $file_path = '/home/pppts/frontends/frontend/web/dokumen/buktikirim/'.$thn .'/' . $kdpt;
        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, true);
            //   copy('data/files/file_surat/sk/draftsk/index.html', $path);
        }

        $config2['upload_path'] = $file_path;
        $config2['max_size'] = '3000';
        $nama = $kdpt . '_' .$thn .$noresi;
        $config2['file_name'] = $nama;
        $config2['allowed_types'] = 'jpg|jpeg|pdf';
        //$config['max_height']  = '768';
        $this->load->library('upload', $config2);
        $this->upload->overwrite = true;
        // echo $this->upload->do_upload();
        //  echo  "update draft_sk set status='2',memo='" . $memo . "',uic='".$userid."' tanggal='".date('Y-m-d')."' where  kdpti='" . $kdpt . "'";
        if ($this->upload->do_upload('filebukti')) {
            $data = $this->upload->data();
            $nama = $file_path . $data['file_name'];
            $qry = "INSERT INTO tbl_kirim(alamat,kota,jasa_kirim,no_resi,status,tgl_kirim,file_bukti_kirim,id_supplier,kdpti)
                    VALUES ('$alamat','$kota','$ekspedisi','$noresi','1','$tglkirim','$nama','$kdsuplier','$kdpt')";
            $this->db->query($qry);

            //untuk barangnya disimpan
            $idkirim = $this->db->query("select * from tbl_kirim where no_resi='$noresi'")->row();
            $check = $this->input->post('check_list');
            foreach ((array) $check as $obj) {
                $jml = $this->input->post($obj);
                $qry = "INSERT INTO tbl_detail_kirim(id_kirim,id_detail_paket_hibah, jumlah) VALUES ('$idkirim->id','$obj','$jml')";
                $this->db->query($qry);
                $barang = $this->db->query("select * from tbl_detail_paket_hibah where id='$obj'")->row();
                if ($barang->volume == $barang->volume_terkirim + $jml) {
                    $qry = "update tbl_detail_paket_hibah SET volume_terkirim= volume_terkirim + '$jml',status='2' where id='$obj'";
                    $this->db->query($qry);
                } else {
                    $qry = "update tbl_detail_paket_hibah SET volume_terkirim= volume_terkirim + '$jml',status='1' where id='$obj'";
                    $this->db->query($qry);
                }
            }

            redirect('suplier/suplier/datakontrak');
        } else {
            $error = trim(strip_tags($this->upload->display_errors()));
            //echo $error;
            echo '<script type="text/javascript">';
            echo 'alert("Error. ' . $error . '");';
            echo 'window.history.back(1)';
            echo '</script>';
        }
        // redirect('surat/skprodi/listdraftskprodi');
    }

    public function lookup() {
        $id = $this->session->userdata('id_suplier');
        $table = " SELECT id, nama_paket,no_kontrak, tgl_kontrak,tgl_akhir_kontrak,file_bukti_kontrak FROM 
            (select * from tbl_paket where id_supplier='$id') as dd ";
//'<a class="btn btn-primary btn-xs" href="../aliaslogin/index/'+row[0]+'" target="_blank"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</a> '+
        // Table's primary key
        $primaryKey = 'id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes No Agenda, No TU,No surat, Asal Surat,tanggal surat, Perihal,Keterangan   , Action

        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'nama_paket', 'dt' => 1),
            array('db' => 'no_kontrak', 'dt' => 2),
            array('db' => 'tgl_kontrak', 'dt' => 3),
            array('db' => 'tgl_akhir_kontrak', 'dt' => 4),
            array('db' => 'file_bukti_kontrak', 'dt' => 5)
        );

        echo json_encode(
                multiple($_GET, $table, $primaryKey, $columns)
        );
    }

    public function download($id) {
        $idpaket = $this->db->query("select * from tbl_paket where id='$id'")->row();

        $name = 'bukti_kontrak.pdf';
        $filepath = $idpaket->file_bukti_kontrak;

        if (is_file($filepath)) {
            //$path = ""
            $data = file_get_contents($filepath);
            force_download($name, $data);
        } else {
            echo "file tidak ditemukan";
        }
    }

    public function lookupkirim() {
        $id = $this->session->userdata('id_suplier');
        $table = " SELECT * FROM 
            (SELECT a.id as id,no_resi,nmpti,tgl_kirim,tgl_terima, nama AS status
            FROM tbl_kirim a JOIN tbl_pti b ON a.kdpti=b.kdpti JOIN `status_kirim` c ON a.`status`= c.id where id_supplier='$id') as dd ";
//'<a class="btn btn-primary btn-xs" href="../aliaslogin/index/'+row[0]+'" target="_blank"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</a> '+
        // Table's primary key
        $primaryKey = 'id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes No Agenda, No TU,No surat, Asal Surat,tanggal surat, Perihal,Keterangan   , Action

        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'no_resi', 'dt' => 1),
            array('db' => 'nmpti', 'dt' => 2),
            array('db' => 'tgl_kirim', 'dt' => 3),
            array('db' => 'tgl_terima', 'dt' => 4),
            array('db' => 'status', 'dt' => 5)
        );

        echo json_encode(
                multiple($_GET, $table, $primaryKey, $columns)
        );
    }
    
     public function lookupkirim2() {
            $table = " SELECT * FROM 
            (SELECT a.id as id,no_resi,nmpti,tgl_kirim,tgl_terima, nama AS status
            FROM tbl_kirim a JOIN tbl_pti b ON a.kdpti=b.kdpti JOIN `status_kirim` c ON a.`status`= c.id order by a.id desc ) as dd ";
//'<a class="btn btn-primary btn-xs" href="../aliaslogin/index/'+row[0]+'" target="_blank"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</a> '+
        // Table's primary key
        $primaryKey = 'id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes No Agenda, No TU,No surat, Asal Surat,tanggal surat, Perihal,Keterangan   , Action

        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'no_resi', 'dt' => 1),
            array('db' => 'nmpti', 'dt' => 2),
            array('db' => 'tgl_kirim', 'dt' => 3),
            array('db' => 'tgl_terima', 'dt' => 4),
            array('db' => 'status', 'dt' => 5)
        );

        echo json_encode(
                multiple($_GET, $table, $primaryKey, $columns)
        );
    }


    public function lookupdetil($id) {

        $table = "SELECT id_paket,nmpti,jumlah_item, jumlah_barang,presensi,kdpti  FROM 
            (SELECT id_paket,nmpti, COUNT(*) jumlah_item, SUM(volume) jumlah_barang,
CONCAT(SUM(IF(volume_terkirim IS NULL,0, volume_terkirim)),'/',SUM(volume)) AS presensi,b.kdpti FROM tbl_pti a JOIN  tbl_detail_paket_hibah b ON a.kdpti=b.kdpti 
WHERE id_paket='$id' GROUP BY b.kdpti) as dd ";


//SELECT id, nama_paket,no_kontrak, tgl_kontrak,tgl_akhir_kontrak,file_bukti_kontrak FROM 
        //          (select * from tbl_paket where id_supplier='$id') as dd ";
//'<a class="btn btn-primary btn-xs" href="../aliaslogin/index/'+row[0]+'" target="_blank"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</a> '+
        // Table's primary key
        $primaryKey = 'id_paket';



        $columns = array(
            array('db' => 'id_paket', 'dt' => 0),
            array('db' => 'nmpti', 'dt' => 1),
            array('db' => 'jumlah_item', 'dt' => 2),
            array('db' => 'jumlah_barang', 'dt' => 3),
            array('db' => 'presensi', 'dt' => 4),
            array('db' => 'kdpti', 'dt' => 5)
        );

        echo json_encode(
                multiple($_GET, $table, $primaryKey, $columns)
        );
    }

    public function lihatkirim() {
         if (!$this->sessionutility->validateSession()) {
            showBackEndadh('form_login');
        } else {
        // echo 'login oke';  
        if ($this->sessionutility->validateAccess($this)) {

            // echo 'login oke';  
            echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
            echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
            echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
            echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
            echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
            echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');

            $data['title'] = "Data Status Pengiriman";
            showBackEnd1('list_kirim', $data);
        } else {

        //    showBackEnd('form_login');
             echo '<script>';
              echo 'alert("Validation Fail !");';
              echo 'window.history.back(1);';
              echo '</script>'; 
        }
    }
    }
    
     public function datakirim() {
         if (!$this->sessionutility->validateSession()) {
            showBackEndadh('form_login');
        } else {
        // echo 'login oke';  
        if ($this->sessionutility->validateAccess($this)) {

            // echo 'login oke';  
            echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
            echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
            echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
            echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
            echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
            echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');

            $data['title'] = "Data Status Pengiriman";
            showBackEnd1('list_datakirim', $data);
        } else {

        //    showBackEnd('form_login');
             echo '<script>';
              echo 'alert("Validation Fail !");';
              echo 'window.history.back(1);';
              echo '</script>'; 
        }
    }
    }


    public function test() {
//$this->load->model('account');
        $rekap = new Rekapitulasi(1);
        $result = $rekap->getEvaluasi();
// print_r($result);
        echo 'ID Rekapitulasi: ' . $rekap->getIdRekapitulasi() . '</br>';
        foreach ($result as $row) {
            echo 'Id Evaluasi: ' . $row->getIdEvaluasi() . '</br>';
            echo 'Skor: ' . $row->getSkor() . '</br>';
            $e = $row->getEvaluator();
//print_r($e);
            echo 'Evaluator: ' . $e->getNmEvaluator() . '</br>';
        }
        echo 'Total nilai: ' . $rekap->getNilaiTotal();
    }

    public function test2() {
        $proses = new Proses(1);
        $registrasi = $proses->getRegistrasi();
        $pt = $registrasi->getPti();
//foreach ($registrasi as $reg){
        echo 'PTI: ' . $pt->getNmPti() . '</br>';
        echo 'Id registrasi: ' . $registrasi->getIdRegistrasi() . '</br>';
        echo 'Tgl registrasi: ' . $registrasi->getTglRegistrasi() . '</br>';
//}
    }
    
    
      public function test3() {
        echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
        echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
        echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
        echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
        echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
        echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');
        $data['id'] = '2';
        echo "aaaaa"; 
      showBackEnd1('kirimss', $data);
    }

}

?>