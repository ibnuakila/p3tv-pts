<?php



/**
 * Description of KelolaDanaPendamping
 *
 * @author ibnua
 */
class KelolaDanaPendamping extends MX_Controller implements IControll {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('sessionutility');
        $this->load->library('WebServiceAgent');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
        $this->load->model('registrasi');
        $this->load->model('verifikasi');
        $this->load->model('periode');
        //$this->load->model('dokumenperbaikan');
        //$this->load->model('dokumenperbaikanupload');
        //$this->load->model('rekapitulasiberitaacara');
        //$this->load->model('ProdiPelaporanPddikti');
        //$this->load->model('LaporanPernyataan');
        //$this->load->model('LaporanCapaian');
        //$this->load->model('LaporanIndikator');
        //$this->load->model('Registrasiprodi');
        //$this->load->model('Penanggungjawab');
    }
    
    public function add() {
        
    }

    public function edit() {
        
    }

    public function find() {
        
    }

    public function index() {
        //if($this->sessionutility->validateAccess($this)){
        
            $id_registrasi = trim($this->input->post('id_registrasi'));
            $yayasan = trim($this->input->post('yayasan'));
            $pti = trim($this->input->post('pti'));
            $tgl_registrasi = trim($this->input->post('tgl_registrasi'));
            $periode = trim($this->input->post('periode'));
            //$schema = trim($this->input->post('schema'));
            $status_registrasi = trim($this->input->post('status_registrasi'));
            $publish_verifikasi = trim($this->input->post('publish_verifikasi'));
            //var_dump($temp_post);
            $segment = $this->uri->segment(4,0);  
            $temp_post = $this->input->post(NULL, TRUE);
            if (!$temp_post) {
                $id_registrasi = trim($this->session->flashdata('id_registrasi'));
                $yayasan = trim($this->session->flashdata('yayasan'));
                $pti = trim($this->session->flashdata('pti'));
                $tgl_registrasi = trim($this->session->flashdata('tgl_registrasi'));
                $periode = trim($this->session->flashdata('periode'));
                $status_registrasi = trim($this->session->flashdata('status_registrasi'));
                $publish_verifikasi = trim($this->session->flashdata('publish_verifikasi'));
                //$schema = trim($this->session->flashdata('schema'));
            }
            $flash_data = array(
                            'id_registrasi' => $id_registrasi,                        
                            'yayasan' => $yayasan,
                            'pti' => $pti,                    
                            'tgl_registrasi' => $tgl_registrasi,
                            'periode' => $periode,
                            //'schema' => $schema,
                            'status_registrasi' => $status_registrasi,
                            'publish_verifikasi' => $publish_verifikasi
                        );
            $this->session->set_flashdata($flash_data);
            $mperiode = new Periode();                        
            $current_periode = $mperiode->getOpenPeriode();
            //print_r($current_periode);
        
            $params = [];
            if ($this->input->post('export')) {
                $params['paging'] = ['row' => 0, 'segment' => 0];
            } else {
                $params['paging'] = ['row' => 10, 'segment' => $segment];
            }
            $table = 'registrasi';
            $params['field'][$table.'.periode'] = ['=' => $current_periode[0]];
            if($id_registrasi != ''){                    
                $params['field'][$table.'.id_registrasi'] = ['=' => $id_registrasi];
            }
            if($tgl_registrasi != ''){                
                $params['field'][$table.'.tgl_registrasi'] = ['=' => $tgl_registrasi];
            }
            /*if($schema != ''){                
                $params['field'][$table.'.skema'] = ['=' => $schema];
            }*/
            if($periode != ''){                
                $params['field'][$table.'.periode'] = ['=' => $periode];
            }
            if($status_registrasi != ''){                    
            $params['field'][$table.'.id_status_registrasi'] = ['=' => $status_registrasi];
            }
            if($yayasan != ''){
                $params['join']['tbl_badan_penyelenggara'] = ['INNER' => $table.'.kdpti = tbl_badan_penyelenggara.kdpti'];
                $params['field']['tbl_badan_penyelenggara.nama_penyelenggara'] = ['LIKE' => $yayasan];
            }
            if($pti != ''){
                $params['join']['tbl_pti'] = ['INNER' =>$table.'.kdpti = tbl_pti.kdpti'];
                $params['field']['tbl_pti.nmpti'] = ['LIKE' => $pti];
            }
            if($publish_verifikasi != ''){
                $params['join']['verifikasi'] = ['INNER' => $table.'.id_registrasi = verifikasi.id_registrasi'];
                $params['field']['verifikasi.publish'] = ['=' => $publish_verifikasi];
            }
            $params['order'][$table.'.tgl_registrasi'] = 'DESC';
            $registrasi = new Registrasi();        
            $result = $registrasi->getResult($params);
            //configure pagination
            $params['count'] = true;
            //print_r($result);
            $total_row = $registrasi->getResult($params);
            $base_url = base_url() . 'backoffice/kelolaregistrasi/index/';
            $uri_segment = '4';
            $per_page = 10;
            //setPagingTemplate($base_url, $uri_segment, $total_row);
            setPagingTemplate($base_url, $uri_segment, $total_row, $per_page);
            //data periode
            $mperiode = new Periode();
            $result_periode = $mperiode->get('0','0');
            $option_periode = array('' => '~Pilih~');      
            foreach ($result_periode->result() as $value) {
                $option_periode[$value->periode] = $value->periode;
            }            
            $data['periode'] = $option_periode;

            //data status registrasi
            $mstatus_registrasi = new StatusRegistrasi();
            $result_status = $mstatus_registrasi->get('0', '0');
            $option_status = array('' => '~Pilih~');      
            foreach ($result_status->result() as $value) {
                $option_status[$value->id_status_registrasi] = $value->nama_status;
            }            
            $data['status_registrasi'] = $option_status;

            $skema = array(''=>'-Pilih-','A'=>'A', 'B'=>'B', 'C'=>'C');
            //publish verifikasi
            $opt_verifikasi = array('' => '~Pilih~', 'yes' => 'Yes', 'no' => 'No');
            $data['publish_verifikasi'] = $opt_verifikasi;
            $data['skema'] = $skema;
            $data['registrasi'] = $result;
            $data['total_row'] = $total_row;
            $view = 'list_registrasi';
            add_footer_js('js/app/index_registrasi.js');
            if ($this->input->post('export')) {
                //$this->load->view('list_prodi_registrasi_excell.php',$data);
            } else {
                showNewBackEnd('backoffice/'.$view, $data, 'index-1');
            }
        /*}else{
          echo '<script>';
          echo 'alert("Validation Fail !");';
          echo 'window.history.back(1);';
          echo '</script>';
        }*/
    }

    public function remove() {
        
    }

    public function save() {
        
    }
}
