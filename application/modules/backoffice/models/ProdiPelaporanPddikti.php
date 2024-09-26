<?php

require_once ('Basemodel.php');


/**
 * @author ibnua
 * @version 1.0
 * @created 04-Jul-2022 21:52:48
 */
class ProdiPelaporanPddikti extends CI_Model implements BaseModel
{

	private $dosen;
	private $dosenNidn;
	private $jenjang;
	private $kdProdi;
	private $kdPti;
	private $mahasiswa;
	private $namaProdi;
	private $semester;

	function __construct()
	{
            parent::__construct();            
	}

	function __destruct()
	{
	}



	public function getDosen()
	{
		return $this->dosen;
	}

	public function getDosenNidn()
	{
		return $this->dosenNidn;
	}

	public function getJenjang()
	{
		return $this->jenjang;
	}

	public function getKdProdi()
	{
		return $this->kdprodi;
	}

	public function getKdpti()
	{
		return $this->kdpti;
	}

	public function getMahasiswa()
	{
		return $this->mahasiswa;
	}

	public function getNamaProdi()
	{
		return $this->namaProdi;
	}

	public function getSemester()
	{
		return $this->semester;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setDosen($newVal)
	{
		$this->dosen = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setDosenNidn($newVal)
	{
		$this->dosenNidn = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setJenjang($newVal)
	{
		$this->jenjang = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKdProdi($newVal)
	{
		$this->kdProdi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKdPti($newVal)
	{
		$this->kdPti = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setMahasiswa($newVal)
	{
		$this->mahasiswa = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNamaProdi($newVal)
	{
		$this->namaProdi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setSemester($newVal)
	{
		$this->semester = $newVal;
	}

    public function delete() {
        
    }

    public function get($row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('prodi_pelaporan_pddikti');
        $this->db->where('kdpti', $this->kdPti);        
        
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == '0' && $segment == '0') {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }
    
    public function getProdi($params){
        $this->db->select('*');
        $this->db->from('prodi_pelaporan_pddikti');
        $this->db->where('kdpti', $params['kdpti']);
        if(isset($params['nama_prodi']) && isset($params['jenjang'])){
            $this->db->where('nama_prodi', $params['nama_prodi']);
            $this->db->where('jenjang', $params['jenjang']);
        }
        return $this->db->get();
    }

    public function getBy($field, $value) {
        $this->db->select('*');
        $this->db->from('prodi_pelaporan_pddikti');
        $this->db->where($field, $value);
        return $this->db->get();
    }

    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        
    }

    public function insert() {
        $data = [
            'kdpti' => $this->kdPti,
            'kdprodi' => $this->kdProdi,
            'nama_prodi' => $this->namaProdi,
            'jenjang' => $this->jenjang,
            'semester' => $this->semester,
            'mahasiswa' => $this->mahasiswa,
            'dosen' => $this->dosen,
            'dosen_nidn' => $this->dosenNidn
        ];
        $this->db->insert('prodi_pelaporan_pddikti', $data);
        
    }

    public function update() {
        
    }
    
    public function isExist(){
        $this->db->select('*');
        $this->db->from('prodi_pelaporan_pddikti');
        $this->db->where('kdpti', $this->kdPti);
        $this->db->where('kdprodi', $this->kdProdi);
        $this->db->where('semester', $this->semester);
        $return = $this->db->get();
        if($return->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }

}
?>