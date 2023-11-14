<?php

/**
 * @author akil
 * @version 1.0
 * @created 14-Mar-2016 11:12:35
 */
class Officer extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Modusers');
        $this->load->library('sessionutility');
        $this->load->helper('datatables');
    }

    function __destruct() {
        
    }

    function logout() {
        $this->session->sess_destroy();
        showBackEnd('form_login');
    }

    public function index() {


        if ($this->sessionutility->validateAccess($this)) {
            // echo 'login oke';  
            showNewBackEnd('welcome');
        } else {

            showNewBackEnd('form_login');
            /* echo '<script>';
              echo 'alert("Validation Fail !");';
              echo 'window.history.back(1);';
              echo '</script>'; */
        }
    }

    public function data_user() {


        if ($this->sessionutility->validateAccess($this)) {

            //echo 'officer oke';  
            /* echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
              echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
              echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
              echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
              echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
              echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');
              add_footer_js('js/app/officer_datauser.js'); */

            //capture input from posts data
            $userid = trim($this->input->post('user_id'));
            $user_name = trim($this->input->post('user_name'));
            $email = trim($this->input->post('email'));
            $user_type = trim($this->input->post('user_type'));

            //check wether posts is null                
            $temp_post = $this->input->post(NULL, TRUE);
            if (!$temp_post) {//get data from flash
                $userid = trim($this->session->flashdata('user_id'));
                $user_name = trim($this->session->flashdata('user_name'));
                $email = trim($this->session->flashdata('email'));
                $user_type = trim($this->session->flashdata('user_type'));
            }
            //configure flash data
            $flash_data = array(
                'user_id' => $userid,
                'user_name' => $user_name,
                'email' => $email,
                'user_type' => $user_type
            );
            $this->session->set_flashdata($flash_data);

            //configure parameter for query
            $segment = $this->uri->segment(4, 0);
            $params = [];
            if ($this->input->post('export')) {
                $params['paging'] = ['row' => 0, 'segment' => 0];
            } else {
                $params['paging'] = ['row' => 10, 'segment' => $segment];
            }

            if ($userid != '') {
                $params['field'][ModUsers::table . '.user_id'] = ['=' => $userid];
            }
            if ($user_name != '') {
                $params['field'][ModUsers::table . '.user_name'] = ['LIKE' => $user_name];
            }
            if ($email != '') {
                $params['field'][ModUsers::table . '.email'] = ['=' => $email];
            }
            if ($user_type != '') {
                $params['field'][ModUsers::table . 'user_type'] = ['=' => $user_type];
            }
            $params['order'][ModUsers::table . '.user_id'] = 'ASC';

            //get the data
            $user = new ModUsers();
            $result = $user->getResult($params);

            //configure pagination
            $params['count'] = true;
            $total_row = $user->getResult($params);
            $base_url = base_url() . 'officer/officer/data_user/';
            $uri_segment = '4';
            $per_page = 10;
            setPagingTemplate($base_url, $uri_segment, $total_row, $per_page);

            $data['total_row'] = $total_row;
            $data['result'] = $result;
            showNewBackEnd('user_data', $data, 'index-1');
        } else {

            showNewBackEnd('form_login');
            /* echo '<script>';
              echo 'alert("Validation Fail !");';
              echo 'window.history.back(1);';
              echo '</script>'; */
        }
    }

    public function create() {
        if ($this->sessionutility->validateAccess($this)) {
            $userid = $this->session->userdata('userid');
            $user = new ModUsers('');
            // echo $this->input->post('email');
            $id = $this->input->post('user_id');
            $user->setUserId($this->input->post('user_id'));
            $user->setUserName($this->input->post('user_name'));
            $user->setEmail($this->input->post('email'));
            $user->setPassword($this->input->post('password'));
            $user->m_ModUserType = new ModUserType($this->input->post('user_type'));
            $user->m_ModUnitKerja = new ModUnitKerja($this->input->post('unit_id'));
            $user->insert();
            // $useraccess = new ModUserAccess('','');
            $access = $this->input->post('submod');
            // print_r ($system);
            if ($access) {
                $i = 1;
                foreach ($access as $as):
                    $useraccess = new ModUserAccess('');
                    $useraccess->setUserId($id);

                    // echo $useraccess->getUserId();
                    $useraccess->m_ModSubSystemModule = new ModSubSystemModule();
                    $useraccess->m_ModSubSystemModule->setSubModuleId($as);
                    ;
                    // var_dump($useraccess);
                    // $submodule->setSubModuleId($access);
                    $useraccess->insert();
                    $i++;
                endforeach;
            }
            echo '<script type="text/javascript">alert("Data berhasil disimpan.");';
            echo 'window.location.href="' . base_url() . 'officer/officer/data_user";';
            echo '</script>';
        } else {
            echo "harusnya login dulu";
            $data2['user'] = null;
            redirect('backoffice/form_login');
        }
    }

    public function update() {
        if ($this->sessionutility->validateAccess($this)) {
            $id = $this->input->post('user_id');
            $user = new ModUsers($id);
            //$user->setUserId($this->input->post('user_id'));
            $user->setUserName($this->input->post('user_name'));
            $user->setEmail($this->input->post('email'));
            // $user->setPassword($this->input->post('password'));
            $user->m_ModUserType = new ModUserType($this->input->post('user_type'));
            $user->m_ModUnitKerja = new ModUnitKerja($this->input->post('unit_id'));

            $user->update();

            $access = $this->input->post('submod');
            // print_r ($system);
            $useraccess = new ModUserAccess($id);
            $useraccess->delete();
            if ($access) {
                $i = 1;
                foreach ($access as $as):
                    $useraccess->setUserId($id);

                    // echo $useraccess->getUserId();
                    $useraccess->m_ModSubSystemModule = new ModSubSystemModule();
                    $useraccess->m_ModSubSystemModule->setSubModuleId($as);
                    ;
                    // var_dump($useraccess);
                    // $submodule->setSubModuleId($access);
                    $useraccess->insert();
                    $i++;
                endforeach;
            }

            echo '<script type="text/javascript">alert("Data berhasil disimpan.");';
            echo 'window.location.href="' . base_url() . 'officer/officer/data_user";';
            echo '</script>';
        } else {
            echo "harusnya login dulu";
            $data2['user'] = null;
            redirect('officer/officer/form_login');
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

    public function add() {

        if ($this->sessionutility->validateAccess($this)) {
            $id = $this->session->userdata('userid');
            $unitKerja = new modunitkerja('');
            $userType = new modusertype('');
            $systemModule = new modsystemmodule('');
            $subSystemModule = new ModSubSystemModule('', '');
            $data['access'] = $subSystemModule->getObjectList('', '');

            $data['userType'] = $userType->getObjectList('', '');
            $data['unitKerja'] = $unitKerja->getObjectList('', '');

            //    $data['cluster'] = $this->cluster_model->getAllCluster();

            showNewBackEnd('formUser', $data, 'index-1');
        } else {
            echo '<script>';
            echo 'alert("Tidak ada hak untuk menambah user");';
            echo 'window.history.back()';
            // echo 'window.location="'.base_url().'officer/officer/data_user"';
            echo '</script>';
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
            //$userid = $this->session->userdata('userid');
            $user = new ModUsers($id);
            //$access = new moduseraccess($id,'');
            // if($access){
            //$access->delete();
            // }
            $user->delete();

            redirect('officer/officer/data_officer');
        } else {

            echo '<script>';
            echo 'alert("Tidak ada hak untuk menghapus user");';
            echo 'window.history.back()';
            // echo 'window.location="'.base_url().'officer/officer/data_user"';
            echo '</script>';
            //   $data2['user'] = null;
            // redirect(base_url().'officer/officer/data_user');
        }
    }

    public function edit($id) {
        // $data2 = $this->cekLogin();
        if ($this->sessionutility->validateAccess($this)) {
            $userid = $this->session->userdata('userid');
            //$data = $this->cekLogin();
            $unitKerja = new modunitkerja('');
            $userType = new modusertype('');
            $subSystemModule = new ModSubSystemModule('', '');
            $useraccess = new moduseraccess($id);

            $data['access'] = $subSystemModule->getObjectList('', '');
            $data['useraccess'] = $useraccess;
            $data['userType'] = $userType->getObjectList('', '');
            $data['unitKerja'] = $unitKerja->getObjectList('', '');

            $user = new ModUsers($id);
            $data['userSelected'] = $user;
            //     $data['cluster'] = $this->cluster_model->getAllCluster();

          //  showBackEnd('formUserUpdate', $data);
             showNewBackEnd('formUserUpdate', $data, 'index-1');
            /*
              $this->load->view('admin_konten/header.php', $data2);
              $this->load->view('formUserUpdate.php', $data);
              $this->load->view('admin_konten/footer.php'); */
        } else {
            echo '<script>';
            echo 'alert("Tidak ada hak untuk mengedit user");';
            echo 'window.history.back()';
            // echo 'window.location="'.base_url().'officer/officer/data_user"';
            echo '</script>';
        }
    }

    public function lookup() {
        $table = ' SELECT user_id,user_name,email,unit_name,type_name  
FROM users join unit_kerja on users.unit_id=unit_kerja.unit_id join user_type 
on users.user_type=user_type.user_type ';

        // Table's primary key
        $primaryKey = 'user_id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes No Agenda, No TU,No surat, Asal Surat,tanggal surat, Perihal,Keterangan   , Action

        $columns = array(
            array('db' => 'user_id', 'dt' => 0),
            array('db' => 'user_name', 'dt' => 1),
            array('db' => 'email', 'dt' => 2),
            array('db' => 'unit_name', 'dt' => 3),
            array('db' => 'type_name', 'dt' => 4)
        );

        echo json_encode(
                multiple($_GET, $table, $primaryKey, $columns)
        );
    }

}

?>