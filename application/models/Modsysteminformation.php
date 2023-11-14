<?php
require_once ('Imodel.php');



/**
 * @author user
 * @version 1.0
 * @created 10-Sep-2014 11:13:39 AM
 */
class ModSystemInformation extends CI_Model implements IModel
{

	private $systemId;
	private $systemName;
	private $systemLabel;

	function __construct($id='')
	{
            parent::__construct();
            if($id != ''){
                $sql = "SELECT * FROM system_information WHERE system_id='".$id."'";
                $result = $this->db->query($sql);
                if($result->num_rows()>0){
                    foreach ($result->result('array') as $value) {
                        $this->setSystemId($value['system_id']);
                        $this->setSystemName($value['system_name']);
                        $this->setSystemLabel($value['system_label']);
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function delete()
	{
            $this->db->delete('system_information', array('system_id'=>  $this->getSystemId()));
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
            $this->db->from('system_information');                
            
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('system_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result('array') as $row){
                $obj = new ModSystemInformation($row['system_id']);
                $list->append($obj);
            }
            return $list;
	}
        
        public function getObjectListUser($id_user)
	{
           
            //$list = new ArrayObject();
            $this->db->select('si.*');
            $this->db->from('system_information si');   
            $this->db->join('system_module sm', 'si.system_id = sm.system_id');
            $this->db->join('sub_system_module ssm', 'sm.module_id = ssm.module_id');
            $this->db->join('user_access ua', 'ssm.sub_module_id = ua.sub_module_id');
            $this->db->where('ua.user_id',$id_user);
            $this->db->group_by('si.system_id');
            $result = '';           
            $this->db->order_by('si.system_id','asc');
            $result = $this->db->get('');
            
            return $result;
	}

	public function getSystemId()
	{
		return $this->systemId;
	}

	public function getSystemName()
	{
		return $this->systemName;
	}

	public function insert()
	{
            $data = array('system_name'=>  $this->getSystemName());
            $this->db->insert('system_information', $data);
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setSystemId($newVal)
	{
		$this->systemId = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setSystemName($newVal)
	{
		$this->systemName = $newVal;
	}

	public function update()
	{
            $data = array('system_name'=>  $this->getSystemName());
            $this->db->where('system_id', $this->getSystemId());
            $this->db->update('system_information', $data);
	}
	
	public function getSystemLabel()
	{
		return $this->systemLabel;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setSystemLabel($newVal)
	{
		$this->systemLabel = $newVal;
	}

}
?>