<?php




/**
 * @author ibnua
 * @version 1.0
 * @created 19-Dec-2022 8:47:48 AM
 */
class LaporanIndikator extends CI_Model implements BaseModel
{

	private $id;
	private $indikator;

	function __construct($id=null)
	{
            parent::__construct();
            
            if (($id!=null)) {
                $sql = "SELECT * FROM laporan_indikator WHERE id='" . $id . "'" ;
                $result = $this->db->query($sql);
                if ($result->num_rows() > 0) {
                    foreach ($result->result('array') as $value) {
                        $this->setId($value['id']);
                        $this->setIndikator($value['indikator']);
                        
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getId()
	{
		return $this->id;
	}

	public function getIndikator()
	{
		return $this->indikator;
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
	public function setIndikator($newVal)
	{
		$this->indikator = $newVal;
	}

    public function delete() {
        
    }

    public function get($row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('laporan_indikator');
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