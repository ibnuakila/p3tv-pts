<?php

/**
 * @author akil
 * @version 1.0
 * @created 14-Mar-2016 11:12:35
 */
class Kontak extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Modusers');
        $this->load->library('sessionutility');
        $this->load->library('form_validation');
        $this->load->helper('datatables');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
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
            echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
            echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
            echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
            echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
            echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
            echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');
            $data['title'] = "Daftar Pertanyaan";
            $userid = strtoupper($this->session->userdata('userid'));
            //  echo "user id =" . $userid;
            //  $dt = $this->db->query("select * from users where user_id='$userid'")->row();
            //  if ($dt->unit_id == '26') {
            //    showBackEnd1('listpti1', $data);
            // } else {
            // showBackEnd('listtanya', $data,'index_new');
            showNewBackEnd('listtanya', $data, 'index-1');
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

    public function jawab($id) {
       // redirect(base_url() . 'monitoring/kontak/index');
        if ($this->session->userdata('is_loged_in') == FALSE)
            redirect('officer');
        $data['title'] = "Jawab Pertanyaan";
        $data['row'] = $this->db->query("select * from hubungikami where id='$id'")->row();
        //  showBackEnd1('jawab', $data);
        showNewBackEnd('jawab', $data, 'index-1');
    }

    public function savejawab() {
        if ($this->session->userdata('is_loged_in') == FALSE) redirect('officer');

       

       

            $to = $this->input->post('email', TRUE); // TRUE untuk XSS Cleaning
            $subject = $this->input->post('subjek', TRUE);
            $isi = $this->input->post('isi', TRUE);
            $tanya = $this->input->post('tanya', TRUE);
            $id = $this->input->post('id', TRUE);



            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'adm.kelembagaan@gmail.com',
                'smtp_pass' => 'tcinrffvyvpfvpvq',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );


            $this->load->library('email', $config);
            $from = "adm.kelembagaan@gmail.com";

//            $to = $this->input->post('email');
//            $subject = $this->input->post('subjek');
//            $isi = $this->input->post('isi');
//            $tanya = $this->input->post('tanya');
//            $id = $this->input->post('id');

            $isi2 = $isi . "<br/> <br/> \r\n\r\n Pertanyaan : \r\n <br/>" . $tanya;

            $this->email->set_newline("\r\n");

            $this->email->from($from, ' ppptv-pts');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($isi2);

            if ($this->email->send()) {

                $userid = strtoupper($this->session->userdata('userid'));
                $data = array(
                    'jawaban' => $isi,
                    'userjawab' => $userid,
                    'status' => '1',
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->db->where('id', $id);
                //print_r($data);

                if ($this->db->update('hubungikami', $data))
                    echo '<script>';
                //echo '<script type="text/javascript">';
                echo 'alert(" Email Sudah Terkirim ");';
                echo "window.location='" . base_url('monitoring/kontak/index') . "'";
                echo '</script>';
            } else {


                echo '<script>';
                //echo '<script type="text/javascript">';
                echo 'alert(" Email Tidak Terkirim ");';
                echo "window.location='" . base_url('monitoring/kontak/index') . "'";
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

    public function lookup() {
        $table = " select * from ( SELECT id, nama, email, wa, judul, pesan, status, userjawab, jawaban, DATE_FORMAT(created_at, '%d-%m-%Y') AS created_at, updated_at
FROM hubungikami order by status, id desc ) as adh ";
//'<a class="btn btn-primary btn-xs" href="../aliaslogin/index/'+row[0]+'" target="_blank"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</a> '+
        // Table's primary key
        $primaryKey = '';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes No Agenda, No TU,No surat, Asal Surat,tanggal surat, Perihal,Keterangan   , Action
//INSERT INTO `ppptv`.`hubungikami`(`id`, `nama`, `email`, `wa`, `judul`, `pesan`, `status`, `userjawab`) 
        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'nama', 'dt' => 1),
            array('db' => 'email', 'dt' => 2),
            array('db' => 'wa', 'dt' => 3),
            array('db' => 'created_at', 'dt' => 4),
            array('db' => 'judul', 'dt' => 5),
            array('db' => 'userjawab', 'dt' => 6),
            array('db' => 'status', 'dt' => 7)
        );

        echo json_encode(
                multiple($_GET, $table, $primaryKey, $columns)
        );
    }

}

?>