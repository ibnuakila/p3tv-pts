<?php
require_once ('Icontroll.php');




/**
 * @author akil
 * @version 1.0
 * @created 29-Mar-2016 20:52:54
 */
class KelolaPenugasan extends MX_Controller implements IControll
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('sessionutility');
		$this->load->library('form_validation');
		if (!$this->sessionutility->validateSession()){
			redirect(base_url().'backoffice/');
		}
		$this->load->model('registrasi');
		$this->load->model('proses');
                $this->load->model('periode');
	}

	function __destruct()
	{
	}



	public function add()
	{
		$view = 'form_penugasan';
		$id_reg = $this->uri->segment(4,0);
		$registrasi = new Registrasi($id_reg);
		$this->db->select('*');
		$this->db->from('jenis_evaluasi');
		$result = $this->db->get();
                $jns_evaluasi[0] = '-Pilih-';
		foreach($result->result() as $row){
			$jns_evaluasi[$row->id_jns_evaluasi] = $row->nama_evaluasi;
		}
		$data['jns_evaluasi'] = $jns_evaluasi;
		$data['registrasi'] = $registrasi;
		$data['flagInsert'] = 'true';
                add_footer_css('jquery-ui-1.12.1/jquery-ui.css');
                add_footer_js('jquery-ui-1.12.1/jquery-ui.js');
                add_footer_js('js/app/penugasan.js');
		showNewBackEnd('backoffice/'.$view,$data,'index-1');
	}

	public function edit()
	{
		$view = 'form_penugasan';
		$id_proses = $this->uri->segment(4,0);
		$proses = new Proses($id_proses);		
		$registrasi = $proses->getRegistrasi();
                $this->db->select('*');
		$this->db->from('jenis_evaluasi');
		$result = $this->db->get();
                $jns_evaluasi[0] = '-Pilih-';
                $jns_evaluasi[0] = '-Pilih-';
		foreach($result->result() as $row){
			$jns_evaluasi[$row->id_jns_evaluasi] = $row->nama_evaluasi;
		}
                $data['jns_evaluasi'] = $jns_evaluasi;
		$data['proses'] = $proses;
		$data['registrasi'] = $registrasi;
		$data['flagInsert'] = 'false';
                add_footer_css('jquery-ui-1.12.1/jquery-ui.css');
                add_footer_js('jquery-ui-1.12.1/jquery-ui.js');
                add_footer_js('js/app/penugasan.js');
		showNewBackEnd('backoffice/'.$view,$data,'index-1');
	}

	public function find()
	{
		if($this->sessionutility->validateAccess($this)){
			$view = 'list_penugasan';
		
			$keyword = $this->input->post('keyword');
			$filter = $this->input->post('filter');
			$fdate = $this->input->post('tglawal');
			$ldate = $this->input->post('tglakhir');
			//echo $filter.','.$this->input->post('export');
			$uri_segment = '0';
			$segment = '0';
				
                        $temp_post = $this->input->post(NULL, TRUE);
                        if(!$temp_post){
                            $keyword = trim($this->session->flashdata('keyword'));
                            $filter = trim($this->session->flashdata('filter'));
                            $fdate = trim($this->session->flashdata('fdate'));
                            $ldate = trim($this->session->flashdata('ldate'));
                        }
			$temp_filter = array(
                                    'keyword' => $keyword,                        
                                    'filter' => $filter,
                                    'fdate' => $fdate,                    
                                    'ldate' => $ldate,                                    
                                );
                        $this->session->set_flashdata($temp_filter);
			$registrasi = new Registrasi();
			//$registrasi->setIdStatusRegistrasi('0');
			$registrasi->setPenugasan('2');
			$periode = new Periode();
			$record_periode = $periode->get('0', '0');
			$current_periode = $periode->getOpenPeriode();
			$registrasi->setPeriode($current_periode);
			//$segment = $this->uri->segment(4,0);
			$per_page = 10; $total_row = 0;
			$result = '';
			//echo $filter;
			if($this->input->post('export')){
				//echo 'is export</br>';
				if ($filter=='nmpti'){
					$result = $registrasi->getByRelated('tbl_pti', $filter, $keyword, $per_page, $segment);
				}elseif ($filter=='nama_penyelenggara'){
					$result = $registrasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword, $per_page, $segment);
				}elseif ($filter=='id_registrasi'){
					$result = $registrasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
				}elseif ($filter=='nama_status'){
					$registrasi->setIdStatusRegistrasi('');
					$result = $registrasi->getByRelated('status_registrasi', $filter, $keyword, $per_page, $segment);
					$total_row = $registrasi->getByRelated('status_registrasi', $filter, $keyword);
				}elseif ($filter=='all'){
					$result = $registrasi->get('0','0');
				}
			}else{
				//echo 'is record</br>';
				if ($filter=='nmpti'){
					$result = $registrasi->getByRelated('tbl_pti', $filter, $keyword, $per_page, $segment);
					$total_row = $registrasi->getByRelated('tbl_pti', $filter, $keyword);
				}elseif ($filter=='nama_penyelenggara'){
					$result = $registrasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword, $per_page, $segment);
					$total_row = $registrasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword);
				}elseif ($filter=='id_registrasi'){
					$result = $registrasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
					$total_row = $registrasi->getByRelated('registrasi', $filter, $keyword);
				}elseif ($filter=='nama_status'){
					$result = $registrasi->getByRelated('status_registrasi', $filter, $keyword, $per_page, $segment);
					$total_row = $registrasi->getByRelated('status_registrasi', $filter, $keyword);
				}elseif ($filter=='all'){
					$result = $registrasi->get($per_page,$segment);
				}
			}
				
			$base_url = base_url().'backoffice/kelolaregistrasi/find/'.$filter.'/'.$keyword.'/';
			setPagingTemplate($base_url, 4, $total_row, $per_page);
			$data['registrasi'] = $result;
			$data['total_row'] = $total_row;
			$data['selected_filter'] = $filter;
			if ($this->input->post('export')){
				$this->load->view('export_registrasi',$data);
				//print_r($result);
			}else{
				showNewBackEnd('backoffice/'.$view,$data,'index-1');
			}
		}else{
			echo '<script>';
			echo 'alert("Validation Fail !");';
			echo 'window.history.back(1);';
			echo '</script>';
		}
	}

	public function __index()
	{
		if($this->sessionutility->validateAccess($this)){
			$view = 'list_penugasan';
			
			$registrasi = new Registrasi();
			$segment = $this->uri->segment(4,0);
			$per_page = 20;
			$periode = new Periode();
			$periode->getBy('status_periode', 'open');                
			$current_periode = $periode->getOpenPeriode();
			$open_periode = $current_periode[0];
                        
			$registrasi->setPeriode($open_periode);
			$result = $registrasi->getByPenugasan($per_page,$segment);
			$total_row = $registrasi->getByPenugasan();
			$base_url = base_url().'backoffice/kelolapenugasan/index';
			setPagingTemplate($base_url, 4, $total_row, $per_page);
			$data['registrasi'] = $result;
			$data['total_row'] = $total_row;
			showNewBackEnd('backoffice/'.$view,$data,'index-1');
		}else{
			echo '<script>';
			echo 'alert("Validation Fail !");';
			echo 'window.history.back(1);';
			echo '</script>';
		}
	}

	public function remove()
	{
		if($this->sessionutility->validateAccess($this)){
			
		}else{
			echo '<script>';
			echo 'alert("Validation Fail !");';
			echo 'window.history.back(1);';
			echo '</script>';
		}
	}
        
        public function index()
        {
            if($this->sessionutility->validateAccess($this)){
        
                $id_registrasi = trim($this->input->post('id_registrasi'));
                $yayasan = trim($this->input->post('yayasan'));
                $pti = trim($this->input->post('pti'));
                $tgl_registrasi = trim($this->input->post('tgl_registrasi'));
                $periode = trim($this->input->post('periode'));
                $schema = trim($this->input->post('schema'));
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
                    $schema = trim($this->session->flashdata('schema'));
                }
                $flash_data = array(
                                'id_registrasi' => $id_registrasi,                        
                                'yayasan' => $yayasan,
                                'pti' => $pti,                    
                                'tgl_registrasi' => $tgl_registrasi,
                                'periode' => $periode,
                                'schema' => $schema,
                                'status_registrasi' => $status_registrasi,
                                'publish_verifikasi' => $publish_verifikasi
                            );
                $this->session->set_flashdata($flash_data);
                $mperiode = new Periode();
                $mperiode->getBy('status_periode', 'open');                
                $current_periode = $mperiode->getOpenPeriode();
                $open_periode = $current_periode[0];
                        
                $params = [];
                if ($this->input->post('export')) {
                    $params['paging'] = ['row' => 0, 'segment' => 0];
                } else {
                    $params['paging'] = ['row' => 10, 'segment' => $segment];
                }
                $table = 'registrasi';
                $params['field'][$table.'.id_status_registrasi'] = ['IN' => [2,3,11,8]];
                $params['field'][$table.'.penugasan'] = ['<' => 2];
                $params['field'][$table.'.periode'] = ['=' => $open_periode];
                if($id_registrasi != ''){                    
                    $params['field'][$table.'.id_registrasi'] = ['=' => $id_registrasi];
                }
                if($tgl_registrasi != ''){                
                    $params['field'][$table.'.tgl_registrasi'] = ['=' => $tgl_registrasi];
                }
                if($schema != ''){                
                    $params['field'][$table.'.skema'] = ['=' => $schema];
                }
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
                $base_url = base_url() . 'backoffice/kelolapenugasan/index/';
                $uri_segment = '4';
                $per_page = 10;
                //setPagingTemplate($base_url, $uri_segment, $total_row);
                setPagingTemplate($base_url, $uri_segment, $total_row, $per_page);
                //data periode
                //$mperiode = new Periode();
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
                //$opt_verifikasi = array('' => '~Pilih~', 'yes' => 'Yes', 'no' => 'No');
                //$data['publish_verifikasi'] = $opt_verifikasi;
                $data['skema'] = $skema;
                $data['registrasi'] = $result;
                $data['total_row'] = $total_row;
                $view = 'list_penugasan';
                add_footer_js('js/app/index_penugasan.js');
                if ($this->input->post('export')) {
                    //$this->load->view('list_prodi_registrasi_excell.php',$data);
                } else {
                    showNewBackEnd('backoffice/'.$view, $data, 'index-1');
                }
            }else{
              echo '<script>';
              echo 'alert("Validation Fail !");';
              echo 'window.history.back(1);';
              echo '</script>';
            }
        }
	
	public function save() {
		if($this->sessionutility->validateAccess($this)){
			//validation
			$this->form_validation->set_rules('idevaluator', 'Evaluator', 'trim|required');
			$this->form_validation->set_rules('type', 'Type', 'trim|required');
			$this->form_validation->set_rules('tglkirim', 'TglKirim', 'trim|required');
			$this->form_validation->set_rules('tglexpire', 'TglExpire', 'trim|required');
			$this->form_validation->set_rules('idregistrasi', 'IDRegistrasi', 'trim|required');
			
			$idevaluator = trim($this->input->post('idevaluator'));
			$evaluator = trim($this->input->post('evaluator'));
			$type = trim($this->input->post('type'));
			$tgl_kirim = trim($this->input->post('tglkirim'));
			$tgl_expire = trim($this->input->post('tglexpire'));
			$batch = trim($this->input->post('batch'));
			$idregistrasi = trim($this->input->post('idregistrasi'));
			$idproses = $this->input->post('id_proses');
			$id_jns_evaluasi = $this->input->post('jns_evaluasi');
			$flaginsert = $this->uri->segment(4);
			
			if ($this->form_validation->run()){
                            $objReg = new Registrasi($idregistrasi);
				$proses = new Proses($idproses);
				$proses->setIdProses($idproses);
				$proses->setIdEvaluator($idevaluator);
				$proses->setTypeEvaluator($type);
				$proses->setTglKirim($tgl_kirim);
				$proses->setTglExpire($tgl_expire);
				$proses->setIdJnsEvaluasi($id_jns_evaluasi);
				$proses->setRevisi($objReg->getRevisi());
				$proses->setBatch($batch);
                                
                                
				if($flaginsert=='true'){
					$proses->setIdStatusProses('1');
					$proses_registrasi = new ProsesRegistrasi();
					
					$proses_registrasi->setIdRegistrasi($idregistrasi);
					
					if(! $proses->isExist($idregistrasi)){
						$ret = $proses->insert();
						$proses_registrasi->setIdProses($proses->getIdProses());
						//$objReg = new Registrasi($idregistrasi);
						if($ret){
							$i = $objReg->getPenugasan();
							$i++;
							$objReg->setPenugasan($i);
							$objReg->update();
						}						

					}elseif($idproses=='' && $objReg->getRevisi()>0){
                                            //$proses->setRevisi($objReg->getRevisi());
                                            $ret = $proses->insert();
                                            $proses_registrasi->setIdProses($proses->getIdProses());

                                            if($ret){
                                                $i = $objReg->getPenugasan();
                                                $i++;
                                                $objReg->setPenugasan($i);
                                                $objReg->update();
                                            }
						
					}else{
                                            $proses->update();
                                            $proses_registrasi->setIdProses($proses->getIdProses());
                                            $proses_registrasi->delete();
                                        }
									
					$proses_registrasi->insert();
					$pti = $objReg->getPti();
					$objEva = new Evaluator($evaluator);
					$email = $objEva->getEmail();
					$res_evaluator = $objEva->getByRelated('evaluator', 'id_evaluator', $evaluator, '0', '0');
					$userid = '';
					foreach ($res_evaluator->result() as $row){
						$userid = $row->user_id;
					}
					$this->load->helper('internet');
					/*$this->load->library('email');
					$config['useragent'] = "CodeIgniter";
					$config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
					$config['protocol'] = 'smtp';
					$config['smtp_host'] = 'ssl://mail.dikti.go.id'; //change this
					$config['smtp_port'] = '465';
					$config['smtp_user'] = 'app@dikti.go.id';
					$config['smtp_pass'] = 'SecretApp2016!';
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['newline'] = "\r\n";
					$this->email->initialize($config);*/
					//if(is_connected()){
						$config = Array(
							'protocol' => 'smtp',
							'smtp_host' => 'ssl://smtp.googlemail.com',
							'smtp_port' => 465,
							'smtp_user' => 'subditppt@gmail.com',
							'smtp_pass' => 'nanassubang',
							'mailtype' => 'html',
							'charset' => 'iso-8859-1',
							'newline' => '\r\n'
						);
						$this->load->library('email', $config);
						
						$this->email->from('subdit_ppt@dikti.go.id', 'PPPTS');
						$this->email->to($email);
						$this->email->cc('ibnuakila@yahoo.com');
						//$this->email->bcc('them@their-example.com');
						
						$this->email->subject('Proposal Evaluasi');
						$this->email->message('Yth.'.$objEva->getNmEvaluator().'\r\n'.'Anda telah dikirimi proposal penilaian PPPTS sebagai berikut:\r\n '.
								'Nama PT: '.$pti->getNmPti().'\r\n '.							
								'Harap login di alamat: http://pppts.ristekdikti.go.id/backoffice , Terima Kasih.\r\n '.
								'*User: '.$userid.', Password: pppts2017.\r\n '.
								'(*) Untuk evaluator yang belum memiliki Account.');
						
						//$this->email->send();
					//}
					
				}else{
					$proses->update();
					
					$objReg = new Registrasi($idregistrasi);
					$i = $objReg->getPenugasan();
					$i++;
					$objReg->setPenugasan($i);
					//$objReg->update();
					$pti = $objReg->getPti();
					$objEva = new Evaluator($evaluator);
					$email = $objEva->getEmail();
					$res_evaluator = $objEva->getByRelated('evaluator', 'id_evaluator', $evaluator, '0', '0');
					$userid = '';
					foreach ($res_evaluator->result() as $row){
						$userid = $row->user_id;
					}
					$this->load->helper('internet');
					//if(is_connected()){
						$this->load->library('email');
						$config['useragent'] = "CodeIgniter";
						$config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
						$config['protocol'] = 'smtp';
						$config['smtp_host'] = 'ssl://mail.dikti.go.id'; //change this
						$config['smtp_port'] = '465';
						$config['smtp_user'] = 'app@dikti.go.id';
						$config['smtp_pass'] = 'SecretApp2016!';
						$config['mailtype'] = 'html';
						$config['charset'] = 'iso-8859-1';
						$config['wordwrap'] = TRUE;
						$config['newline'] = "\r\n";
						$this->email->initialize($config);
						$this->email->from('subdit_ppt@dikti.go.id', 'PPPTS');
						$this->email->to($email);
						$this->email->subject('Proposal Evaluasi');
						$this->email->message('Anda telah dikirimi proposal penilaian PPPTS sebagai berikut: '.
								'Nama PT: '.$pti->getNmPti().', '.
								'Harap login di alamat: http://pppts.ristekdikti.go.id/backoffice , Terima Kasih. '.
								'*User: '.$userid.', Password: pppts2016. '.
								'(*) Untuk evaluator yang belum memiliki Account.');
						//$this->email->cc('arief_anang@yahoo.com');
						//$this->email->bcc('them@their-example.com');
						//$this->email->send();
					//}
					
					
						
					
				}
				redirect(base_url().'backoffice/kelolapenugasan/index');
			}else{
				$view = 'form_penugasan';
                                $this->db->select('*');
                                $this->db->from('jenis_evaluasi');
                                $result = $this->db->get();
				$jns_evaluasi[0] = '-Pilih-';
                                foreach($result->result() as $row){
                                        $jns_evaluasi[$row->id_jns_evaluasi] = $row->nama_evaluasi;
                                }
                                $data['jns_evaluasi'] = $jns_evaluasi;
				$registrasi = new Registrasi($idregistrasi);
				$data['idevaluator'] = $idevaluator;
				$data['evaluator'] = $evaluator;
				$data['type'] = $type;
				$data['tglkirim'] = $tgl_kirim;
				$data['tglexpire'] = $tgl_expire;
				$data['batch'] = $batch;
				$data['registrasi'] = $registrasi;
				$data['flagInsert'] = 'true';
				showNewBackEnd('backoffice/'.$view,$data,'index-1');
			}		
		}else{
			echo '<script>';
			echo 'alert("Validation Fail !");';
			echo 'window.history.back(1);';
			echo '</script>';
		}
		
	}
	
	public function sendMail()
	{
		$objEva = new Evaluator();
		$this->load->library('email');
		$res_evaluator = $objEva->get('0', '0');
		$userid = '';
		$config = array();
		$config['useragent'] = "CodeIgniter";
		$config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://mail.dikti.go.id'; //change this
		$config['smtp_port'] = '465';
		$config['smtp_user'] = 'app@dikti.go.id';
		$config['smtp_pass'] = 'SecretApp2016!';
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['newline'] = "\r\n";
		$this->email->initialize($config);
		
		foreach ($res_evaluator->result() as $row){
			echo 'Nama evaluator: '.$row->nm_evaluator.'</br>';
			echo 'User id: '.$row->user_id.'</br>';
			echo 'Email: '.$row->email.'</br>';
			$this->email->from('subdit_ppt@dikti.go.id', 'PPPTS');
			$this->email->to($row->email);
			//$this->email->cc('arief_anang@yahoo.com');
			//$this->email->bcc('them@their-example.com');
				
			$this->email->subject('Account Evaluator PPPTS');
			$this->email->message('Berikut ini kami kirimkan user account anda sebagai evaluator PPPTS: '.
					'Nama Evaluator: '.$row->nm_evaluator.', '.
					'User: '.$row->user_id.', Password: pppts2016. '
					);
							
			$this->email->send();
			echo 'Mail has been sent.</br>';
		}
		
			
		
	}
	
	
}
?>