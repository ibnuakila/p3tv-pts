<?php
require_once ('Imodel.php');



/**
 * @author user
 * @version 1.0
 * @created 10-Sep-2014 11:12:49 AM
 */
class ModUnitKerja extends CI_Model implements IModel
{

	private $unitId;
	private $unitName;
	private $modul;

	function __construct($id='')
	{
            parent::__construct();
            if($id != ''){
                $sql = "SELECT * FROM unit_kerja WHERE unit_id='".$id."'";
                $result = $this->db->query($sql);
                if($result->num_rows()>0){
                    foreach ($result->result() as $value) {
                        $this->setUnitId($value->unit_id);
                        $this->setUnitName($value->unit_name);
                        $this->setModul($value->modul);
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
            $this->db->from('unit_kerja');                
            
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('unit_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result() as $row){
                $obj = new ModUnitKerja($row->unit_id);
                $list->append($obj);
            }
            return $list;
	}

	public function getUnitId()
	{
		return $this->unitId;
	}

	public function getUnitName()
	{
		return $this->unitName;
	}
	public function getModul()
	{
		return $this->modul;
	}
	public function insert()
	{
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUnitId($newVal)
	{
		$this->unitId = $newVal;
	}
/**
	 * 
	 * @param newVal
	 */
	public function setModul($newVal)
	{
		$this->modul = $newVal;
	}
	/**
	 * 
	 * @param newVal
	 */
	public function setUnitName($newVal)
	{
		$this->unitName = $newVal;
	}

	public function update()
	{
	}

}
?>