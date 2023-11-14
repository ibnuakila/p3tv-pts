<?php

/**
 * @author akil
 * @version 1.0
 * @created 14-Mar-2016 11:12:35
 */
class Monitoring extends EL_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ModUsers');
        $this->load->library('sessionutility');
        $this->load->helper('datatables');
		if (!$this->sessionutility->validateSession()){
			redirect(base_url().'backoffice/');
		}
    }

    function __destruct() {
        
    }

    function logout() {
        $this->session->sess_destroy();
        showBackEnd('form_login');
    }

    function simpan() {
        $id = $this->session->userdata('userid');
        $user = new ModUsers($id);
        //  echo $user->getPassword() . "==" . md5($this->input->post('passwordLama')) . "==" . $this->input->post('passwordBaru') . "==" . md5($this->input->post('passwordBaru'));
        if ($user->getPassword() == md5($this->input->post('passwordLama'))) {
            $user->setUserId($this->input->post('userid'));
            //$user->setUserName($this->input->post('userName'));
            //$user->setEmail($this->input->post('email'));
            $user->setPassword($this->input->post('passwordBaru'));
            //$user->getUserStatus($this->input->post('userStatus'));
            //$user->m_ModUserType = new ModUserType($this->input->post('userType'));
            //$user->m_ModUnitKerja = new ModUnitKerja($this->input->post('unitId'));
            //$user->update();
            $user->updatePassword();
            echo '<script>';
            //echo '<script type="text/javascript">';
            echo 'alert(" Password telah diganti ");';
            echo "window.location='" . base_url('backoffice/backoffice/index') . "'";
            echo '</script>';
        } else {
            $iduser = $this->input->post("userid");
            $this->session->set_flashdata('message', 'Password yang anda masukkan salah!');
            redirect('monitoring/monitoring/ubahpassword/', 'location', 301);
        }
    }

    function ubahpassword() {
        $id = $this->session->userdata('userid');
        $data['user'] = new ModUsers($id);
        showBackEnd1('ubah', $data);
    }

    public function index() {

        if ($this->sessionutility->validateAccess($this)) {

            // echo 'login oke';  
            echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
            echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
            echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
            echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
            echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
            echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');
            $data['title'] = "Akun Pengusul";
            $userid = strtoupper($this->session->userdata('userid'));
            //  echo "user id =" . $userid;
            //  $dt = $this->db->query("select * from users where user_id='$userid'")->row();
            //  if ($dt->unit_id == '26') {
            //    showBackEnd1('listpti1', $data);
            // } else {
            showBackEnd1('listpti', $data);
            // }
        } else {
            echo 'gak login';
            //showBackEnd('form_login');
            /* echo '<script>';
              echo 'alert("Validation Fail !");';
              echo 'window.history.back(1);';
              echo '</script>'; */
        }
    }

    public function data_user() {

        echo 'tes';

        /* if (!$this->sessionutility->validateSession()) {
          showBackEnd('form_login');
          } else {

          if ($this->sessionutility->validateAccess($this)) {

          // echo 'login oke';
          echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
          echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
          echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
          echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
          echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
          echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');

          $data['title'] = "Data Pengguna";
          showBackEnd1('off_user', $data);
          } else {

          showBackEnd('form_login');
          /* echo '<script>';
          echo 'alert("Validation Fail !");';
          echo 'window.history.back(1);';
          echo '</script>'; */
        /* }
          } */
    }

    public function edituser($id) {
        if ($this->session->userdata('is_loged_in') == FALSE)
            redirect('officer');
        $data['title'] = "Form Edit Akun Perguruan Tinggi";
        $data['row'] = $this->db->query("SELECT id,nmpti,email,status,file_path FROM user_pengusul JOIN tbl_pti ON user_pengusul.kdpti=tbl_pti.kdpti where id='$id'")->row();
        showBackEnd1('frmEditUserPTI', $data);
    }

    public function saveuser() {
        if ($this->session->userdata('is_loged_in') == FALSE)
            redirect('officer');
        if ($this->input->post('ajax') == 1) {
            $id = $this->input->post('id');
            $cek = $this->input->post('checkbox');
            $stt = $this->input->post('status');
            //exit;

            $this->load->library('form_validation');
            if ($cek == "1") {
                $this->form_validation->set_rules('subjek', 'subjek', 'required');
                $this->form_validation->set_rules('isi', 'Isi Pesan', 'required');
            }
            $this->form_validation->set_rules('status', 'status', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            //  $this->form_validation->set_message('required', '%s harus diisi');

            if ($this->form_validation->run() == FALSE) {

                $msg = validation_errors();
                $this->session->set_flashdata(
                        'msg', '<div class="alert alert-danger"><strong>' . $msg . '</div>'
                );
                //  redirect('monitoring/monitoring/edituser/' . //$usl_id);
            } else {
                if (trim($this->input->post('password')) == "") {
                    $data = array(
                        'email' => $this->input->post('email'),
                        'status' => $this->input->post('status')
                    );
                } else {
                    $data = array(
                        'password' => md5($this->input->post('password')),
                        'email' => $this->input->post('email'),
                        'status' => $this->input->post('status')
                    );
                }
                $this->db->where('id', $id);
                //print_r($data);

                if ($this->db->update('user_pengusul', $data)) {

                    if ($cek == "1") {
                        $config = Array(
                            'protocol' => 'smtp',
                            'smtp_host' => 'ssl://smtp.googlemail.com',
                            'smtp_port' => 465,
                            'smtp_user' => 'subditppt@gmail.com',
                            'smtp_pass' => 'nanassubang',
                            'mailtype' => 'html',
                            'charset' => 'iso-8859-1'
                        );

                        $this->load->library('email', $config);

                        //    $config = array();
                        //   $config['useragent'] = "CodeIgniter";
                        //    $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                        //    $config['protocol'] = 'smtp';
                        //    $config['smtp_host'] = 'ssl://mail.dikti.go.id'; //change this
                        //    $config['smtp_port'] = '465';
                        //    $config['smtp_user'] = 'app@dikti.go.id';
                        //    $config['smtp_pass'] = 'SecretApp2016!';
                        //    $config['mailtype'] = 'html';
                        //    $config['charset'] = 'iso-8859-1';
                        //   $config['wordwrap'] = TRUE;
                        //   $config['newline'] = "\r\n"; //use double quotes to comply with RFC 822 standard
                        //    $this->load->library('email');
                        //      $this->email->initialize($config);

                        $from = "subdit_ppt@dikti.go.id";
                        $to = $this->input->post('email');
                        $subject = $this->input->post('subjek');
                        $isi = $this->input->post('isi');


                        $this->email->set_newline("\r\n");

                        $this->email->from($from, ' pppts');
                        $this->email->to($to);
                        $this->email->subject($subject);
                        $this->email->message($isi);

                        if ($this->email->send()) {

                            //kalau ditolak hapus dari user pengusul
                            if ($stt == '2') {
                                $this->db->query("delete FROM user_pengusul where id='$id'");
                            }
                            echo '<script>';
                            //echo '<script type="text/javascript">';
                            echo 'alert(" Email Sudah Terkirim ");';
                            echo "window.location='" . base_url('monitoring/monitoring/index') . "'";
                            echo '</script>';
                            
                        } else {


                            echo '<script>';
                            //echo '<script type="text/javascript">';
                            echo 'alert(" Email Tidak Terkirim ");';
                            echo "window.location='" . base_url('monitoring/monitoring/index') . "'";
                            echo '</script>';
                        }
                    } else {
                        redirect('monitoring/monitoring/index');
                    }
                } else {
                    echo "gak kesimpan";
                    exit;
                }
            }
        } else {
            //echo $this->input->post('activate');
            //exit;
        }
    }

    public function login() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('userid', 'User Id', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|xss_clean');

        if ($this->form_validation->run() == TRUE) {

            $userid = strtoupper($this->clearField(htmlentities($this->input->post('userid'))));
            $password = $this->clearField(htmlentities($this->input->post('password')));

            $user = new ModUsers('');
            $user->setUserId($userid);
            $user->setPassword($password);
            if ($user->login()) {

                $session = array('userid' => $userid, 'is_loged_in' => true);
                $this->session->set_userdata($session);

                $this->index();
            } else {
                $data['message'] = 'Userid or Username Invalid!';
                showBackEnd('form_login', $data);
            }
        } else {
            showBackEnd('form_login');
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

    public function testmodel() {
        $this->load->model('registrasi');
        $registrasi = new Registrasi();
        $result = $registrasi->getByRelated('pti', 'nmpti', 'bsi', '0', '0');
        foreach ($result->result() as $reg) {
            $objreg = new Registrasi($reg->id_registrasi);
            echo 'Id registrasi: ' . $objreg->getIdRegistrasi() . '</br>';
            echo 'Tgl Registrasi: ' . $objreg->getTglRegistrasi() . '</br>';
            $account = $objreg->getAccount();
            echo 'Email account: ' . $account->getEmail() . '</br>';
            $yayasan = $account->getYayasan();
            echo 'Yayasan: ' . $yayasan->getNamaYayasan() . '</br>';
            $pti = $objreg->getPti();
            echo 'PT: ' . $pti->getNmPti() . '</br>';
            echo '----------------------------------</br>';
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

    public function hapus($id) {
        if ($this->sessionutility->validateAccess($this)) {
            $this->db->query("delete FROM user_pengusul where id='$id'");
            redirect('monitoring/monitoring/index');
        } else {
            echo "tes";
            echo '<script>';
            echo 'alert("Tidak ada hak untuk menghapus user");';
            echo 'window.history.back()';
            // echo 'window.location="'.base_url().'officer/officer/data_user"';
            echo '</script>';
            //   $data2['user'] = null;
            // redirect(base_url().'officer/officer/data_user');
        }
    }

    public function lookup() {
        $table = " SELECT id,nmpti,email,CASE WHEN `status`='0' THEN 'Non aktif' WHEN `status`='1' THEN  'Aktif' ELSE 'Tolak' 
END AS `status`,file_path,kdpti FROM (SELECT id,nmpti,email,`status`,file_path,user_pengusul.kdpti FROM user_pengusul JOIN pti ON user_pengusul.kdpti=pti.kdpti 
ORDER BY id DESC ) AS user_pengusul   ";
//'<a class="btn btn-primary btn-xs" href="../aliaslogin/index/'+row[0]+'" target="_blank"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</a> '+
        // Table's primary key
        $primaryKey = 'id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes No Agenda, No TU,No surat, Asal Surat,tanggal surat, Perihal,Keterangan   , Action

        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'nmpti', 'dt' => 1),
            array('db' => 'email', 'dt' => 2),
            array('db' => 'status', 'dt' => 3),
            array('db' => 'file_path', 'dt' => 4),
            array('db' => 'kdpti', 'dt' => 5)
        );

        echo json_encode(
                multiple($_GET, $table, $primaryKey, $columns)
        );
    }

}

?>