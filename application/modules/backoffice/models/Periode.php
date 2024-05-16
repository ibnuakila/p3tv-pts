<?php
require_once ('Basemodel.php');




//use ;
/**
 * @author LENOVO
 * @version 1.0
 * @created 05-Feb-2018 7:14:41 AM
 */
class Periode extends CI_Model implements BaseModel
{

	private $closeDate;
	private $openDate;
	private $periode;
	private $statusPeriode;

	function __construct($id='')
	{
            parent::__construct();
        if ($id != '') {
            $sql = "SELECT * FROM tbl_periode WHERE periode='" . $id . "'";
            $result = $this->db->query($sql);
            if ($result->num_rows() > 0) {
                foreach ($result->result('array') as $value) {
                    $this->setPeriode($value['periode']);
                    $this->setOpenDate($value['open_date']);
                    $this->setCloseDate($value['close_date']);
                    $this->setStatusPeriode($value['status_periode']);
                    
                }
            }
        }
	}

	function __destruct()
	{
	}



	public function getCloseDate()
	{
		return $this->closeDate;
	}

	public function getOpenDate()
	{
		return $this->openDate;
	}

	public function getPeriode()
	{
		return $this->periode;
	}

	public function getStatusPeriode()
	{
		return $this->statusPeriode;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setCloseDate($newVal)
	{
		$this->closeDate = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setOpenDate($newVal)
	{
		$this->openDate = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPeriode($newVal)
	{
		$this->periode = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setStatusPeriode($newVal)
	{
		$this->statusPeriode = $newVal;
	}

	public function delete()
	{
	}

	/**
	 * 
	 * @param row
	 * @param segment    segment
	 */
	public function get($row = Null, $segment = Null)
	{
            $this->db->select('*');
            $this->db->from('tbl_periode');
            $this->db->order_by('periode','desc');
            if ($row == NULL && $segment == NULL) {
                return $this->db->count_all_results();
            } elseif ($row == 0 && $segment == 0) {
                return $this->db->get();
            } else {
                return $this->db->get('', $row, $segment);
            }
	}

	/**
	 * 
	 * @param field
	 * @param value    value
	 */
	public function getBy($field, $value)
	{
            $this->db->select('*');
            $this->db->from('tbl_periode');
            $this->db->where($field, $value);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result('array') as $value) {
                    $this->setPeriode($value['periode']);
                    $this->setOpenDate($value['open_date']);
                    $this->setCloseDate($value['close_date']);
                    $this->setStatusPeriode($value['status_periode']);
                }
                return TRUE;
            } else {
                return FALSE;
            }
	}

	/**
	 * 
	 * @param related
	 * @param field
	 * @param value    value
	 * @param row
	 * @param segment
	 */
	public function getByRelated($related, $field, $value, $row = Null, $segment = Null)
	{
	}

	public function insert()
	{
	}

	public function update()
	{
	}
        
        public function getOpenPeriode() {
            $this->db->select('periode');
            $this->db->from('tbl_periode');
            $this->db->where('status_periode', 'open');
            $result = $this->db->get();
            $row = $result->row();
            /*$periodes = array();
            if($result->num_rows()>0){
                foreach($result->result() as $row){
                    $periodes[]=$row->periode;
                }
            }else{
                $this->db->select('periode');
                $this->db->from('tbl_periode');
                $this->db->order_by('periode','Desc');
                $result = $this->db->get();
                foreach($result->result() as $row){
                    $periodes[]=$row->periode;
                }
            }*/
            return $row;
        }

}
?>