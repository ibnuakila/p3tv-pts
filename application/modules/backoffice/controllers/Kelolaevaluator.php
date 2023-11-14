<?php
require_once ('Icontroll.php');



/**
 * @author user
 * @version 1.0
 * @created 26-Aug-2014 2:07:35 PM
 */
class KelolaEvaluator extends MX_Controller implements IControll
{

	function __construct()
	{
            parent::__construct();
            $this->load->library('sessionutility');
            if(!$this->sessionutility->validateSession()){
                redirect(base_url().'backoffice/form_login');
            }
            $this->load->model('evaluator');
	}

	function __destruct()
	{
	}



	public function add()
	{
            if($this->sessionutility->validateAccess($this)){
                $page = 'officer/form_evaluator';
                
                $data['flaginsert'] = 'true';
                
                show_admin($page,$data);
            }else{
                echo '<script>';
                echo 'alert("Validation Fail !");';
                echo '</script>';
            }
	}

	/**
	 * 
	 * @param id
	 */
	public function edit()
	{
            if($this->sessionutility->validateAccess($this)){
                $page = 'officer/form_evaluator';
                $evaluator = new ModEvaluator($id);
                
                $data['flaginsert'] = 'false';
                $data['evaluator'] = $evaluator;
                show_admin($page,$data);
            }else{
                echo '<script>';
                echo 'alert("Validation Fail !");';
                echo '</script>';
            }
	}

	public function find()
	{
            if($this->sessionutility->validateAccess($this)){
                $view = 'officer/list_evaluator';
                $keyword = $this->input->post('search');
                $evaluator = new ModEvaluator('');
                $result = $evaluator->getObjectFiltered('nama', $keyword, '', '');
                $base_url = base_url().'officer/evaluator/index';
                $uri_segment = '4';
                $segment = $this->uri->segment(4);
                $total_row = ($result->num_rows());                
                setPagingTemplate($base_url,$uri_segment,$total_row);
                $data['segment'] = $segment;
                $data['evaluator'] = $result;
                show_admin($view,$data);
            }else{
                echo '<script>';
                echo 'alert("Validation Fail !");';
                echo '</script>';
            }
	}

	public function index()
	{
            if($this->sessionutility->validateAccess($this)){
                
                $view = 'officer/list_evaluator';
                $evaluator = new ModEvaluator('');
                $segment = $this->uri->segment(4);
                $result = $evaluator->getObjectList('10', $segment);
                $base_url = base_url().'officer/evaluator/index';
                $uri_segment = '4';
                
                $total_row = $evaluator->getObjectList('', '')->num_rows();                
                setPagingTemplate($base_url,$uri_segment,$total_row);
                $data['segment'] = $segment;
                $data['evaluator'] = $result;
                show_admin($view,$data);
            }else{
                echo '<script>';
                echo 'alert("Validation Fail !");';
                echo '</script>';
            }
	}

	/**
	 * 
	 * @param id
	 */
	public function remove()
	{
            if($this->sessionutility->validateAccess($this)){
                
            }else{
                echo '<script>';
                echo 'alert("Validation Fail !");';
                echo '</script>';
            }
	}

	/**
	 * 
	 * @param flagInsert
	 */
	public function save()
	{
            if($this->sessionutility->validateAccess($this) && $this->sessionutility->isAdministrator()){
                if($this->input->post('save')){
                    $evaluator = new ModEvaluator();
                    $this->load->model('ModUsers');
                    $this->load->model('ModUserType');
                    $this->load->model('ModUnitKerja');
                        $evaluator->setKdEvaluator($this->input->post('kdevaluator'));
                        $evaluator->setNmEvaluator($this->input->post('nmevaluator'));
                        $evaluator->setInstitusi($this->input->post('instansi'));
                        $evaluator->setBidang($this->input->post('bidang'));
                        $evaluator->setEmail($this->input->post('email'));
                        $evaluator->setTelepon($this->input->post('telepon'));
                        //$this->ModEvaluator->setType($this->input->post('type'));
                        /*if($this->input->post('ischange')=='true'){
                            $this->ModEvaluator->setPassword($this->input->post('password'));
                        }*/
                        $user = new ModUsers('');
                        $user->setUserId($evaluator->getKdEvaluator());
                        $user->setUserName($evaluator->getNmEvaluator());
                        $user->setEmail($evaluator->getEmail());
                        $user->setPassword('silemkerma2015');
                        $user->m_ModUserType = new ModUserType(3);
                        $user->m_ModUnitKerja = new ModUnitKerja(3);
                        
                        if($flaginsert=='true'){
                            $evaluator->insert();
                            $user->insert();
                        }else{
                            $evaluator->update();
                        }
                        
                        
                        
                        
                        
                        //redirect(base_url().'evapro/evaluator');
                }
                        redirect(base_url().'officer/evaluator');
                
            }else{
                echo '<script>';
                echo 'alert("Validation Fail !");';
                echo '</script>';
            }
	}

	public function autoComplete()
	{
            if($this->sessionutility->validateSession()){
                $keyword = strtolower($this->input->post('term'));
                $evaluator = new Evaluator();
                

                $result = $evaluator->getByRelated('evaluator','nm_evaluator', $keyword, '0', '0');
                $data['response'] = 'false';
                if(($result->num_rows()) > 0){
                        $data['response'] = 'true'; //Set response
                        $data['message'] = array(); //Create array
                        foreach($result->result() as $row){
                                $data['message'][] = array('label'=>$row->nm_evaluator,'value'=>$row->nm_evaluator,
                                    'kode'=>$row->id_evaluator);	
                        }                        
                }
                echo json_encode($data);
            }else{
                echo '<script>';
                echo 'alert("Validation Fail !");';
                echo '</script>';
            }
	}
        
        function generateId($stringnama)
	{
		$len = strlen($stringnama);
                $stringnama = str_replace("%20", " ", $stringnama);
		if($len!=3)
		{
			$tempid = '';
			$pos = strpos($stringnama,' ');
                        //$pos2 = stristr($stringnama, $needle, $before_needle)
                        $pos2 = strpos($stringnama,' ',$pos + 1);
			$x1 = 0;
			$x2 = 2;
			$x3 = 4;
                        //echo $pos.'-'.$pos2;
			if($pos != false)
			{
                            $x2 = $pos + 1;
                            
                            if($pos2 != false)
                            {
                                $x3 = $pos2 + 1;
                            }else
                            {
                                $x3 = $pos + 3;
                            }			
				
			}
					
			$tempid = substr($stringnama,$x1,1).substr($stringnama,$x2,1).substr($stringnama,$x3,1);
				
                        $obj = new ModEvaluator($tempid);
			
			if($obj->getKdEvaluator()== '')
			{
				$x1 = 0;
				$x2 = 2;
				$x3 ++;
				if($pos != false)
				{
                                    $x2 = $pos + 1;
                            
                                    if($pos2 != false)
                                    {
                                        $x3 = $pos2 + 2;
                                    }else
                                    {
                                        $x3 = $pos + 3;
                                    }
					
				}
				
				$tempid = substr($stringnama,$x1,1).substr($stringnama,$x2,1).substr($stringnama,$x3,1);
				
			}
			echo $tempid;
		}else{
			echo $stringnama;
		}	
			
	}
}
?>