<?php


//namespace Silemkerma\evapro\models;


/**
 * @author user
 * @version 1.0
 * @created 20-Sep-2014 8:44:30 PM
 */
class ModAccessType extends CI_Model
{

	private $accessTypeName;
	private $accessTypeId;

	function __construct($id='')
	{
            parent::__construct();
            if($id != ''){
                $sql = "SELECT * FROM access_type WHERE access_type_id='".$id."'";
                $result = $this->db->query($sql);
                if($result->num_rows()>0){
                    foreach ($result->result() as $value) {
                        $this->setAccessTypeId($value->access_type_id);
                        $this->setAccessTypeName($value->access_type_name);
                        
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getAccessTypeName()
	{
		return $this->accessTypeName;
	}

	public function getAccessTypeId()
	{
		return $this->accessTypeId;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setAccessTypeName($newVal)
	{
		$this->accessTypeName = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setAccessTypeId($newVal)
	{
		$this->accessTypeId = $newVal;
	}

}
?>