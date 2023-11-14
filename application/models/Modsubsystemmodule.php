<?php
require_once ('Imodel.php');
require_once ('Modaccesstype.php');
require_once ('Modsystemmodule.php');
//namespace Silemkerma\evapro\models;


/**
 * @author user
 * @version 1.0
 * @created 20-Sep-2014 10:01:21 AM
 */
class ModSubSystemModule extends CI_Model implements IModel
{

	private $menuName;
	//private $moduleId;
	private $subModuleId;
	private $subModuleName;
	private $subModuleDes;
	public $m_ModAccessType;
	public $m_ModSystemModule;
	private $userId;
	private $isMenu;
	private $accessTypeId;
	private $moduleId;

	function __construct($submoduleid='')
	{
            parent::__construct();
            if($submoduleid != ''){
                $this->db->select('*');
                $this->db->from('sub_system_module');                     
                $this->db->where('sub_module_id', $submoduleid);
                $this->db->order_by('module_id');
                
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result('array') as $value) {
                        $this->setModuleId($value['module_id']);
                        $this->setSubModuleId($value['sub_module_id']);
                        $this->setSubModuleName($value['sub_module_name']);
                        $this->setMenuName($value['menu_name']);
                        $this->setIsMenu($value['is_menu']);
                        $this->setSubModuleDes($value['deskripsi']);
                        $this->setAccessTypeId($value['access_type_id']);
                        //$this->m_ModSystemModule = new ModSystemModule($value->module_id);
                        //$this->m_ModAccessType = new ModAccessType($value->access_type_id);
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getMenuName()
	{
		return $this->menuName;
	}

	
	public function getSubModuleId()
	{
		return $this->subModuleId;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setMenuName($newVal)
	{
		$this->menuName = $newVal;
	}

	

	/**
	 * 
	 * @param newVal
	 */
	public function setSubModuleId($newVal)
	{
		$this->subModuleId = $newVal;
	}

	public function delete()
	{
            $this->db->delete('sub_system_module',array('sub_module_id'=>  $this->getSubModuleId()));
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
            $this->db->from('sub_system_module');
            
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
            foreach($result->result('array') as $row){
                $obj = new ModSubSystemModule($row['sub_module_id']);
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
            //$list = new ArrayObject();
            $this->db->select('ssm.*');
            $this->db->from('sub_system_module ssm');            
            $result = '';
            if($this->getUserId() != ''){
                $this->db->join('user_access ua', 'ua.sub_module_id = ssm.sub_module_id','inner');
                $this->db->join('system_module sm', 'ssm.module_id = sm.module_id','inner');
                $this->db->where('ua.user_id', $this->getUserId());
                if($this->m_ModSystemModule != null){
                    $this->db->where('ssm.module_id', $this->m_ModSystemModule->getModuleId());
                }
                $this->db->order_by('sm.system_id','asc');
                $this->db->order_by('sm.module_name','asc');
                
            }
            
            if($row=='' && $segment==''){
                //$this->db->order_by('ua.module_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            
            /*if($result->num_rows()>0){
                foreach($result->result('array') as $row){
                    $obj = new ModSubSystemModule($row['sub_module_id']);
                    $list->append($obj);
                }
            }*/
            return $result;
	}
	public function getObjectListModule($row, $segment)
	{
            $list = new ArrayObject();
            $this->db->select('*');
            $this->db->where('sub_module_name <>','');
            $this->db->from('sub_system_module');
            
            if($this->m_ModSystemModule->module_id != ''){
                $this->db->where('module_id', $this->m_ModSystemModule->module_id);
            }
            
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('module_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            /*foreach($result->result() as $row){
                $obj = new ModSubSystemModule($row->sub_module_id);
                $list->append($obj);
            }*/
            return $result;
	}

	public function insert()
	{
            $data=  array('module_id'=>  $this->m_ModSystemModule->module_id,
                    'sub_module_id'=>  $this->getSubModuleId(),
                    'sub_module_name'=>  $this->getSubModuleName(),
                    'menu_name'=>  $this->getMenuName(),
                    'access_type_id'=>  $this->m_ModAccessType->getAccesTypeId(),
                    'is_menu'=>  $this->getIsMenu());
            $this->db->insert('sub_system_module',$data);
	}

	public function update()
	{
            $data=  array('module_id'=>  $this->m_ModSystemModule->module_id,
                    'sub_module_id'=>  $this->getSubModuleId(),
                    'sub_module_name'=>  $this->getSubModuleName(),
                    'menu_name'=>  $this->getMenuName(),
                    'access_type_id'=>  $this->m_ModAccessType->getAccesTypeId(),
                    'is_menu'=>  $this->getIsMenu());
            
            $this->db->where('sub_module_id',  $this->getSubModuleId());
            $this->db->update('sub_system_module',$data);
	}

	public function getSubModuleName()
	{
		return $this->subModuleName;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setSubModuleName($newVal)
	{
		$this->subModuleName = $newVal;
	}
	
	public function getSubModuleDes()
	{
		return $this->subModuleDes;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setSubModuleDes($newVal)
	{
		$this->subModuleDes = $newVal;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserId($newVal)
	{
		$this->userId = $newVal;
	}

	public function getIsMenu()
	{
		return $this->isMenu;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIsMenu($newVal)
	{
		$this->isMenu = $newVal;
	}

	public function getAccessTypeId()
	{
		return $this->accessTypeId;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setAccessTypeId($newVal)
	{
		$this->accessTypeId = $newVal;
	}

	public function getModuleId()
	{
		return $this->moduleId;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setModuleId($newVal)
	{
		$this->moduleId = $newVal;
	}

}
?>