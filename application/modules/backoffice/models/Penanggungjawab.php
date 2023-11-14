<?php




/**
 * @author ibnua
 * @version 1.0
 * @created 18-May-2023 12:35:24 PM
 */
class PenanggungJawab extends CI_Model
{

	private $email;
	private $hadphone;
	private $idPj;
	private $idRegistrasi;
	private $jabatan;
	private $namaPj;

	function __construct($id=null)
	{
            parent::__construct();
            if($id != NULL){
                $this->db->select('*');         
                $this->db->from('penanggung_jawab');
                $this->db->where('id_registrasi',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){
                        $this->setNamaPj($value->nama_pj);
                        $this->setHadphone($value->handphone);
                        $this->setEmail($value->email);
                        $this->setJabatan($value->jabatan);
                        $this->setIdPj($value->id_pj);
                        $this->setIdRegistrasi($value->id_registrasi);
                    }
                }
            }

	}

	function __destruct()
	{
	}



	public function getEmail()
	{
		return $this->email;
	}

	public function getHadphone()
	{
		return $this->hadphone;
	}

	public function getIdPj()
	{
		return $this->idPj;
	}

	public function getIdRegistrasi()
	{
		return $this->idRegistrasi;
	}

	public function getJabatan()
	{
		return $this->jabatan;
	}

	public function getNamaPj()
	{
		return $this->namaPj;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setEmail($newVal)
	{
		$this->email = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setHadphone($newVal)
	{
		$this->hadphone = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdPj($newVal)
	{
		$this->idPj = $newVal;
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
	public function setJabatan($newVal)
	{
		$this->jabatan = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNamaPj($newVal)
	{
		$this->namaPj = $newVal;
	}

}
?>