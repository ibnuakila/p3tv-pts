<?php
require_once ('Modsysteminformation.php');
//require_once ('modsubsystemmodule.php');
require_once ('Imodel.php');



/**
 * @author user
 * @version 1.0
 * @created 10-Sep-2014 11:13:29 AM
 */
class ModSystemModule extends CI_Model implements IModel
{

	private $menuName;
	private $moduleId;
	private $moduleName;
	public $m_ModSystemInformation;
	//public $m_ModSubSystemModule;

	function __construct($id='')
	{
            parent::__construct();
            if($id != ''){
                $sql = "SELECT * FROM system_module WHERE module_id='".$id."' order by system_id";
                $result = $this->db->query($sql);
                if($result->num_rows()>0){
                    foreach ($result->result() as $value) {
                        $this->setModuleId($value->module_id);
                        $this->setModuleName($value->module_name);
                        $this->setMenuName($value->menu_name);
                        $this->m_ModSystemInformation = new ModSystemInformation($value->system_id);
                        //$subsystem = new ModSubSystemModule('','');
                        //$subsystem->setModuleId($value->module_id);
                        //$this->m_ModSubSystemModule = $subsystem->getObjectList('', '');
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function delete()
	{
            $this->db->delete('system_module', array('module_id'=>  $this->getModuleId()));
	}

	public function getMenuName()
	{
		return $this->menuName;
	}

	public function getModuleId()
	{
		return $this->moduleId;
	}

	public function getModuleName()
	{
		return $this->moduleName;
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
            $this->db->from('system_module sm');       
            $this->db->join('system_information si', 'sm.system_id = si.system_id');
            
            if($criteria=='modulename'){
                $this->db->like('sm.module_name',$value,'both');
            }elseif($criteria=='systemname'){
                $this->db->like('si.system_name',$value,'both');
            }
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('system_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result() as $row){
                $obj = new ModSystemModule($row->module_id);
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
            $this->db->select('*');            
            $this->db->where('module_name <>','');
            $this->db->from('system_module');
            
            if($this->m_ModSystemInformation->getSystemId() != ''){
                $this->db->where('system_id', $this->m_ModSystemInformation->getSystemId());
            }
            
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('system_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            /*foreach($result->result() as $row){
                $obj = new ModSystemModule($row->module_id);
                $list->append($obj);
            }*/
            return $result;
	}

	public function insert()
	{
            $data = array('module_id'=>  $this->getModuleId(),
                    'module_name'=>  $this->getMenuName(),
                    'menu_name'=>  $this->getMenuName(),
                    'system_id'=>  $this->m_ModSystemInformation->getSystemId());
                $this->db->insert('system_module', $data);
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
	public function setModuleId($newVal)
	{
		$this->moduleId = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setModuleName($newVal)
	{
		$this->moduleName = $newVal;
	}

	public function update()
	{
            $data = array('module_id'=>  $this->getModuleId(),
                    'module_name'=>  $this->getMenuName(),
                    'menu_name'=>  $this->getMenuName(),
                    'system_id'=>  $this->m_ModSystemInformation->getSystemId());
                $this->db->where('module_id', $this->getModuleId());
            $this->db->update('system_module', $data);
	}

	
}
?>