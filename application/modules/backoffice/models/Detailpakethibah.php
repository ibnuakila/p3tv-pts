<?php

require_once ('Basemodel.php');

//use ;
/**
 * @author siti
 * @version 1.0
 * @created 18-Jun-2017 11:51:51
 */
class DetailPaketHibah extends CI_Model implements BaseModel {

    private $berat;
    private $biayaKirim;
    private $hps;
    private $id;
    private $idItem;
    private $idPaket;
    private $idRegistrasi;
    private $merk;
    private $onkir;
    private $pajak;
    private $type;
    private $volume;
    private $kdPti;
    private $kota;
    private $kontrakAdendum;
    private $adendumKe;
    private $noKontrak;
    private $status;
    private $retur;
    private $spesifikasi;
    private $total;

    function __construct($id = '') {
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from('tbl_detail_paket_hibah');
            $this->db->where('id_item', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->setId($value->id);
                    $this->setIdPaket($value->id_paket);
                    $this->setIdItem($value->id_item);
                    $this->setMerk($value->merk);
                    $this->setType($value->type);
                    $this->setSpesifikasi($value->spesifikasi);
                    $this->setVolume($value->volume);
                    $this->setBerat($value->berat);
                    $this->setPajak($value->pajak);
                    $this->setBiayaKirim($value->biaya_kirim);
                    $this->setOnkir($value->onkir);
                    $this->setHps($value->hps);
                    $this->setIdRegistrasi($value->id_registrasi);
                    $this->setKdPti($value->kdpti);
                    $this->setKota($value->kota);
                    $this->setNoKontrak($value->no_kontrak);
                    $this->setStatus($value->status);
                    $this->setRetur($value->retur);
                    $this->setTotal($value->total);
                }
            }
        }
    }

    function __destruct() {
        
    }

    public function getBerat() {
        return $this->berat;
    }

    public function getBiayaKirim() {
        return $this->biayaKirim;
    }

    public function getHps() {
        return $this->hps;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdItem() {
        return $this->idItem;
    }

    public function getIdPaket() {
        return $this->idPaket;
    }

    public function getIdRegistrasi() {
        return $this->idRegistrasi;
    }

    public function getMerk() {
        return $this->merk;
    }

    public function getOnkir() {
        return $this->onkir;
    }

    public function getPajak() {
        return $this->pajak;
    }

    public function getType() {
        return $this->type;
    }

    public function getVolume() {
        return $this->volume;
    }

    /**
     * 
     * @param newVal
     */
    public function setBerat($newVal) {
        $this->berat = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setBiayaKirim($newVal) {
        $this->biayaKirim = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setHps($newVal) {
        $this->hps = $newVal;
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
    public function setIdItem($newVal) {
        $this->idItem = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdPaket($newVal) {
        $this->idPaket = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdRegistrasi($newVal) {
        $this->idRegistrasi = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setMerk($newVal) {
        $this->merk = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setOnkir($newVal) {
        $this->onkir = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setPajak($newVal) {
        $this->pajak = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setType($newVal) {
        $this->type = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setVolume($newVal) {
        $this->volume = $newVal;
    }

    public function delete() {
        $this->db->delete('tbl_detail_paket_hibah', array('id_paket' => $this->idPaket));
    }

    /**
     * 
     * @param row
     * @param segment    segment
     */
    public function get($row = Null, $segment = Null) {
        $list = new ArrayObject();
        $this->db->select('*');
        $this->db->from('tbl_detail_paket_hibah');

        $result = '';
        if ($row == '' && $segment == '') {
            $this->db->order_by('id_paket', 'asc');
            $result = $this->db->get('');
        } else {
            $result = $this->db->get('', $row, $segment);
        }
        foreach ($result->result('array') as $row) {
            $obj = new DetailPaketHibah($row['id']);
            $list->append($obj);
        }
        return $list;
    }

    /**
     * 
     * @param field
     * @param value    value
     */
    public function getBy($field, $value) {
        $this->db->select('*');
        $this->db->from('tbl_detail_paket_hibah');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            //foreach ($result->result() as $value) {
                foreach ($result->result() as $value) {
                    $this->setId($value->id);
                    $this->setIdPaket($value->id_paket);
                    $this->setIdItem($value->id_item);
                    $this->setMerk($value->merk);
                    $this->setType($value->type);
                    $this->setVolume($value->volume);
                    $this->setBerat($value->berat);
                    $this->setPajak($value->pajak);
                    $this->setBiayaKirim($value->biaya_kirim);
                    $this->setOnkir($value->onkir);
                    $this->setHps($value->hps);
                    $this->setIdRegistrasi($value->id_registrasi);
                    $this->setKdPti($value->kdpti);
                    $this->setKota($value->kota);
                    $this->setNoKontrak($value->no_kontrak);
                }
            //}
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
        $this->db->select('*');
        $this->db->from('tbl_detail_paket_hibah');
        /* if($this->idPaket!=''){
          $this->db->where('id_paket', $this->idPaket);
          } */
        //$this->db->join('adhjoin','tbl_detail_paket_hibah.id_registrasi = adhjoin.id_registrasi');
        $this->db->like($related . '.' . $field, $value);
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function insert() {
        $data = array('id_paket' => $this->getIdPaket(),
            'id_item' => $this->getIdItem(),
            'merk' => $this->getMerk(),
            'type' => $this->getType(),
            'spesifikasi' => $this->getSpesifikasi(),
            'volume' => $this->getVolume(),
            'berat' => $this->getBerat(),
            'pajak' => $this->getPajak(),
            'biaya_kirim' => $this->getBiayaKirim(),
            'onkir' => $this->getOnkir(),
            'hps' => $this->getHps(),
            'id_registrasi' => $this->getIdRegistrasi(),
            'kdpti' => $this->getKdPti(),
            'kota' => $this->getKota(),
            'adendum_ke' => $this->getAdendumKe(),
            'no_kontrak' => $this->getNoKontrak(),
            'status' => $this->getStatus(),
            'retur' => $this->getRetur(),
            'total' => $this->getTotal());
        $result = $this->db->insert('tbl_detail_paket_hibah', $data);
        $this->db->select_max('id');
        $this->db->from('tbl_detail_paket_hibah');
        $rec = $this->db->get()->row();
        $this->setId($rec->id);
        return $result;
    }

    public function update() {
        $data = array('id_paket' => $this->getIdPaket(),
            'id_item' => $this->getIdItem(),
            'merk' => $this->getMerk(),
            'type' => $this->getType(),
            'spesifikasi' => $this->getSpesifikasi(),
            'volume' => $this->getVolume(),
            'berat' => $this->getBerat(),
            'pajak' => $this->getPajak(),
            'biaya_kirim' => $this->getBiayaKirim(),
            'onkir' => $this->getOnkir(),
            'hps' => $this->getHps(),
            'id_registrasi' => $this->getIdRegistrasi(),
            'kdpti' => $this->getKdPti(),
            'kota' => $this->getKota(),
            'adendum_ke' => $this->getAdendumKe(),
            'no_kontrak' => $this->getNoKontrak(),
            'status' => $this->getStatus(),
            'retur' => $this->getRetur(),
            'total' => $this->getTotal());
        $this->db->where('id', $this->getId());
        return $this->db->update('tbl_detail_paket_hibah', $data);
    }

    public function getKdPti() {
        return $this->kdPti;
    }

    /**
     * 
     * @param newVal
     */
    public function setKdPti($newVal) {
        $this->kdPti = $newVal;
    }

    public function getKota() {
        return $this->kota;
    }

    /**
     * 
     * @param newVal
     */
    public function setKota($newVal) {
        $this->kota = $newVal;
    }

    public function getKontrakAdendum() {
        return $this->kontrakAdendum;
    }

    /**
     * 
     * @param newVal
     */
    public function setKontrakAdendum($newVal) {
        $this->kontrakAdendum = $newVal;
    }

    public function getAdendumKe() {
        return $this->adendumKe;
    }

    public function getNoKontrak() {
        return $this->noKontrak;
    }

    public function getStatus() {
        return $this->status;
    }

    /**
     * 
     * @param newVal
     */
    public function setAdendumKe($newVal) {
        $this->adendumKe = $newVal;
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
    public function setStatus($newVal) {
        $this->status = $newVal;
    }

    public function getRetur() {
        return $this->retur;
    }

    public function getSpesifikasi() {
        return $this->spesifikasi;
    }

    /**
     * 
     * @param newVal
     */
    public function setRetur($newVal) {
        $this->retur = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setSpesifikasi($newVal) {
        $this->spesifikasi = $newVal;
    }

    public function getRekap($row = '', $segment = '') {
        $this->db->select('a.*, count(b.id_registrasi) as jml_pts, sum(b.subtotal) as total, b.file_rab, b.file_design');
        $this->db->from('registrasi a');
        $this->db->join('tbl_item_hibah b', 'a.id_registrasi = b.id_registrasi', 'RIGHT');
        //$this->db->join('tbl_presentasi b', 'a.id_registrasi = b.id_registrasi', 'RIGHT');
        $this->db->group_by('a.id_registrasi');
        //$this->db->order_by('b.wilayah');
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function getTotal() {
        return $this->total;
    }

    /**
     * 
     * @param newVal
     */
    public function setTotal($newVal) {
        $this->total = $newVal;
    }

    public function getPercentCompleted() {
        $this->db->select('a.*');
        $this->db->from('tbl_detail_paket_hibah a');
        //$this->db->join('tbl_paket b','a.no_kontrak = b.no_kontrak');
        $this->db->where('a.id_registrasi', $this->idRegistrasi);
        $result = $this->db->get();
        //$rows = $result->num_rows();
        $volume = 0;
        $vol_kirim = 0;
        $percentage = 0;
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {

                $volume = $volume + $row->volume;
                $vol_kirim = $vol_kirim + $row->volume_terkirim;

                //$percentage = $percentage + $item;
            }
            $percentage = ($vol_kirim / $volume) * 100;
        }
        return $percentage;
    }

}
