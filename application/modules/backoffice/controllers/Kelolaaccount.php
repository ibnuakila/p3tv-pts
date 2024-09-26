<?php
require_once ('Icontroll.php');





/**
 * @author akil
 * @version 1.0
 * @created 11-Apr-2016 11:54:23
 */
class KelolaAccount extends MX_Controller implements IControll
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('sessionutility');
		if (!$this->sessionutility->validateSession()){
			redirect(base_url().'backoffice/');
		}
		$this->load->model('account');
	}

	function __destruct()
	{
	}



	public function add()
	{
	}

	public function edit()
	{
	}

	public function find()
	{
	}

	public function index()
	{
		$view = 'list_account';
		
		$registrasi = new Account();
		$segment = $this->uri->segment(4,0);
		$per_page = 10;
		$result = $registrasi->get($per_page,$segment);
		$total_row = $registrasi->get();
		$base_url = base_url().'backoffice/kelolaaccount/index';
		setPagingTemplate($base_url, 4, $total_row, $per_page);
		$data['account'] = $result;
		$data['total_row'] = $total_row;
		showBackEnd($view,$data);
	}

	public function remove()
	{
	}

	public function save()
	{
	}

	public function detail($id)
	{
		$view = 'detail_account';
		$registrasi = new Account($id);
		$data['account'] = $registrasi;
		showBackEnd($view,$data);
	}

}
?>