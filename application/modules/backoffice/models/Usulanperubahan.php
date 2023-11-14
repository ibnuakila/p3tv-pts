<?php




/**
 * @author akil
 * @version 1.0
 * @created 30-May-2016 16:52:51
 */
class UsulanPerubahan extends CI_Model
{

	private $kdpti;
	private $status;
	private $tahunUsulan;

	function __construct($id)
	{
		parent::__construct();
		if($id != NULL){
			$this->db->select('*');
			$this->db->from('usulan_perubahan');
			$this->db->where('kdpti',$id);
			
			$result = $this->db->get();
			if($result->num_rows()>0){
				foreach ($result->result() as $value){
					$this->setKdpti($value->kdpti);
					$this->setStatus($value->status);
					$this->setTahunUsulan($value->periode);
				}
			}
		}
	}

	function __destruct()
	{
	}



	public function getKdpti()
	{
		return $this->kdpti;
	}

	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKdpti($newVal)
	{
		$this->kdpti = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setStatus($newVal)
	{
		$this->status = $newVal;
	}

	public function getTahunUsulan()
	{
		return $this->tahunUsulan;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTahunUsulan($newVal)
	{
		$this->tahunUsulan = $newVal;
	}

}
?>