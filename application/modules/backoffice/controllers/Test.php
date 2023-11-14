<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * @author akil
 * @version 1.0
 * @created 14-Mar-2016 11:12:35
 */
class Test extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Modusers');
		$this->load->library('sessionutility');

		 
	}

	function __destruct()
	{
	}
	
	public function index()
	{
		$this->load->model('evaluasi');
		$evaluasi = new Evaluasi();
		//echo $evaluasi->generateId('1');
                echo phpinfo();
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
	
	public function testItem()
	{
		$this->load->model('itemhibah');
		$itemh = new ItemHibah();
		$arr = array('id_item' => '01080103b', 
				'id_registrasi' => '170610110403');
		if($itemh->getByArray($arr)){
			echo 'ongkir = '. $itemh->getOngkir();
		}
	}
        
        public function indexregistrasi()
        {
            $this->load->view('test');
        }
        
        public function getStatePenyelenggara()
        {
            $token = md5('service@silem');
            $username = 'evapro'; $password = 'service@silem';
            //The JSON data.
            //$this->inquerySecurityKey() ;
            echo 'key: '.$token.'</br>';
            $penyelenggara_id = 'Y15025';
            $url = 'http://silemkerma.ristekdikti.go.id/evapro/evaservice/getstatuspenyelenggara/'.$token.'/'.$penyelenggara_id;
            //Initiate cURL.
            $ch = curl_init($url);
            
            //Encode the array into JSON.
            //$jsonDataEncoded = json_encode($data);
            //echo $jsonDataEncoded;
            //Tell cURL that we want to send a POST request.
            curl_setopt($ch, CURLOPT_POST, 1);

            //Attach our encoded JSON string to the POST fields.
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('token' => $token, 'penyelenggara_id' => $penyelenggara_id));

            //Set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
            //set the return of the transfer as string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // Optional, delete this line if your API is open
            curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
            //Execute the request
            $result = curl_exec($ch);
            echo $result;
            //return json_decode($result);
        }
        
        public function getBase64Encode()
        {
            $consumer_key = 'MxtDfHAoDGwTMg96kGpSLg9C4fIa';
            $consumer_secret = 'eaSOaz9hleXT2ATxDlu_fXgEhssa';
            $encoded = base64_encode($consumer_key.':'.$consumer_secret);
            echo $encoded;
        }
        
        public function testApiPdDikti()
        {
            //$consumer_key = 'MxtDfHAoDGwTMg96kGpSLg9C4fIa';//'u9PZ1eED9cjkY_OHvpnAkDDK9_8a';
            //$consumer_secret = 'eaSOaz9hleXT2ATxDlu_fXgEhssa';//'YQ5aCZFnDHYHGFgtAitqS2LSXqQa';
            $access_token = $this->getToken();//'ae8c41a6-f7b1-34e7-ab79-c6459d65e183';
            //$encoded_access = base64_encode($consumer_key.':'.$consumer_secret);
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.kemdikbud.go.id:8243/pddikti/1.2/pt/212027/prodi',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POST => true, 
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$access_token,
                    'Accept: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $data = json_decode($response, true);
            //var_dump($data);
            $idx = 0;
            foreach ($data as $array){
                echo $array['kode'].' | ';
                echo $array['nama'].' | ';
                echo $array['bidang']['nama'].' | ';
                echo $array['status'].' | ';
                echo $array['jenjang_didik']['nama'].' | ';
                echo $array['tgl_berdiri'].' | ';
                echo $array['sk_selenggara'].' | ';
                echo $array['tgl_sk_selenggara'].' | ';
                echo $array['sks_lulus'];
                /*foreach ($array['jurusan'] as $jurusan) {
                    echo $jurusan['id'];
                }*/
                echo '</br>';
                $idx++;
            }
        }
        
        public function getToken(){
            $consumer_key = 'MxtDfHAoDGwTMg96kGpSLg9C4fIa';//'u9PZ1eED9cjkY_OHvpnAkDDK9_8a';
            $consumer_secret = 'eaSOaz9hleXT2ATxDlu_fXgEhssa';//'YQ5aCZFnDHYHGFgtAitqS2LSXqQa';
            
            $encoded_access = base64_encode($consumer_key.':'.$consumer_secret);
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.kemdikbud.go.id:8243/token',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POST => true, 
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic '.$encoded_access,
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $response = curl_exec($curl);
            $data = json_decode($response, true);
            return $data['access_token'];
        }
        
        public function getPtAkreditasi(){
            $access_token = '0503f830-1b72-3e3c-8670-6202b9a611a4';
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.kemdikbud.go.id:8243/pddikti/1.2/pt/044163/akreditasi',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POST => false, 
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$access_token,
                    'Accept: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $data = json_decode($response, true);
            var_dump($data);
        }

        public function getprodi()
        {
            $access_token = 'QURGQjM5M0QtMTJGMC00RjQ3LTkwNDQtOTQyRkY4NUY2NTUy'; //'RUNFQUUwNUUtMDlFNS00RkVELTkyRUYtOThEMTg5NDE5NzU5';
            $url = 'https://api-frontend.kemdikbud.go.id/detail_prodi/'.$access_token.'/undefined';
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POST => false, 
            //CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                    //'Authorization: Bearer '.$access_token,
                    'Accept: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $data = json_decode($response, true);
            var_dump($data);
        }
        
        public function getPtProdi()
        {
            $access_token = 'QkFCQTUzNUItMzNBQS00RUUyLTlEMUItQUYwNzcyNTlERUU3'; //'RUNFQUUwNUUtMDlFNS00RkVELTkyRUYtOThEMTg5NDE5NzU5';
            $url = 'https://api-frontend.kemdikbud.go.id/v2/detail_pt_prodi/'.$access_token;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POST => false, 
            //CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                    //'Authorization: Bearer '.$access_token,
                    'Accept: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $data = json_decode($response, true);
            //var_dump($data);
            //echo '<hr>';
            
            for($i=0;$i<count($data);$i++){
                print_r($data[$i]);
                echo '<hr>';
            }
        }
        
        public function getByNamaPt()
        {
            //$access_token = 'Q0U4QzYyMDEtRDEzMi00NkQyLTg1QzgtMjM1MTI2NEVFRDMz'; //'RUNFQUUwNUUtMDlFNS00RkVELTkyRUYtOThEMTg5NDE5NzU5';
            $nama_pt = '114096';
            $url = 'https://api-frontend.kemdikbud.go.id/hit/'.$nama_pt;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POST => false, 
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                    //'Authorization: Bearer '.$access_token,
                    'Accept: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $data = json_decode($response, true);
            var_dump($data);
            echo '<hr>';
            echo 'Nama PT: '.($data['pt'][0]['text']).'</br>';
            echo 'Link: '.($data['pt'][0]['website-link']).'</br>';
            $temp_weblink = $data['pt'][0]['website-link'];
            $arr_weblink = explode('/', $temp_weblink);
            print_r($arr_weblink);
            echo '</br>';
            $website_link = $arr_weblink[2];
            echo 'Website-link: '.$website_link;
            /*foreach ($data as $arr){
                echo ($arr[0]['website-link']).'</br>';
            }*/
        }

        public function testid(){
            $thn = date('y');
            $bln = date('m');
            $tgl = date('d');
            $time = date('s');
            $tempno = $tgl . $bln . $thn;
            $autono = mt_rand(1, 99);
            echo 'id: '.$tempno.$time.$autono;
        }
        
        public function testdownload()
        {
            $this->load->model('dokumenregistrasi');
            $this->load->helper('download');
            
            $dokumen_registrasi = new DokumenRegistrasi();
            $res_dok_reg = $dokumen_registrasi->getByRelated('registrasi', 'id_registrasi', '191120143718', '0', '0');
            if($res_dok_reg->num_rows()>0){
                $row = $res_dok_reg->row();
                $filepath = $row->filepath;
                $base_path = '/home/pppts/frontends/frontend/web/'.$filepath;
                if(is_file($base_path)){
                $data = file_get_contents($base_path);
                force_download('dokumen.pdf', $data);
                }else{
                    echo 'File not found!';
                }
            }
        }
        
        public function readExcel()
        {
            
            $inputFileName = realpath(APPPATH . '../assets/documents/example1.xlsx');

            $inputFileType = IOFactory::identify($inputFileName);
            //$helper->log('File ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' has been identified as an ' . $inputFileType . ' file');

            //$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory with the identified reader type');
            $reader = IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($inputFileName);
            
            //$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            //var_dump($sheetData);
            for($i=2; $i<=8; $i++){
                echo $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue().' | '.
                $spreadsheet->getActiveSheet()->getCell('B'.$i)->getCalculatedValue().'</br>';
            }
            
        }
	
}