<?php




/**
 * @author akil
 * @version 1.0
 * @created 30-May-2016 15:45:51
 */
class LaporanPdpt extends CI_Model
{

	private $kdpti;
	private $persentasi;
	private $tahunLapor;

	function __construct($id,$thn)
	{
		parent::__construct();
		if($id != NULL){
			$this->db->select('*');
			$this->db->from('laporan_pdpt');
			$this->db->where('kdpti',$id);
			$this->db->where('tahun_lapor',$thn);
			$result = $this->db->get();
			if($result->num_rows()>0){
				foreach ($result->result() as $value){
					$this->setKdpti($value->kdpti);
					$this->setTahunLapor($value->tahun_lapor);
					$this->setPersentasi($value->persentase);
					
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

	public function getPersentasi()
	{
		return $this->persentasi;
	}

	public function getTahunLapor()
	{
		return $this->tahunLapor;
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
	public function setPersentasi($newVal)
	{
		$this->persentasi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTahunLapor($newVal)
	{
		$this->tahunLapor = $newVal;
	}

}
?>