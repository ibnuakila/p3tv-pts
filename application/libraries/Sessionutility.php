<?php
//require_once ('..\..\..\newevapro\application\models\modusers.php');

//namespace Library;


/**
 * @author user
 * @version 1.0
 * @created 14-Sep-2014 10:55:11 AM
 */
class SessionUtility
{

	//public $m_ModUsers;
        var $CI;
        var $isSecure=FALSE;
	function __construct()
	{
            $this->CI =& get_instance();		
            // Load the Sessions class
            $this->CI->load->library('session');
            $this->CI->load->model('Modusers');
            $this->CI->load->model('ModuserAccess');
            $this->CI->load->model('Modsysteminformation');
            $this->CI->load->model('Modsystemmodule');
            $this->CI->load->model('Modsubsystemmodule');
            $this->CI->load->model('Modunitkerja');
            $this->CI->load->model('Moduseractivity');
	}

	function __destruct()
	{
	}

        public function validateSession()
        {
            $acc = FALSE;
            $status = strtoupper($this->CI->session->userdata('is_loged_in'));
            if($status==TRUE){
                $acc = TRUE;
            }
            return $acc;
        }
        
        public function validateAccess($module)
        {
            $userid = strtoupper($this->CI->session->userdata('userid'));
            $acc = FALSE;
            $user = new ModUsers($userid);
            if($user->getUserName()!=''){
                $class = get_class($module);
                $access = new ModSubSystemModule('');
                $access->setUserId($user->getUserId());
                $subsysmodule = $access->getObjectList('', '');
                $uri = explode('/', $this->CI->uri->uri_string());            

                if(($subsysmodule->num_rows())>0){
                    foreach ($subsysmodule->result() as $value) {
                        $sub_system_module = new ModSubSystemModule($value->sub_module_id);
                        $systemodule = new ModSystemModule($sub_system_module->getModuleId());
                        if($systemodule->getModuleName() == $class){
                            if(count($uri)<=2){
                                if($sub_system_module->getSubModuleName()=='index'){
                                    $acc = TRUE;
                                    break;
                                }
                            }elseif(strtolower($sub_system_module->getSubModuleName()) == strtolower($uri[2])){
                                $acc = TRUE;
                                //$accessType = new ModAccessType($value->getAccessTypeId());
                                if($sub_system_module->getAccessTypeId() == '1' || 
                                        $sub_system_module->getAccessTypeId() == '3' ||
                                        $sub_system_module->getAccessTypeId() == '4'){

                                    $userActivity = new ModUserActivity('');
                                    $userActivity->m_ModUsers = new ModUsers($userid);
                                    $qrystring = $this->CI->uri->uri_string();
                                    $userActivity->setModuleAccessed($qrystring);
                                    $userActivity->settimeAccessed(date('c'));
                                    $userActivity->insert();
                                }
                                break;
                            }
                        }                
                    }
                }
            }
            if($this->isSecure){
                return $acc;
            }else{
                return TRUE;
            }
        }       

	public function isAdministrator()
	{
            $userid = strtoupper($this->CI->session->userdata('userid'));
            $acc = FALSE;
            $user = new ModUsers($userid);
            $userType = new ModUserType($user->getUserType());
            if($userType->getTypeName() == 'Administrator'){
                $acc = TRUE;
            }
            return $acc;
	}

	public function isEndUser()
	{
            $userid = strtoupper($this->CI->session->userdata('userid'));
            $acc = FALSE;
            $user = new ModUsers($userid);
            $userType = new ModUserType($user->getUserType());
            if($userType->getTypeName() == 'End User'){
                $acc = TRUE;
            }
            return $acc;
	}

	public function isSupervisor()
	{
            $userid = strtoupper($this->CI->session->userdata('userid'));
            $acc = FALSE;
            $user = new ModUsers($userid);
            $userType = new ModUserType($user->getUserType());
            if($userType->getTypeName() == 'Supervisor'){
                $acc = TRUE;
            }
            return $acc;
	}
        
        public function isLogedIn()
        {
            
        }
       
}
?>