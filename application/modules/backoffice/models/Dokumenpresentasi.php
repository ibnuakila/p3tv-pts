<?php
require_once ('Basemodel.php');

//namespace models;



//use models;
/**
 * @author LENOVO
 * @version 1.0
 * @created 06-May-2020 9:18:15 PM
 */
class DokumenPresentasi extends CI_Model implements BaseModel
{

	private $idJnsFile;
	private $namaFile;
	private $id;

	function __construct($id=null)
	{
            parent::__construct();
            if($id!=NULL){
                $this->db->select('*');
                $this->db->from('dokumen_presentasi_baru');
                $this->db->where('id', $id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    $row = $result->row();
                    $this->id = $row->id;
                    $this->idJnsFile = $row->id_jns_file;
                    $this->namaFile = $row->nama_file;
                }
            }
	}

	function __destruct()
	{
	}



	public function getIdJnsFile()
	{
		return $this->idJnsFile;
	}

	public function getNamaFile()
	{
		return $this->namaFile;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdJnsFile($newVal)
	{
		$this->idJnsFile = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNamaFile($newVal)
	{
		$this->namaFile = $newVal;
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
	}

	/**
	 * 
	 * @param field
	 * @param value    value
	 */
	public function getBy($field, $value)
	{
            $this->db->select('*');
		$this->db->from('dokumen_presentasi_baru');
		$this->db->where($field, $value);
		$result = $this->db->get();
		if($result->num_rows()>0){
                    $row = $result->row();
                    $this->id = $row->id;
                    $this->idJnsFile = $row->id_jns_file;
                    $this->namaFile = $row->nama_file;
                
			return TRUE;
		}else{
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

	public function getId()
	{
		return $this->id;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setId($newVal)
	{
		$this->id = $newVal;
	}
        
        public function getDokumenReviewer($params){
            
            
        }
        
        public function getDokumenTeknis($params) {
            $sql = "SELECT * FROM dokumen_presentasi_baru " .
                    "WHERE bagian = '" . $params['direktorat'] . "' " .
                    "AND jns_usulan = '" . $params['jns_usulan'] . "' " .
                    "AND aktor = 'Tim Teknis' " .
                    "AND periode = '" . $params['periode'] . "'" .
                    "AND id_jns_file IN('1','2','3','4','5') " .
                    "AND id_jns_file NOT IN (" .
                    "SELECT id_jns_file FROM rekapitulasi_berita_acara WHERE id_registrasi = '" . $params['id_registrasi'] . "')";

            return $this->db->query($sql);
        }

}
?>