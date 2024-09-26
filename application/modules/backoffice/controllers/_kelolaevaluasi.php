<?php
require_once ('icontroll.php');
require_once APPPATH . 'third_party/PHPExcel.php';
require_once APPPATH . 'third_party/PHPExcel/IOFactory.php';



/**
 * @author akil
 * @version 1.0
 * @created 26-Mar-2016 19:15:09
 */
class KelolaEvaluasi extends EL_Controller implements IControll
{
	private $objRegistrasi;

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
		$this->load->model('evaluasi');
		$this->load->model('nilaidetail');
		$this->load->model('evaluatorevaluasi');
		$this->load->model('evaluasiproses');
		$this->load->model('bobotnilai');
		$this->load->model('evaluasirekapitulasi');
		$this->load->model('rekapitulasi');
		$this->load->model('itemhibah');
		$this->load->model('barang');
		$this->load->model('gedung');
		$this->load->model('kategori');
		$this->load->model('subkategori');
	}

	function __destruct()
	{
	}



	public function add()
	{
		$view = 'form_entry_evaluasi';
		$id_reg = $this->uri->segment(4,0);
		$registrasi = new Registrasi($id_reg);
		$data['registrasi'] = $registrasi;
		$data['flagInsert'] = 'true';
		showBackEnd($view,$data);
	}

	public function edit()
	{
	}

	public function find()
	{
		if($this->sessionutility->validateAccess($this)){
			$view = 'list_rekapitulasi';
		
			$keyword = $this->input->post('keyword');
			$filter = $this->input->post('filter');
			$fdate = $this->input->post('tglawal');
			$ldate = $this->input->post('tglakhir');
			//echo $filter.','.$this->input->post('export');
			$uri_segment = '0';
			$segment = '0';
				
			if($keyword==''){//next page
				$keyword = str_replace('%20',' ',$this->uri->segment(5));
				if($filter != 'all'){//with date
					$filter = $this->uri->segment(4);
					$keyword = str_replace('%20',' ',$this->uri->segment(5));
					$fdate = $this->uri->segment(6);
					$ldate = $this->uri->segment(7);
					$uri_segment = '8';
					$segment = $this->uri->segment(8);
						
				}
			}elseif ($filter=='all') {
				if($fdate=='' && $ldate==''){
					$fdate = date("Y").'-01-01';
					$ldate = date("Y-m-d");
				}
			}
			$rekapitulasi = new Rekapitulasi();
			$rekapitulasi->setIdStatusRegistrasi('0');
			//$segment = $this->uri->segment(4,0);
			$per_page = 20; $total_row = 0;
			$result = '';
			//echo $filter;
			if($this->input->post('export')){
				//echo 'is export</br>';
				if ($filter=='nmpti'){
					$result = $rekapitulasi->getByRelated('pti', $filter, $keyword, $per_page, $segment);
				}elseif ($filter=='nama_penyelenggara'){
					$result = $rekapitulasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword, $per_page, $segment);
				}elseif ($filter=='id_registrasi'){
					$result = $rekapitulasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
				}elseif ($filter=='nama_status'){
					$rekapitulasi->setIdStatusRegistrasi('');
					$result = $rekapitulasi->getByRelated('status_registrasi', $filter, $keyword, $per_page, $segment);
					$total_row = $rekapitulasi->getByRelated('status_registrasi', $filter, $keyword);
				}elseif ($filter=='all'){
					$result = $rekapitulasi->get('0','0');
				}
			}else{
				//echo 'is record</br>';
				if ($filter=='nmpti'){
					$result = $rekapitulasi->getByRelated('pti', $filter, $keyword, $per_page, $segment);
					$total_row = $rekapitulasi->getByRelated('pti', $filter, $keyword);
				}elseif ($filter=='nama_penyelenggara'){
					$result = $rekapitulasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword, $per_page, $segment);
					$total_row = $rekapitulasi->getByRelated('tbl_badan_penyelenggara', $filter, $keyword);
				}elseif ($filter=='id_registrasi'){
					$result = $rekapitulasi->getByRelated('registrasi', $filter, $keyword, $per_page, $segment);
					$total_row = $rekapitulasi->getByRelated('registrasi', $filter, $keyword);
				}elseif ($filter=='nama_status'){
					$result = $rekapitulasi->getByRelated('status_registrasi', $filter, $keyword, $per_page, $segment);
					$total_row = $rekapitulasi->getByRelated('status_registrasi', $filter, $keyword);
				}elseif ($filter=='all'){
					$result = $rekapitulasi->get($per_page,$segment);
				}
			}
				
			$base_url = base_url().'backoffice/kelolaevaluasi/find/'.$filter.'/'.$keyword.'/';
			setPagingTemplate($base_url, 4, $total_row, $per_page);
			$data['rekapitulasi'] = $result;
			$data['total_row'] = $total_row;
			$data['selected_filter'] = $filter;
			if ($this->input->post('export')){
				$this->load->view('export_rekapitulasi',$data);
				//print_r($result);
			}else{
				showBackEnd($view,$data);
			}
		}else{
			echo '<script>';
			echo 'alert("Validation Fail !");';
			echo 'window.history.back(1);';
			echo '</script>';
		}
	}

	public function index()
	{
		if ($this->sessionutility->validateAccess ( $this )) {
			$view = 'list_rekapitulasi';
			$u_id = $this->session->userdata('userid');
			$user = new ModUsers();
			$id_eva = $user->getIdEvaluator();
			$evaluasi = new Rekapitulasi();
			$segment = $this->uri->segment(4,0);
			$per_page = 10;
			$result = '';
			$total_row = 0;
			
			$result = $evaluasi->get($per_page,$segment);
			$total_row = $evaluasi->get();			
			
			$base_url = base_url().'backoffice/kelolaevaluasi/index';
			setPagingTemplate($base_url, 4, $total_row, $per_page);
			$data['rekapitulasi'] = $result;
			$data['total_row'] = $total_row;
			showBackEnd($view,$data);
		} else {
			echo '<script>';
			echo 'alert("Validation Fail !");';
			echo 'window.history.back(1);';
			echo '</script>';
		}
	}
	
	public function indexEvaluator()
	{
		if ($this->sessionutility->validateAccess ( $this )) {
			$view = 'list_evaluasi';
			$u_id = $this->session->userdata('userid');
			$user = new ModUsers($u_id);
			$id_eva = $user->getIdEvaluator();
			
			$evaluasi = new Evaluasi();
			$segment = $this->uri->segment(4,0);
			$per_page = 10;
			$result = '';
			$total_row = 0;
			if($id_eva != ''){
				$result = $evaluasi->getByRelated('evaluator_evaluasi','id_evaluator', $id_eva, $per_page, $segment);
				$total_row = $evaluasi->getByRelated('evaluator_evaluasi','id_evaluator', $id_eva);
			}
			//print_r($result);
			
			$base_url = base_url().'backoffice/kelolaevaluasi/indexevaluator/';
			setPagingTemplate($base_url, 4, $total_row, $per_page);
			$data['evaluasi'] = $result;
			$data['total_row'] = $total_row;
			showBackEnd($view,$data);
		} else {
			echo '<script>';
			echo 'alert("Validation Fail !");';
			echo 'window.history.back(1);';
			echo '</script>';
		}
	}

	public function remove()
	{
	}
	
	public function save()
	{
		if ($this->sessionutility->validateAccess ( $this )) {
			if ($this->input->post ( 'save' )) {
	
				$thn = date ( "Y" );
				$bln = date ( "M" );
				$file_path_excel = '/home/usrlembaga/frontend/frontend/web/dokumen/hasil_evaluasi/' . $thn . '/' . $bln . '/';					
						
				if (! is_dir ( $file_path_excel )) {
					mkdir ( $file_path_excel, 0777, true );						
				}
				$config ['upload_path'] = $file_path_excel;
				$config ['allowed_types'] = 'xls|xlsx';
				$config ['max_size'] = '2000';
					
				$this->load->library ( 'upload', $config );
				
				$idregistrasi = $this->input->post('idregistrasi');
				$this->objRegistrasi = new Registrasi($idregistrasi);
				
				if (! $this->upload->do_upload ()) { // upload excell penilaian
					$error = trim ( strip_tags ( $this->upload->display_errors () ) );
					echo '<script>';
					echo 'alert("Error File Excell Penilaian. ' . $error . '");';
					echo 'window.history.back(1);';
					echo '</script>';
				} else {
					echo 'file excel uploaded..</br>';
					$data = $this->upload->data();
					$this->uploadInstrument($data);										
				}
				$this->rekapitulasi ();				
			}
			
				redirect ( base_url () . 'backoffice/kelolaevaluasi/indexevaluator/' );
			
		} else {
			echo '<script>';
			echo 'alert("Validation Fail !");';
			echo 'window.history.back(1);';
			echo '</script>';
		}
	}
	
	private function uploadInstrument($data)
	{
		$evaluasi = new Evaluasi();
		$evaluasi_evaluator = new EvaluatorEvaluasi();
		$evaluasi_proses = new EvaluasiProses();
		
		$iduser = strtoupper ( $this->session->userdata ( 'userid' ) );
		$user = new ModUsers($iduser);
						
		$fullPath = $data ['full_path'];
		$file_name = $data ['file_name'];
		$arr_file = explode ( '_', $file_name );
		
		echo 'processing instrument </br>';
		
		if ($this->objRegistrasi->getIdRegistrasi() == trim($arr_file [0])) {
			$skor = 0;
			$legalitas = '';
			$dosen_tetap = '';
			$result = null;
			
			//echo 'instrument S1</br>';
			$result = $this->readInstrument($fullPath);
			
			//print_r($result);
			foreach ($result as $key => $value) {
				if($key=='skor'){
					//echo $key.': '.$value.'</br>';
					$skor = $value;
				
				}elseif($key=='nilaidetail'){
					$nilaidetail = $value;						
				}
			}
			$range = '';
			// rule skor
				
			if($skor<=300){
				$range = 'yellow';
			}else{				
				$range = 'green';				
			}
			$keterangan = '-';
			
			echo 'range:'.$range.'</br>';
			
			$evaluasi->setTglEvaluasi( date ( "Y-m-d" ) );
			$evaluasi->setSkor( $skor );
			$evaluasi->setRange($range);
			$evaluasi->setKeterangan( htmlentities ( strip_quotes ( $keterangan ) ) );			
			$evaluasi->setLastUpdate( date ( "Y-m-d" ));
			$evaluasi->setIdStatusRegistrasi( '' );
			$evaluasi->setFilePath( $fullPath );
			
			echo 'skor: '.$skor.'</br>';
			if ($skor != '') {
				//$evaluasi->m_ModNilaiDetail = $nilaidetail;
				$objNilai = new NilaiDetail('','');
				$evaluator_evaluasi = new EvaluatorEvaluasi();
				$proses = new Proses();
				$rekapitulasi = new Rekapitulasi();
				$evaluasi_rekapitulasi = new EvaluasiRekapitulasi();
				
				$rekapitulasi->getBy('id_registrasi', $this->objRegistrasi->getIdRegistrasi());
				$evaluasi_rekapitulasi->setIdRekapitulasi($rekapitulasi->getIdRekapitulasi());
				$proses->setIdEvaluator($user->getIdEvaluator());
				//$result_proses = $proses->getByRelated('registrasi', 'id_registrasi', 
						//$this->objRegistrasi->getIdRegistrasi(),'0','0');
				$result_proses = $proses->getRecordProcess($this->objRegistrasi->getIdRegistrasi());
				$id_proses = '';
				if($result_proses->num_rows()>0){
					foreach ($result_proses->result() as $row){
						$id_proses = $row->id_proses;
					}
				}else{
					echo ('Tidak ada penugasan!'.'</br>');
				}
				// check				
				$temp_no_evaluasi = '';
				if ($evaluasi->isExist ($id_proses)) {
					echo 'exist..'.'</br>';
					$temp_no_evaluasi = $evaluasi->getIdEvaluasi();
					$objNilai->setIdEvaluasi($temp_no_evaluasi);
					$evaluator_evaluasi->setIdEvaluasi($temp_no_evaluasi);
					$evaluasi_proses->setIdEvaluasi($temp_no_evaluasi);
					
					
					$evaluasi->delete ();					
					$objNilai->delete ();
					$evaluator_evaluasi->delete();
					$evaluasi_proses->delete();
					$rekapitulasi->delete();
					$evaluasi_rekapitulasi->delete();
					echo 'evaluasi, rekapitulasi & nilai detail deleted</br>';
					$evaluasi->setIdEvaluasi($temp_no_evaluasi);
				}else{
					$evaluasi->setIdEvaluasi($evaluasi->generateId($user->getIdEvaluator()));
				}
				// start transaction
				//$this->db->trans_begin ();
				echo 'no evaluasi:'.$evaluasi->getIdEvaluasi().'</br>';
				
				if ($evaluasi->insert ()) {
					echo 'evaluasi inserted..</br>';
	
					foreach ( $nilaidetail as $nilai ) {
	
						$nilai->setIdEvaluasi($evaluasi->getIdEvaluasi());
	
						if($nilai->insert ()){
							echo 'nilai detail inserted..</br>';
						}
					}
					
					//insert evaluator					
					$evaluator_evaluasi->setIdEvaluasi($evaluasi->getIdEvaluasi());
					$evaluator_evaluasi->setIdEvaluator($user->getIdEvaluator());
					$evaluator_evaluasi->insert();
					echo 'evaluator evaluasi inserted..</br>';
					
					//insert evaluasi proses
					$evaluasi_proses->setIdProses($id_proses);
					$evaluasi_proses->setIdEvaluasi($evaluasi->getIdEvaluasi());
					$evaluasi_proses->insert();
					echo 'evaluasi proses inserted..</br>';
					// update status proses
					$proses->getBy('id_proses',$id_proses);
					$proses->setIdStatusProses('3');//selesai
					$proses->update ();
					echo 'proces status updated..</br>';
						
				}
				
				/*if ($this->db->trans_status () === FALSE) {
					$this->db->trans_rollback ();
				} else {
					// commit transaction
					$this->db->trans_commit ();
					echo 'all transaction commited..</br>';
					$state = TRUE;
				}*/
			}
				
		}else {
			//$fullPath = $this->uploadFileInfo ['full_path'];
			// chmod($fullPath, 0777);
			unlink ( $fullPath );
			die();
			echo '<script type="text/javascript">';
			echo 'alert("Dokumen yang anda upload tidak sesuai dengan prodi yang dievaluasi!");';
			echo '</script>';
	
			echo '<script type="text/javascript">';
			echo 'window.history.back(1)';
			echo '</script>';
		}
		//return $state;
	}

	private function readInstrument($path){
		$file_path = $path;
		if (!file_exists($file_path)) {
			exit("File unavailable!");
		}
		$objPHPExcel = PHPExcel_IOFactory::load($file_path);;
		$objPHPExcel->setActiveSheetIndex(1);
		//echo 'Reading sheet '.$objPHPExcel->getActiveSheetIndex().'</br>';
		$objbobot = new BobotNilai();
		$nilaidetail = new ArrayObject ();
		$skor = $objPHPExcel->getActiveSheet()->getCell('J'.'47')->getCalculatedValue();
		//$keterangan = $objPHPExcel->getActiveSheet()->getCell('D'.'67')->getCalculatedValue();
		//$legalitas = $objPHPExcel->getActiveSheet()->getCell('D'.'67')->getCalculatedValue();
		//$dosen_tetap = $objPHPExcel->getActiveSheet()->getCell('D'.'68')->getCalculatedValue();
		//$return_value = array('skor'=>$skor);
	
		for($i=15; $i<=46; $i++){
			$objNilai = new NilaiDetail ( '', '' );
			echo 'Reading items..';
			$idbobot = 'P';
			$butir = str_replace('.', '',$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
			if(strlen($butir)==3 && is_numeric($butir)){
				$idaspek = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
				$aspek = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();				
				$bobot = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
				$nilai = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
				$komentar = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
				if (!is_numeric($nilai)){
					exit('<h1>Isi instrument tidak valid!</h1>');
				}
				$objbobot->setIdBobot($idbobot.$butir);
				$objbobot->setIdAspek($idaspek);
				$objbobot->setNoAspek($butir);
				$objbobot->setAspek('');
				$objbobot->setKeteranganAspek($aspek);
				$objbobot->setBobot($bobot);
				//$objbobot->setJnsUsulan('P02');
				//$objbobot->setPeriode('20152');
				//$objbobot->insert();
				echo 'Butir: '.$butir.' inserted.</br>';
		
				//$objNilai->setNoEvaluasi ($noevaluasi);
				$objNilai->setNilai ( $nilai );
				$objNilai->setKomentar ( htmlentities ( strip_quotes ( $komentar ) ) );
				$objNilai->setIdBobot ( $idbobot.$butir );
				$nilaidetail->append ( $objNilai );
			}
		}
		$return_value = array('skor'=>$skor, 'nilaidetail'=> $nilaidetail );
		return $return_value;
	}
	
	private function rekapitulasi()
	{
		echo 'processing rekapitulasi</br>';
		$id_registrasi = $this->objRegistrasi->getIdRegistrasi();
		$evaluasi = new Evaluasi();
		$result_evaluasi = $evaluasi->getByRelated('registrasi', 'id_registrasi', $id_registrasi, '0','0');
		if($result_evaluasi->num_rows()=='2'){//jika 2, proses rekapitulasi
			$status_konsolidasi = false;
			$hasil_evaluasi = '';
			$skor = 0;
			$keterangan = '';
			$total_skor = 0;
			//check konsolidasi
			echo 'check konsolidasi</br>';
			foreach ($result_evaluasi->result()  as $eva){
				
				if($skor != 0){
					
					if($skor > $eva->skor){
						$range = $skor - $eva->skor;
						if($range >= 70){
							$status_konsolidasi = true;
						}
					}elseif ($skor < $eva->skor){
						$range = $eva->skor - $skor;
						if($range >= 70){
							$status_konsolidasi = true;
						}
					}
				}else{
					$skor = $eva->skor;
				}
				$total_skor = $total_skor + $eva->skor;
			}
			
			if (!$status_konsolidasi){//tidak ada konsolidasi
				echo 'no konsolidasi</br>';
				$rerata = $total_skor / 2;
				echo 'skor rerata: '.$rerata.'</br>';
				if($rerata>=250){
					$hasil_evaluasi = '5';
				}else{
					$hasil_evaluasi = '6';
				}
				//simpan ke rekapitulasi
				$rekapitulasi = new Rekapitulasi();
				$rekapitulasi->setIdRegistrasi($id_registrasi);
				$rekapitulasi->setIdStatusRegistrasi($hasil_evaluasi);
				$rekapitulasi->setNilaiTotal($rerata);
				$rekapitulasi->setKeterangan($keterangan);
				$rekapitulasi->setPublish('no');
				$rekapitulasi->setTglRekap(date('Y-m-d'));
				$rekapitulasi->insert();
				
				//simpan evaluasi rekapitulasi
				foreach ($result_evaluasi->result()  as $eva){
					$evaluasi_rekapitulasi = new EvaluasiRekapitulasi();
					$evaluasi_rekapitulasi->setIdEvaluasi($eva->id_evaluasi);
					$evaluasi_rekapitulasi->setIdRekapitulasi($rekapitulasi->getIdRekapitulasi());
					$evaluasi_rekapitulasi->insert();
				}
				
				//update status proses
				foreach ($result_evaluasi->result()  as $row){
					$eva = new Evaluasi($row->id_evaluasi);
					$pro = $eva->getProses();
					$pro->setIdStatusProses('3');//status konsolidasi
					$pro->update();
				}
			}else{//harus konsolidasi
				echo 'there is konsolidasi</br>';
				foreach ($result_evaluasi->result()  as $row){
					$eva = new Evaluasi($row->id_evaluasi);
					$pro = $eva->getProses();
					$pro->setIdStatusProses('4');//status konsolidasi
					$pro->update();
				}
			}
		}
	}
	
	public function view($idregistrasi) {
		if ($this->sessionutility->validateAccess ( $this )) {
			$view = 'view_evaluasi';
			//$rekapitulasi = new Rekapitulasi();
			//$rekapitulasi->getBy('id_registrasi', $idregistrasi);
			//$result = $rekapitulasi->getEvaluasi();
			$evaluasi = new Evaluasi();
			$result = $evaluasi->getByRelated('registrasi', 'id_registrasi', $idregistrasi,'0','0');
			
			//print_r($result);
			$data['evaluasi'] = $result;
			showBackEnd($view, $data);
		} else {
			echo '<script>';
			echo 'alert("Validation Fail !");';
			echo 'window.history.back(1);';
			echo '</script>';
		}
	}
	
	public function dataBarang($id_reg) {
		$view = 'view_barang';
		$registrasi = new Registrasi($id_reg);
		$data['registrasi'] = $registrasi;
		
		showBackEnd($view, $data);
	}
	
	public function printDataBarang($id_reg){
		$view = 'view_barang';
		$registrasi = new Registrasi($id_reg);
		$data['registrasi'] = $registrasi;
		$this->load->view($view, $data);
	}
	
}
?>