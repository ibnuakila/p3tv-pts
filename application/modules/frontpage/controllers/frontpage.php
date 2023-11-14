<?php




/**
 * @author akil
 * @version 1.0
 * @created 13-Mar-2016 20:19:38
 */
class FrontPage extends EL_Controller
{

	function __construct()
	{
	}

	function __destruct()
	{
	}



	public function index()
	{
		//$this->load->view('welcome_message');
		showFrontpage('welcome_message');
	}
	
	public function registration()
	{
		showFrontpage('registrasi');
	}

}
?>