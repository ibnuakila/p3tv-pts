<?php
require_once ('Modusers.php');
require_once ('Modsubsystemmodule.php');
require_once ('Imodel.php');



/**
 * @author user
 * @version 1.0
 * @created 10-Sep-2014 11:13:19 AM
 */
class ModUserAccess extends CI_Model implements IModel
{

	
	//public $m_ModUsers;
	//public $m_ModSystemModule;
	private $userId;
	public $m_ModSubSystemModule;
	private $subModuleId;

	function __construct($id='')
	{
            parent::__construct();
            if($id != ''){
                $this->db->select('*');
                $this->db->from('user_access');
                $this->db->where('user_id', $id);
                //$this->db->where('sub_module_id', $submoduleid);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    
                    //$list = new ArrayObject();
                    foreach ($result->result('array') as $value) {
                        
                        $this->setUserId($value['user_id']);
                        $this->setSubModuleId($value['sub_module_id']);
                        //$obj = new ModSubSystemModule($value['sub_module_id']);                        
                        //$list->append($obj);
                    }
                    //$this->m_ModSubSystemModule = $list;
                   
                }
            }
	}

	function __destruct()
	{
	}



	public function delete()
	{
            $this->db->delete('user_access', array('user_id'=> $this->getUserId()));
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
            $this->db->from('user_access');                
            $this->db->where('user_id',  $this->getUserId());
            $result = '';
            if($row=='' && $segment==''){
                //$this->db->order_by('module_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result() as $row){
                $obj = new ModUserAccess($row->user_id);
                $list->append($obj);
            }
            return $list;            
	}

	
	public function insert()
	{
            $data = array('user_id'=>  $this->getUserId(),
                    'sub_module_id'=>  $this->m_ModSubSystemModule->getSubModuleId());
                $this->db->insert('user_access', $data);
	}

	

	public function update()
	{
            /*$data = array('user_id'=>  $this->getUserId(),
                    'sub_module_id'=>  $this->m_ModSubSystemModule->getSubModuleId());
                                    
            $this->db->where('user_id', $this->getUserId());
            $this->db->update('user_access', $data);*/
            //tidak ada operasi update
            //delete terlebih dahulu baru kemudian insert lagi
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

	
	public function getSubModuleId()
	{
		return $this->subModuleId;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setSubModuleId($newVal)
	{
		$this->subModuleId = $newVal;
	}

}
?>