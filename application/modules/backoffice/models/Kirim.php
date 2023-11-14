<?php
require_once ('Basemodel.php');




//use ;
/**
 * @author siti
 * @version 1.0
 * @created 18-Jun-2017 11:52:16
 */
class Kirim extends CI_Model implements BaseModel
{

	private $alamat;
	private $fileBuktiKirim;
	private $fileBuktiTerima;
	private $idDetailPaketHibah;
	private $jasaKirim;
	private $kodePos;
	private $kota;
	private $noResi;
	private $penerima;
	private $propinsi;
	private $status;
	private $tglKirim;
	private $tglTerima;
	private $idSupplier;
	private $kdPti;
        private $id;

	function __construct($id=NULL)
	{
            parent::__construct($id);
            if($id != NULL){
                    $this->db->select('*');         
                    $this->db->from('tbl_kirim');
                    $this->db->where('id',$id);
                    $result = $this->db->get();
                    if($result->num_rows()>0){
                        foreach ($result->result() as $value){
                            $this->id = $value->id;
                            $this->alamat = $value->alamat;
                            $this->kodePos = $value->kode_pos;
                            $this->propinsi = $value->propinsi;
                            $this->jasaKirim = $value->jasa_kirim;
                            $this->noResi = $value->no_resi;
                            $this->status = $value->status;
                            $this->tglKirim = $value->tgl_kirim;
                            $this->tglTerima = $value->tgl_terima;
                            $this->penerima = $value->penerima;
                            $this->fileBuktiKirim = $value->file_bukti_kirim;
                            $this->fileBuktiTerima = $value->file_bukti_terima;
                            $this->idSupplier = $value->id_supplier;
                            $this->kdPti = $value->kdpti;
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

        public function getAlamat()
	{
		return $this->alamat;
	}

	public function getFileBuktiKirim()
	{
		return $this->fileBuktiKirim;
	}

	public function getFileBuktiTerima()
	{
		return $this->fileBuktiTerima;
	}

	public function getIdDetailPaketHibah()
	{
		return $this->idDetailPaketHibah;
	}

	public function getJasaKirim()
	{
		return $this->jasaKirim;
	}

	public function getKodePos()
	{
		return $this->kodePos;
	}

	public function getKota()
	{
		return $this->kota;
	}

	public function getNoResi()
	{
		return $this->noResi;
	}

	public function getPenerima()
	{
		return $this->penerima;
	}

	public function getPropinsi()
	{
		return $this->propinsi;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getTglKirim()
	{
		return $this->tglKirim;
	}

	public function getTglTerima()
	{
		return $this->tglTerima;
	}
        
        public function setId($newVal)
        {
            $this->id = $newVal;
        }

	/**
	 * 
	 * @param newVal
	 */
	public function setAlamat($newVal)
	{
		$this->alamat = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFileBuktiKirim($newVal)
	{
		$this->fileBuktiKirim = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFileBuktiTerima($newVal)
	{
		$this->fileBuktiTerima = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdDetailPaketHibah($newVal)
	{
		$this->idDetailPaketHibah = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setJasaKirim($newVal)
	{
		$this->jasaKirim = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKodePos($newVal)
	{
		$this->kodePos = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKota($newVal)
	{
		$this->kota = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNoResi($newVal)
	{
		$this->noResi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPenerima($newVal)
	{
		$this->penerima = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPropinsi($newVal)
	{
		$this->propinsi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setStatus($newVal)
	{
		$this->status = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTglKirim($newVal)
	{
		$this->tglKirim = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTglTerima($newVal)
	{
		$this->tglTerima = $newVal;
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
            $this->db->from('tbl_kirim');
            $this->db->where($field, $value);
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result() as $value){
                    $this->id = $value->id;
                    $this->alamat = $value->alamat;
                    $this->kodePos = $value->kode_pos;
                    $this->propinsi = $value->propinsi;
                    $this->jasaKirim = $value->jasa_kirim;
                    $this->noResi = $value->no_resi;
                    $this->status = $value->status;
                    $this->tglKirim = $value->tgl_kirim;
                    $this->tglTerima = $value->tgl_terima;
                    $this->penerima = $value->penerima;
                    $this->fileBuktiKirim = $value->file_bukti_kirim;
                    $this->fileBuktiTerima = $value->file_bukti_terima;
                    $this->idSupplier = $value->id_supplier;
                    $this->kdPti = $value->kdpti;
                }
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
            $this->db->select('*');
            $this->db->from('tbl_kirim');

            $this->db->where($related . '.' . $field, $value);
            if ($row == NULL && $segment == NULL) {
                return $this->db->count_all_results();
            } elseif ($row == 0 && $segment == 0) {
                return $this->db->get();
            } else {
                return $this->db->get('', $row, $segment);
            }
	}

	public function insert()
	{
	}

	public function update()
	{
	}

	public function getIdSupplier()
	{
		return $this->idSupplier;
	}

	public function getKdPti()
	{
		return $this->kdPti;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdSupplier($newVal)
	{
		$this->idSupplier = $newVal;
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