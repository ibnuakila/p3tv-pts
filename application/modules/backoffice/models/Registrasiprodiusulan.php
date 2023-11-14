<?php




/**
 * @author LENOVO
 * @version 1.0
 * @created 12-Mar-2020 8:09:41 PM
 */
class RegistrasiProdiUsulan extends CI_Model implements BaseModel
{

	private $idRegistrasi;
	private $namaProdi;
	private $program;

	function __construct()
	{
		parent::__construct();
		
	}

	function __destruct()
	{
	}



	public function getIdRegistrasi()
	{
		return $this->idRegistrasi;
	}

	public function getNamaProdi()
	{
		return $this->namaProdi;
	}

	public function getProgram()
	{
		return $this->jenjang;
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
	public function setNamaProdi($newVal)
	{
		$this->namaProdi = $newVal;
	}

	/**
	 *
	 * @param newVal
	 */
	public function setProgram($newVal)
	{
		$this->program = $newVal;
	}
	
	/**
	 * 
	 * @param row
	 * @param segment
	 */
	public function get($row = Null, $segment = Null){
		
	}

	/**
	 * 
	 * @param field
	 * @param value
	 */
	public function getBy($field, $value){
		$this->db->select('*');
		$this->db->from('registrasi_prodi');
		$this->db->where($field,$value);
		return $this->db->get();
	}

	/**
	 * 
	 * @param related
	 * @param field
	 * @param value
	 */
	public function getByRelated($related, $field, $value, $row = Null, $segment = Null){
		
	}

	public function insert(){
		$data = array('id_registrasi'=>$this->idRegistrasi,
		'nama_prodi'=>$this->namaProdi,
		'jenjang'=>$this->program);
		return $this->db->insert('registrasi_prodi',$data);
	}

	public function update(){
		
	}
	
	public function delete(){
		return $this->db->delete('registrasi_prodi', array('id_registrasi'=>$this->idRegistrasi));
	}
	
	public function isExist(){
		$this->db->select('*');
		$this->db->from('registrasi_prodi');
		$this->db->where('id_registrasi', $this->idRegistrasi);
		$result = $this->db->get();
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

}
?>