<?php
require_once ('Imodel.php');

//namespace Silemkerma\evapro\models;


/**
 * @author user
 * @version 1.0
 * @created 16-Sep-2014 11:48:53 AM
 */
class ModUserType extends CI_Model implements IModel
{

	private $typeName;
	private $userType;

	function __construct($id='')
	{
            parent::__construct();
            if($id != ''){
                $sql = "SELECT * FROM user_type WHERE user_type='".$id."'";
                $result = $this->db->query($sql);
                if($result->num_rows()>0){
                    foreach ($result->result() as $value) {
                        $this->setUserType($value->user_type);
                        $this->setTypeName($value->type_name);
                        
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getTypeName()
	{
		return $this->typeName;
	}

	public function getUserType()
	{
		return $this->userType;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTypeName($newVal)
	{
		$this->typeName = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserType($newVal)
	{
		$this->userType = $newVal;
	}

	public function delete()
	{
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
            $this->db->from('user_type');                
            
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('user_type','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result() as $row){
                $obj = new ModUserType($row->user_type);
                $list->append($obj);
            }
            return $list;
	}

	public function insert()
	{
	}

	public function update()
	{
	}

}
?>