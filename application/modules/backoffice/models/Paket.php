<?php

require_once ('Basemodel.php');

//use ;
/**
 * @author siti
 * @version 1.0
 * @created 18-Jun-2017 11:51:18
 */
class Paket extends CI_Model implements BaseModel {

    private $adendum;
    private $fileBuktiKontrak;
    private $id;
    private $namaPaket;
    private $noKontrak;
    private $supplier;
    private $tglKontrak;
    private $tglAkhirKontrak;

    function __construct($id = '') {
        parent::__construct();
        if ($id != '') {
            $sql = "SELECT * FROM tbl_paket WHERE id='" . $id . "'";
            $result = $this->db->query($sql);
            if ($result->num_rows() > 0) {
                foreach ($result->result('array') as $value) {
                    $this->setId($value['id']);
                    $this->setNamaPaket($value['nama_paket']);
                    $this->setSupplier(new Supplier($value['id_supplier']));
                    $this->setNoKontrak($value['no_kontrak']);
                    $this->setTglKontrak($value['tgl_kontrak']);
                    $this->setAdendum($value['adendum']);
                    $this->setFileBuktiKontrak($value['file_bukti_kontrak']);
                    $this->setTglAkhirKontrak($value['tgl_akhir_kontrak']);
                }
            }
        }
    }

    function __destruct() {
        
    }
    
    
    public function getAdendum() {
        return $this->adendum;
    }

    public function getFileBuktiKontrak() {
        return $this->fileBuktiKontrak;
    }

    public function getId() {
        return $this->id;
    }

    public function getNamaPaket() {
        return $this->namaPaket;
    }

    public function getNoKontrak() {
        return $this->noKontrak;
    }

    public function getSupplier() {
        $this->db->select('*');
        $this->db->from('tbl_paket');
        $this->db->where('id', $this->getId());
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $paket = $result->row();
            $this->supplier = new Supplier($paket->id_supplier);
        }
        return $this->supplier;
    }

    public function getTglKontrak() {
        return $this->tglKontrak;
    }

    /**
     * 
     * @param newVal
     */
    public function setAdendum($newVal) {
        $this->adendum = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setFileBuktiKontrak($newVal) {
        $this->fileBuktiKontrak = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setId($newVal) {
        $this->id = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setNamaPaket($newVal) {
        $this->namaPaket = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setNoKontrak($newVal) {
        $this->noKontrak = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setSupplier($newVal) {
        $this->supplier = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setTglKontrak($newVal) {
        $this->tglKontrak = $newVal;
    }

    public function delete() {
        $this->db->delete('tbl_paket', array('id'=>  $this->id));
    }

    /**
     * 
     * @param row
     * @param segment    segment
     */
    public function get($row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('tbl_paket');
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            $this->db->order_by('tgl_kontrak','Desc');
            return $this->db->get();
        } else {
            $this->db->order_by('tgl_kontrak','Desc');
            return $this->db->get('', $row, $segment);
        }
    }

    /**
     * 
     * @param field
     * @param value    value
     */
    public function getBy($field, $value) {
        $this->db->select('*');
        $this->db->from('tbl_paket');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result('array') as $value) {
                $this->setId($value['id']);
                $this->setNamaPaket($value['nama_paket']);
                $this->setSupplier(new Supplier($value['id_supplier']));
                $this->setNoKontrak($value['no_kontrak']);
                $this->setTglKontrak($value['tgl_kontrak']);
                $this->setAdendum($value['adendum']);
                $this->setFileBuktiKontrak($value['file_bukti_kontrak']);
                $this->setTglAkhirKontrak($value['tgl_akhir_kontrak']);
            }
            return TRUE;
        } else {
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
    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        $this->db->select('tbl_paket.*');
        $this->db->from('tbl_paket');
        if ($related == 'tbl_supplier') {
            $this->db->join('tbl_supplier', 'tbl_paket.id_supplier = tbl_supplier.id');
            $this->db->like($related . '.' . $field, $value);
        } elseif ($related == 'tbl_pti'){
            $this->db->join('tbl_detail_paket_hibah', 'tbl_paket.id = tbl_detail_paket_hibah.id_paket');
            $this->db->join('registrasi', 'tbl_detail_paket_hibah.id_registrasi = registrasi.id_registrasi');
            $this->db->join('tbl_pti', 'registrasi.kdpti = tbl_pti.kdpti');
            $this->db->like($related . '.' . $field, $value);
        } elseif ($related == 'registrasi') {
            $this->db->join('tbl_detail_paket_hibah', 'tbl_paket.id = tbl_detail_paket_hibah.id_paket');
            $this->db->join('registrasi', 'tbl_detail_paket_hibah.id_registrasi = registrasi.id_registrasi');
            $this->db->like($related . '.' . $field, $value);
        } elseif($related == 'tbl_paket'){
        	$this->db->where($field, $value);
        }
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == '0' && $segment == '0') {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function insert() {
        $data = array('nama_paket' => $this->namaPaket,
            'id_supplier' => $this->supplier->getId(),
            'no_kontrak' => $this->noKontrak,
            'tgl_kontrak' => $this->tglKontrak,
            'adendum' => $this->adendum,
            'file_bukti_kontrak' => $this->fileBuktiKontrak,
            'tgl_akhir_kontrak' => $this->tglAkhirKontrak);
        $result = $this->db->insert('tbl_paket', $data);

        $this->db->select_max('id');
        $this->db->from('tbl_paket');
        $rec = $this->db->get()->row();
        $this->setId($rec->id);
        return $result;
    }

    public function update() {
        $data = array('nama_paket' => $this->namaPaket,
            'id_supplier' => $this->supplier->getId(),
            'no_kontrak' => $this->noKontrak,
            'tgl_kontrak' => $this->tglKontrak,
            'adendum' => $this->adendum,
            'file_bukti_kontrak' => $this->fileBuktiKontrak,
            'tgl_akhir_kontrak' => $this->tglAkhirKontrak);
        $this->db->where('id', $this->id);
        $this->db->update('tbl_paket', $data);
    }

	public function getTglAkhirKontrak()
	{
		return $this->tglAkhirKontrak;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTglAkhirKontrak($newVal)
	{
		$this->tglAkhirKontrak = $newVal;
	}

        public function getPercentCompleted()
        {
            $this->db->select('a.*');
            $this->db->from('tbl_detail_paket_hibah a');
            $this->db->join('tbl_paket b','a.id_paket = b.id');
            $this->db->where('b.id',  $this->id);
            $result = $this->db->get();
            //$rows = $result->num_rows();
            $volume = 0; $vol_kirim=0; $percentage=0;
            if($result->num_rows()>0){
                foreach ($result->result() as $row){
                    
                    $volume = $volume + $row->volume;
                    $vol_kirim = $vol_kirim + $row->volume_terkirim;
                    
                    //$percentage = $percentage + $item;
                }
                $percentage = ($vol_kirim/$volume) * 100;
            }
            return $percentage;
        }
}

?>