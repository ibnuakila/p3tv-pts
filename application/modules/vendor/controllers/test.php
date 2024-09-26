<?php
/**
 * @author akil
 * @version 1.0
 * @created 14-Mar-2016 11:12:35
 */
class Test extends EL_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('ModUsers');
		$this->load->library('sessionutility');

		 
	}

	function __destruct()
	{
	}
	
	public function index()
	{
		$this->load->model('evaluasi');
		$evaluasi = new Evaluasi();
		echo $evaluasi->generateId('1');
	}
	
	public function testRead()
	{
		/*$path = 'C:/xampp/htdocs/pppts/assets/documents/template_penilaian.xlsx';
			$result = $this->readInstrument($path);
			print_r($result);*/
		$evaluasi = new Evaluasi();
		$result_evaluasi = $evaluasi->getByRelated('registrasi', 'id_registrasi', '1', '0','0');
		//print_r($result_evaluasi);
		foreach ($result_evaluasi->result()  as $row){
			echo $row->skor.'</br>';
		}
	}
	
	
}