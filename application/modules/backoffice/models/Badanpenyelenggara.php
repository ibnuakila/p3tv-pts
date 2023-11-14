<?php
//require_once ('modbadanhukum.php');

//namespace Silemkerma\evapro\models;


/**
 * @author user
 * @version 1.0
 * @created 10-Nov-2014 10:57:24 AM
 */
class BadanPenyelenggara extends CI_Model
{

	private $alamat;
	private $beritaNegara;
	private $ketuaPenyelenggara;
	private $namaNotaris;
	private $namaPenyelenggara;
	private $noAkteNotaris;
	private $noSuratPengesahan;
	private $penyelenggaraId;
	public $m_ModBadanHukum;
	private $kota;
    private $email;
	private $kdPti;
        
	function __construct($id='')
	{
            parent::__construct();
            if($id != ''){
                $sql = "SELECT * FROM tbl_badan_penyelenggara WHERE kdpti='".$id."'";
                $result = $this->db->query($sql);
                if($result->num_rows()>0){
                    foreach ($result->result('array') as $value) {
                        $this->setPenyelenggaraId($value['penyelenggara_id']);
                        $this->setNamaPenyelenggara($value['nama_penyelenggara']);
                        $this->setKetuaPenyelenggara($value['ketua_penyelenggara']);
                        $this->setAlamat($value['alamat']);
                        $this->setNoAkteNotaris($value['no_akte_notaris']);
                        $this->setNamaNotaris($value['nama_notaris']);
                        $this->setNoSuratPengesahan($value['no_surat_pengesahan']);
                        $this->setBeritaNegara($value['berita_negara']);
                        $this->setEmail($value['email_penyelenggara']);
                        $this->setKdPti($value['kdpti']);
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getAlamat()
	{
		return $this->alamat;
	}

	public function getBeritaNegara()
	{
		return $this->beritaNegara;
	}

	public function getKetuaPenyelenggara()
	{
		return $this->ketuaPenyelenggara;
	}

	public function getNamaNotaris()
	{
		return $this->namaNotaris;
	}

	public function getNamaPenyelenggara()
	{
		return $this->namaPenyelenggara;
	}

	public function getNoAkteNotaris()
	{
		return $this->noAkteNotaris;
	}

	public function getNoSuratPengesahan()
	{
		return $this->noSuratPengesahan;
	}

	public function getPenyelenggaraId()
	{
		return $this->penyelenggaraId;
	}
        
        public function getEmail()
        {
            return $this->email;
        }

        /**
	 * 
	 * @param newVal
	 */
	public function setAlamat($newVal)
	{
		$this->alamat = $newVal;
	}
        
        public function setEmail($newVal)
        {
            $this->email = $newVal;
        }

        /**
	 * 
	 * @param newVal
	 */
	public function setBeritaNegara($newVal)
	{
		$this->beritaNegara = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKetuaPenyelenggara($newVal)
	{
		$this->ketuaPenyelenggara = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNamaNotaris($newVal)
	{
		$this->namaNotaris = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNamaPenyelenggara($newVal)
	{
		$this->namaPenyelenggara = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNoAkteNotaris($newVal)
	{
		$this->noAkteNotaris = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNoSuratPengesahan($newVal)
	{
		$this->noSuratPengesahan = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPenyelenggaraId($newVal)
	{
		$this->penyelenggaraId = $newVal;
	}

	public function getKota()
	{
		return $this->kota;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKota($newVal)
	{
		$this->kota = $newVal;
	}

	public function getKdPti()
	{
		return $this->kdPti;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKdPti($newVal)
	{
		$this->kdPti = $newVal;
	}

}
?>