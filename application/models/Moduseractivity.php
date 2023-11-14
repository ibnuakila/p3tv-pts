<?php
require_once ('Modusers.php');
require_once ('Imodel.php');



/**
 * @author user
 * @version 1.0
 * @created 10-Sep-2014 11:13:09 AM
 */
class ModUserActivity extends CI_Model implements IModel
{

	private $moduleAccessed;
	private $timeAccessed;
	public $m_ModUsers;
	private $id;

	function __construct($id='')
	{
            parent::__construct();
            if($id != ''){
                $sql = "SELECT * FROM user_activity WHERE id='".$id."'";
                $result = $this->db->query($sql);            
                if($result->num_rows()>0){
                    foreach ($result->result() as $value) {
                        $this->setId($value->id);
                        $this->setModuleAccessed($value->module_accessed);
                        $this->settimeAccessed($value->time_accessed);
                        $this->m_ModUsers = new ModUsers($value->user_id);
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function delete()
	{
	}

	public function getModuleAccessed()
	{
		return $this->moduleAccessed;
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
            $this->db->select('user_activity.*');
            $this->db->from('user_activity'); 
            $this->db->join('users', 'users.user_id = user_activity.user_id');
            if($criteria=='username'){
                $this->db->like('users.user_name', $value);
            }
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('time_accessed','desc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result() as $row){
                $obj = new ModUserActivity($row->id);
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
            $this->db->from('user_activity');            
            
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('time_accessed','desc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result() as $row){
                $obj = new ModUserActivity($row->id);
                $list->append($obj);
            }
            return $list;
	}

	public function gettimeAccessed()
	{
		return $this->timeAccessed;
	}

	public function insert()
	{
            $data = array('user_id'=>  $this->m_ModUsers->getUserId(),
                    'module_accessed'=>  $this->getModuleAccessed(),
                    'time_accessed'=>  $this->gettimeAccessed());
            return  $this->db->insert('user_activity', $data);
                
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setModuleAccessed($newVal)
	{
		$this->moduleAccessed = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function settimeAccessed($newVal)
	{
		$this->timeAccessed = $newVal;
	}

	public function update()
	{
	}

	public function getId()
	{
		return $this->id;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setId($newVal)
	{
		$this->id = $newVal;
	}

}
?>