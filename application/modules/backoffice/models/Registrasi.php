<?php

require_once ('Account.php');
require_once ('Basemodel.php');
require_once ('Dokumenregistrasi.php');
require_once ('Statusregistrasi.php');
require_once ('Laporanpdpt.php');
require_once ('Usulanperubahan.php');

/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:40:22
 */
class Registrasi extends CI_Model implements BaseModel {

    private $idAccount;
    private $idRegistrasi;
    private $idStatusRegistrasi;
    private $jnsUsulan;
    private $periode;
    private $revisi;
    private $tglRegistrasi;
    private $noSurat;
    private $tglSurat;
    private $objAccount;
    private $objDokumenRegistrasi;
    private $objStatusRegistrasi;
    private $objPti;
    private $objVerifikasi;
    private $objProses;
    private $kdPti;
    private $penugasan;
    private $objYayasan;
    private $objLaporanPdpt;
    private $objUsulanPerubahan;
    private $schema;
    private $ubahPt;
    private $rencanaUbahPt;
    private $revisiProposal;

    const table = 'registrasi';

    function __construct($id = NULL) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from('registrasi');
            $this->db->where('id_registrasi', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->setIdRegistrasi($value->id_registrasi);
                    //$this->setIdAccount($value->id_account);
                    $this->setIdStatusRegistrasi($value->id_status_registrasi);
                    $this->setTglRegistrasi($value->tgl_registrasi);
                    $this->setNoSurat($value->nosurat);
                    $this->setTglSurat($value->tgl_surat);
                    $this->setSchema($value->skema);
                    $this->setPeriode($value->periode);
                    $this->setRevisi($value->revisi);
                    $this->setKdPti($value->kdpti);
                    $this->setPenugasan($value->penugasan);
                    $this->setUbahPt($value->ubah_pt);
                    $this->setRencanaUbahPt($value->rencana_ubah_pt);
                    $this->setJnsUsulan($value->jns_usulan);
                    $this->setRevisiProposal($value->revisi_proposal);
                }
            }
        }
    }

    function __destruct() {
        
    }
    
    public function setRevisiProposal($value){
        $this->revisiProposal = $value;
    }
    
    public function getRevisiProposal(){
        return $this->revisiProposal;
    }

    public function getAccount() {
        $this->db->select('*');
        $this->db->from('user_pengusul account');
        $this->db->where('id', $this->idAccount);
        $result = $this->db->get();
        $this->objAccount = NULL;
        if ($result->num_rows() > 0) {

            foreach ($result->result() as $value) {
                $this->objAccount = new Account($value->id_account);
            }
        }
        return $this->objAccount;
    }

    public function getVerifikasi() {
        $this->db->select('*');
        $this->db->from('verifikasi');
        $this->db->where('id_registrasi', $this->idRegistrasi);
        $result = $this->db->get();
        $this->objVerifikasi = NULL;
        if ($result->num_rows() > 0) {

            foreach ($result->result() as $value) {
                $this->objVerifikasi = new Verifikasi($value->id_registrasi);
            }
        }
        return $this->objVerifikasi;
    }

    public function getLaporanPdpt() {
        $this->db->select('*');
        $this->db->from('laporan_pdpt');
        $this->db->where('kdpti', $this->kdPti);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $this->objLaporanPdpt = new ArrayObject();
            foreach ($result->result() as $value) {
                $obj_lap = new LaporanPdpt($value->kdpti, $value->tahun_lapor);
                $this->objLaporanPdpt->append($obj_lap);
            }
        }
        return $this->objLaporanPdpt;
    }

    public function getUsulanPerubahan() {
        $this->db->select('*');
        $this->db->from('usulan_perubahan');
        $this->db->where('kdpti', $this->kdPti);
        $result = $this->db->get();
        $this->objUsulanPerubahan = NULL;
        if ($result->num_rows() > 0) {

            foreach ($result->result() as $value) {
                $this->objUsulanPerubahan = new UsulanPerubahan($value->kdpti);
            }
        }
        return $this->objUsulanPerubahan;
    }

    public function getProses() {
        $this->db->select('p.*');
        $this->db->from('registrasi r');
        $this->db->join('proses_registrasi pr', 'r.id_registrasi = pr.id_registrasi');
        $this->db->join('proses p', 'pr.id_proses = p.id_proses');
        $this->db->where('r.id_registrasi', $this->idRegistrasi);
        $result = $this->db->get();
        $this->objProses = new ArrayObject();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                $Proses = new Proses($value->id_proses);
                $this->objProses->append($Proses);
            }
        }
        return $this->objProses;
    }

    public function getProses2() {
        $this->db->select('p.*');
        $this->db->from('registrasi r');
        $this->db->join('proses_registrasi pr', 'r.id_registrasi = pr.id_registrasi');
        $this->db->join('proses p', 'pr.id_proses = p.id_proses');
        $this->db->where('r.id_registrasi', $this->idRegistrasi);
        $this->db->where('p.id_jns_evaluasi', '2');
        $result = $this->db->get();
        /*$this->objProses = new ArrayObject();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                $Proses = new Proses($value->id_proses);
                $this->objProses->append($Proses);
            }
        }*/
        return $result;
    }

    public function getDokumenRegistrasi() {
        
    }

    public function getIdAccount() {
        return $this->idAccount;
    }

    public function getIdRegistrasi() {
        return $this->idRegistrasi;
    }

    public function getIdStatusRegistrasi() {
        return $this->idStatusRegistrasi;
    }

    public function getJnsUsulan() {
        return $this->jnsUsulan;
    }

    public function getPeriode() {
        return $this->periode;
    }

    public function getRevisi() {
        return $this->revisi;
    }
    
    public function getNoSurat() {
        return $this->noSurat;
    }
    
    public function getTglSurat() {
        return $this->tglSurat;
    }

    public function getStatusRegistrasi() {
        $this->db->select('*');
        $this->db->from('status_registrasi');
        $this->db->where('id_status_registrasi', $this->idStatusRegistrasi);
        $result = $this->db->get();
        //$this->objStatusRegistrasi = NULL;
        $this->objStatusRegistrasi = new StatusRegistrasi();
        if ($result->num_rows() > 0) {

            foreach ($result->result() as $value) {
                $this->objStatusRegistrasi->setIdStatusRegistrasi($value->id_status_registrasi);
                $this->objStatusRegistrasi->setNamaStatus($value->nama_status);
            }
        }
        return $this->objStatusRegistrasi;
    }

    public function getPenyelenggara() {
        $this->db->select('*');
        $this->db->from('tbl_badan_penyelenggara');
        $this->db->where('kdpti', $this->kdPti);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $obj) {
                $this->objYayasan = new BadanPenyelenggara($obj->kdpti);
            }
        }
        return $this->objYayasan;
    }

    public function getTglRegistrasi() {
        return $this->tglRegistrasi;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdAccount($newVal) {
        $this->idAccount = $newVal;
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
    public function setIdStatusRegistrasi($newVal) {
        $this->idStatusRegistrasi = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setJnsUsulan($newVal) {
        $this->jnsUsulan = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setPeriode($newVal) {
        $this->periode = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setRevisi($newVal) {
        $this->revisi = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setTglRegistrasi($newVal) {
        $this->tglRegistrasi = $newVal;
    }
    
    public function setNoSurat($newVal) {
        $this->noSurat = $newVal;
    }

    public function setTglSurat($newVal) {
        $this->tglSurat = $newVal;
    }
    public function delete() {
        
    }

    /**
     * 
     * @param row
     * @param segment
     */
    public function get($row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('registrasi');
        if ($this->idStatusRegistrasi != '') {
            $this->db->where('id_status_registrasi =', $this->idStatusRegistrasi);
        }
        if ($this->periode != '') {
            $this->db->where_in('periode', $this->periode);
        }
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    /**
     * 
     * @param field
     * @param value
     */
    public function getBy($field, $value) {
        $this->db->select('*');
        $this->db->from('registrasi');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                $this->setIdRegistrasi($value->id_registrasi);
                $this->setKdPti($value->kdpti);
                $this->setIdStatusRegistrasi($value->id_status_registrasi);
                $this->setTglRegistrasi($value->tgl_registrasi);
                //$this->setJnsUsulan($value->jns_usulan);
                $this->setPeriode($value->periode);
                $this->setRevisi($value->revisi);
                $this->setPenugasan($value->penugasan);
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
     * @param value
     */
    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        $this->db->select('registrasi.*');
        $this->db->from('registrasi');
        //$this->db->join('account','registrasi.id_account = account.id_account');
        if ($field == 'nmpti') {
            $this->db->join('tbl_pti', 'registrasi.kdpti = tbl_pti.kdpti');
        } elseif ($field == 'nama_penyelenggara') {
            $this->db->join('tbl_badan_penyelenggara', 'registrasi.kdpti = tbl_badan_penyelenggara.kdpti');
        } elseif ($field == 'nama_status') {
            $this->db->join('status_registrasi', 'registrasi.id_status_registrasi = status_registrasi.id_status_registrasi');
        }

        $this->db->like($related . '.' . $field, $value);
        if ($this->idStatusRegistrasi != '') {
            $this->db->where('registrasi.id_status_registrasi <>', $this->idStatusRegistrasi);
        }
        if ($this->penugasan != '') {
            $this->db->where('registrasi.penugasan <', $this->penugasan);
            $this->db->where_in('registrasi.id_status_registrasi', array('2', '3', '11'));
        }
        if ($this->periode != '') {
            $this->db->where_in('periode', $this->periode);
        }
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function insert() {
        
    }

    public function update() {
        $data = array('id_status_registrasi' => $this->idStatusRegistrasi,
            'penugasan' => $this->penugasan,
            'revisi_proposal' => $this->revisiProposal
        );
        $this->db->where('id_registrasi', $this->idRegistrasi);
        return $this->db->update('registrasi', $data);
    }

    public function getPti() {
        $this->db->select('*');
        $this->db->from('tbl_pti');
        $this->db->where('kdpti', trim($this->kdPti));
        $result = $this->db->get();
        $this->objPti = NULL;
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                $this->objPti = new Pti($value->kdpti);
            }
        }
        return $this->objPti;
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

    public function getPenugasan() {
        return $this->penugasan;
    }

    /**
     * 
     * @param newVal
     */
    public function setPenugasan($newVal) {
        $this->penugasan = $newVal;
    }

    public function getByPenugasan($row = Null, $segment = Null) {
        $this->db->select('registrasi.*');
        $this->db->from('registrasi');
        /* $this->db->join('account','registrasi.id_account = account.id_account');
          $this->db->join('yayasan','account.id_yayasan = yayasan.id_yayasan'); */
        $this->db->join('tbl_pti', 'registrasi.kdpti = tbl_pti.kdpti');
        $this->db->where('registrasi.penugasan <', '2');
        $this->db->where_in('registrasi.id_status_registrasi', array('2', '3', '11'));
        $this->db->where('registrasi.periode', $this->periode);
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function read(array $params) {
        $this->db->select('*');
        $this->db->from('registrasi');

        if ($params['row'] == NULL && $params['segment'] == NULL) {
            return $this->db->count_all_results();
        } elseif ($params['row'] == 0 && $params['segment'] == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $params['row'], $params['segment']);
        }
    }

    /**
     * 
     * @param params
     */
    public function search(array $params) {
        $this->db->select("registrasi.*");
        $this->db->from("registrasi");
        $row = '';
        $segment = '';
        $count = FALSE;
        foreach ($params as $key => $value) {
            if ($key == 'join') {
                foreach ($value as $key => $value) {
                    $this->db->join($key, $value);
                }
            }
            if ($key == 'field') {
                foreach ($value as $key => $value) {
                    if (is_array($value)) {
                        $this->db->where_in($key, ($value));
                    } else {
                        if (is_numeric($value)) {
                            $this->db->where($key, ($value));
                        } else {
                            $this->db->like('lower(' . $key . ')', strtolower($value));
                        }
                    }
                }
            }
            if ($key == 'paging') {
                foreach ($value as $key => $value) {
                    if ($key == 'row') {
                        $row = $value;
                    } else {
                        $segment = $value;
                    }
                }
            }
            if ($key == 'count') {
                if (count($value) == 1) {
                    $count = TRUE;
                }
            }
        }
        if ($count) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            $this->db->order_by('tgl_registrasi', 'Desc');
            return $this->db->get();
        } else {
            $this->db->order_by('tgl_registrasi', 'Desc');
            return $this->db->get('', $row, $segment);
        }
    }
    
    public function getResult($params) {
        $this->db->select(self::table.'.*');
        $this->db->from(self::table);
        
        $count = false;
        foreach ($params as $key => $value) {
            if($key=='join'){
                foreach ($value as $key => $sub_value){
                    foreach ($sub_value as $operator => $value) {                        
                        $this->db->join($key, $value, $operator);
                    }
                    
                }
            }
            if($key=='field'){
                foreach ($value as $key => $sub_value) {
                    foreach ($sub_value as $operator => $item){
                        if($operator=='IN'){
                            $this->db->where_in($key, $item);
                        }elseif($operator=='NOT IN'){
                            $this->db->where_not_in($key, $item);
                        }elseif($operator=='LIKE'){
                            $this->db->like('lower('.$key.')', strtolower($item));
                        } elseif ($operator == 'BETWEEN'){
                            $where = $key . " ".$operator." '".$item[0]."' AND '".$item[1]."'";
                            $this->db->where($where);
                        }else{
                            $this->db->where($key.$operator, $item);
                        }
                    }
                    
                }
            }
            
            if($key=='paging'){
                foreach ($value as $key => $value) {
                    if($key=='row'){
                        $row = $value;
                    }else{
                        $segment = $value;
                    }
                }
            }
            if($key=='count'){
                $count = $value;           
            }
            if($key=='order'){
                foreach ($value as $key => $value) {
                    $this->db->order_by($key, $value);
                }                
            }
        }
        if($count){
            return $this->db->count_all_results();
        }elseif($row==0 && $segment==0){            
            return $this->db->get();
        }else{            
            return $this->db->get('',$row,$segment);
        }
    }


    public function getSchema() {
        return $this->schema;
    }

    /**
     * 
     * @param newVal
     */
    public function setSchema($newVal) {
        $this->schema = $newVal;
    }

    public function setUbahPt($newVal) {
        $this->ubahPt = $newVal;
    }

    public function getUbahPt() {
        return $this->ubahPt;
    }

    public function setRencanaUbahPt($newVal) {
        $this->rencanaUbahPt = $newVal;
    }

    public function getRencanaUbahPt() {
        return $this->rencanaUbahPt;
    }

}

?>