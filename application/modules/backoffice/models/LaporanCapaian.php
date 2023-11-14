<?php




/**
 * @author ibnua
 * @version 1.0
 * @created 19-Dec-2022 8:47:51 AM
 */
class LaporanCapaian extends CI_Model  implements BaseModel
{

	private $baseLine;
	private $capaian;
	private $id;
	private $idRegistrasi;
	private $indikatorId;
	private $tahun;
	private $target;

	function __construct($params=null)
	{
            parent::__construct();
            
            if (is_array($params)) {
                $sql = "SELECT * FROM laporan_capaian WHERE id_registrasi='" . $params['id_registrasi'] . "'" .
                        " AND indikator_id = '" . $params['indikator_id'] . "'";
                $result = $this->db->query($sql);
                if ($result->num_rows() > 0) {
                    foreach ($result->result('array') as $value) {
                        $this->setId($value['id']);
                        $this->setBaseLine($value['baseline']);
                        $this->setTarget($value['target']);
                        $this->setCapaian($value['capaian']);
                        $this->setTahun($value['tahun']);
                        $this->setIndikatorId($value['indikator_id']);
                        $this->setIdRegistrasi($value['id_registrasi']);
                        
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getBaseLine()
	{
		return $this->baseLine;
	}

	public function getCapaian()
	{
		return $this->capaian;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getIdRegistrasi()
	{
		return $this->idRegistrasi;
	}

	public function getIndikatorId()
	{
		return $this->indikatorId;
	}

	public function getTahun()
	{
		return $this->tahun;
	}

	public function getTarget()
	{
		return $this->target;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setBaseLine($newVal)
	{
		$this->baseLine = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setCapaian($newVal)
	{
		$this->capaian = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setId($newVal)
	{
		$this->id = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdRegistrasi($newVal)
	{
		$this->idRegistrasi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIndikatorId($newVal)
	{
		$this->indikatorId = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTahun($newVal)
	{
		$this->tahun = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTarget($newVal)
	{
		$this->target = $newVal;
	}

    public function delete() {
        
    }

    public function get($row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('laporan_capaian');
        $this->db->where('id_registrasi', $this->idRegistrasi);
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            //$this->db->order_by('tgl_kontrak','Desc');
            return $this->db->get();
        } else {
            //$this->db->order_by('tgl_kontrak','Desc');
            return $this->db->get('', $row, $segment);
        }
    }

    public function getBy($field, $value) {
        
    }

    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        
    }

    public function insert() {
        
    }

    public function update() {
        
    }

}
?>