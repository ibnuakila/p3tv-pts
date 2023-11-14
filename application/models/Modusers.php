<?php
require_once ('Modunitkerja.php');
require_once ('Imodel.php');
require_once ('Moduseraccess.php');
require_once ('Modusertype.php');
//require_once ('modsubsystemmodule.php');
/**
 * @author user
 * @version 1.0
 * @created 10-Sep-2014 11:12:57 AM
 */
class ModUsers extends CI_Model implements IModel
{

	private $password;
	private $userId;
	private $userName;
	private $userStatus;
	private $userType;
	public $m_ModUnitKerja;
	//public $m_ModUserAccess;
	public $m_ModUserType;
	private $email;
	//public $m_ModSubSystemModule;
	public $m_ModUserAccess;
	private $unitId;
	private $idEvaluator;
	public $m_ModSubSystemModule;
	//public $m_ModUserAccess;
        const table = 'users';

	function __construct($id='')
	{
            parent::__construct();
            if($id != ''){
                $this->db->select('*');
                $this->db->from('users');
                $this->db->where('user_id', $id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value) {
                        $this->setUserId($value->user_id);
                        $this->setPassword($value->password);
                        $this->setUserName($value->user_name);
                        $this->setUserType($value->user_type);
                        $this->setUserStatus($value->user_status);
                        $this->setUnitId($value->unit_id);
                        $this->setUserType($value->user_type);
                        $this->setEmail($value->email);
                        $this->setIdEvaluator($value->id_evaluator);
                        //$this->m_ModUnitKerja = new ModUnitKerja($value->unit_id);                        
                        //$this->m_ModUserType = new ModUserType($value->user_type);
                        //$this->m_ModUserAccess = new ModUserAccess($value->user_id);
                                                
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function delete()
	{
            $this->db->delete('users', array('user_id'=>  $this->getUserId()));
	}

	/**
	 * 
	 * @param criteria
	 * @param value
	 * @param row
	 * @param segment    segment
	 */
	public function getObjectFiltered($criteria, $value, $row, $segment)
	{
            $list = new ArrayObject();
            $this->db->select('*');
            $this->db->from('users us');       
            $this->db->join('unit_kerja uk', 'us.unit_id = uk.unit_id');
            
            if($criteria=='username'){
                $this->db->like('user_name',$value,'both');
            }elseif($criteria=='usertype'){
                $this->db->like('user_type',$value,'both');
            }elseif($criteria=='unitname'){
                $this->db->like('uk.unit_name',$value,'both');
            }
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('user_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result() as $row){
                $obj = new ModUsers($row->user_id);
                $list->append($obj);
            }
            return $list;
	}

	/**
	 * 
	 * @param row
	 * @param segment    segment
	 */
	public function getObjectList($row, $segment)
	{
            $list = new ArrayObject();
            $this->db->select('*');
            $this->db->from('users');                
            
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('user_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result() as $row){
                $obj = new ModUsers($row->user_id);
                $list->append($obj);
            }
            return $list;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function getUserName()
	{
		return $this->userName;
	}

	public function getUserStatus()
	{
		return $this->userStatus;
	}

	public function getUserType()
	{
		return $this->userType;
	}

	public function insert()
	{
            $data = array('user_id'=>  $this->getUserId(),
                    'user_name'=>  $this->getUserName(),
                    'unit_id'=>  $this->m_ModUnitKerja->getUnitId(),
                    'password'=>  md5($this->getPassword()),
                    'user_type'=>  $this->m_ModUserType->getUserType(),
                    'email'=>  $this->getEmail(),
                    'user_status'=> $this->getUserStatus(),
            		'id_evaluator'=> $this->getIdEvaluator()
            );
                $this->db->insert('users', $data);
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPassword($newVal)
	{
		$this->password = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserId($newVal)
	{
		$this->userId = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserName($newVal)
	{
		$this->userName = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserStatus($newVal)
	{
		$this->userStatus = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserType($newVal)
	{
		$this->userType = $newVal;
	}

	public function update()
	{
            $data = array('user_id'=>  $this->getUserId(),
                    'user_name'=>  $this->getUserName(),
                    'unit_id'=>  $this->m_ModUnitKerja->getUnitId(),
                    //'password'=>  $this->getPassword(),
                    'user_type'=>  $this->m_ModUserType->getUserType(),
                    'email'=>  $this->getEmail(),
                    'user_status'=> $this->getUserStatus(),
            		'id_evaluator'=> $this->getIdEvaluator()
            );
            
                $this->db->where('user_id', $this->getUserId());
            $this->db->update('users', $data);
	}
        
        public function updatePassword()
        {
            $data = array('password'=>  md5($this->getPassword()));
            $this->db->where('user_id', $this->getUserId());
            $this->db->update('users', $data);
        }
        
        public function login()
        {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('user_id', strtoupper($this->getUserId()));
            $this->db->where('password', md5($this->getPassword()));
            $result = $this->db->get();
            $return = FALSE;
            if($result->num_rows()>0){
                $return = TRUE;
            }
            return $return;
        }

	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setEmail($newVal)
	{
		$this->email = $newVal;
	}

	public function getUnitId()
	{
		return $this->unitId;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUnitId($newVal)
	{
		$this->unitId = $newVal;
	}

	public function getIdEvaluator()
	{
		return $this->idEvaluator;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdEvaluator($newVal)
	{
		$this->idEvaluator = $newVal;
	}

        public function getResult($params) {
        $this->db->select(self::table.'.*');
        $this->db->from(self::table);
        
        $count = false;
        foreach ($params as $key => $value) {
            if($key=='join'){
                foreach ($value as $key => $sub_value){
                    foreach ($sub_value as $operator => $value) {                        
                        $this->db->join($key, $value, $operator);
                    }
                    
                }
            }
            if($key=='field'){
                foreach ($value as $key => $sub_value) {
                    foreach ($sub_value as $operator => $item){
                        if($operator=='IN'){
                            $this->db->where_in($key, $item);
                        }elseif($operator=='NOT IN'){
                            $this->db->where_not_in($key, $item);
                        }elseif($operator=='LIKE'){
                            $this->db->like('lower('.$key.')', strtolower($item));
                        } elseif ($operator == 'BETWEEN'){
                            $where = $key . " ".$operator." '".$item[0]."' AND '".$item[1]."'";
                            $this->db->where($where);
                        }else{
                            $this->db->where($key.$operator, $item);
                        }
                    }
                    
                }
            }
            
            if($key=='paging'){
                foreach ($value as $key => $value) {
                    if($key=='row'){
                        $row = $value;
                    }else{
                        $segment = $value;
                    }
                }
            }
            if($key=='count'){
                $count = $value;           
            }
            if($key=='order'){
                foreach ($value as $key => $value) {
                    $this->db->order_by($key, $value);
                }                
            }
        }
        if($count){
            return $this->db->count_all_results();
        }elseif($row==0 && $segment==0){            
            return $this->db->get();
        }else{            
            return $this->db->get('',$row,$segment);
        }
    }

}
?>