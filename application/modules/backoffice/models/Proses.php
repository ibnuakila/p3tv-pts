<?php

require_once ('Evaluasiproses.php');
require_once ('Basemodel.php');
require_once ('Prosesregistrasi.php');
require_once ('Statusproses.php');

/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:41:36
 */
class Proses extends CI_Model implements BaseModel {

    private $idEvaluator;
    private $idProses;
    private $idStatusProses;
    private $keterangan;
    private $revisi;
    private $tglExpire;
    private $tglKirim;
    private $tglTerima;
    private $typeEvaluator;
    private $objEvaluasiProses;
    private $objProsesRegistrasi;
    private $objStatusProses;
    private $objRegistrasi;
    private $batch;
    private $objEvaluator;
    private $periode;
    private $idJnsEvaluasi;
    const table = 'proses';

    function __construct($id = NULL) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from('proses');
            $this->db->where('id_proses', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->setIdProses($value->id_proses);
                    $this->setIdEvaluator($value->id_evaluator);
                    $this->setTypeEvaluator($value->type_evaluator);
                    $this->setIdStatusProses($value->id_status_proses);
                    $this->setTglKirim($value->tgl_kirim);
                    $this->setTglExpire($value->tgl_expire);
                    $this->setTglTerima($value->tgl_terima);
                    $this->setIdJnsEvaluasi($value->id_jns_evaluasi);
                    $this->setRevisi($value->revisi);
                    $this->setBatch($value->batch);
                }
            }
        }
    }

    function __destruct() {
        
    }

    public function getEvaluasi() {
        $this->db->select('evaluasi.*');
        $this->db->from('evaluasi');
        $this->db->join('evaluasi_proses', 'evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
        $this->db->join('proses', 'evaluasi_proses.id_proses = proses.id_proses');
        $this->db->where('proses.id_proses', $this->idProses);
        $result = $this->db->get();
        $this->objEvaluasiProses = null;
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $obj) {
                $this->objEvaluasiProses = new Evaluasi($obj->id_evaluasi);
            }
        }
        return $this->objEvaluasiProses;
    }

    public function getIdEvaluator() {
        return $this->idEvaluator;
    }

    public function getIdProses() {
        return $this->idProses;
    }

    public function getIdStatusProses() {
        return $this->idStatusProses;
    }

    public function getKeterangan() {
        return $this->keterangan;
    }

    public function getRegistrasi() {
        $this->db->select('registrasi.*');
        $this->db->from('registrasi');
        $this->db->join('proses_registrasi', 'registrasi.id_registrasi = proses_registrasi.id_registrasi');
        $this->db->join('proses', 'proses_registrasi.id_proses = proses.id_proses');
        $this->db->where('proses_registrasi.id_proses', $this->idProses);
        $result = $this->db->get();
        //$this->objRegistrasi = null;
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $obj) {
                $this->objRegistrasi = new Registrasi($obj->id_registrasi);
            }
        }
        return $this->objRegistrasi;
    }

    public function getRevisi() {
        return $this->revisi;
    }

    public function getStatusProses() {
        $this->db->select('status_proses.*');
        $this->db->from('status_proses');
        $this->db->where('id_status_proses', $this->idStatusProses);
        $result = $this->db->get();
        $this->objStatusProses = NULL;
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $obj) {
                $this->objStatusProses = new StatusProses($obj->id_status_proses);
            }
        }
        return $this->objStatusProses;
    }

    public function getEvaluator() {
        $this->db->select('evaluator.*');
        $this->db->from('evaluator');
        //$this->db->join('evaluator_evaluasi','evaluator.id_evaluator = evaluator_evaluasi.id_evaluator');
        //$this->db->join('evaluasi','evaluator_evaluasi.id_evaluasi = evaluator_evaluasi.id_evaluasi');
        $this->db->where('evaluator.id_evaluator', $this->idEvaluator);
        $result = $this->db->get();
        $this->objEvaluator = null;
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                $this->objEvaluator = new Evaluator($value->id_evaluator);
            }
        }
        return $this->objEvaluator;
    }

    public function getTglExpire() {
        return $this->tglExpire;
    }

    public function getTglKirim() {
        return $this->tglKirim;
    }

    public function getTglTerima() {
        return $this->tglTerima;
    }

    public function getTypeEvaluator() {
        return $this->typeEvaluator;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdEvaluator($newVal) {
        $this->idEvaluator = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdProses($newVal) {
        $this->idProses = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdStatusProses($newVal) {
        $this->idStatusProses = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setKeterangan($newVal) {
        $this->keterangan = $newVal;
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
    public function setTglExpire($newVal) {
        $this->tglExpire = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setTglKirim($newVal) {
        $this->tglKirim = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setTglTerima($newVal) {
        $this->tglTerima = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setTypeEvaluator($newVal) {
        $this->typeEvaluator = $newVal;
    }

    public function delete() {
        $this->db->delete('proses', array('id_proses' => $this->idProses));
    }

    /**
     * 
     * @param row
     * @param segment
     */
    public function get($row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('proses');
        $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
        $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
        if ($this->idEvaluator != '') {
            $this->db->join('evaluator', 'proses.id_evaluator = evaluator.id_evaluator');
            $this->db->where('proses.id_evaluator', $this->idEvaluator);
            $this->db->where('proses.id_status_proses <>', '3');
        }
        if ($this->periode != '') {

            $this->db->where('registrasi.periode', $this->periode);
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
        $this->db->from('proses');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                $this->setIdProses($value->id_proses);
                $this->setIdEvaluator($value->id_evaluator);
                $this->setTypeEvaluator($value->type_evaluator);
                $this->setIdStatusProses($value->id_status_proses);
                $this->setTglKirim($value->tgl_kirim);
                $this->setTglExpire($value->tgl_expire);
                $this->setTglTerima($value->tgl_terima);
                $this->setIdJnsEvaluasi($value->id_jns_evaluasi);
                $this->setRevisi($value->revisi);
                $this->setBatch($value->batch);
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
        $this->db->select('*');
        $this->db->from('proses');
        if ($related == 'registrasi') {
            $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
            $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
        } elseif ($related == 'pti') {
            $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
            $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
            $this->db->join('tbl_pti', 'registrasi.kdpti = tbl_pti.kdpti');
        } elseif ($related == 'status_proses') {
            $this->db->join('status_proses', 'proses.id_status_proses = status_proses.id_status_proses');
        } elseif ($related == 'evaluator') {
            $this->db->join('evaluator', 'proses.id_evaluator = evaluator.id_evaluator');
        } elseif ($related == 'tbl_badan_penyelenggara') {
            $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
            $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
            $this->db->join('tbl_badan_penyelenggara', 'registrasi.kdpti = tbl_badan_penyelenggara.kdpti');
        }
        if ($this->idEvaluator != '') {
            $this->db->where('id_evaluator', $this->idEvaluator);
            $this->db->where('proses.id_status_proses <>', '3');
        }

        $this->db->like($related . '.' . $field, $value);
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function getRecordProcess($id_registrasi) {
        $this->db->select('proses.*');
        $this->db->from('proses');

        $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
        $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');

        $this->db->where('registrasi.id_registrasi', $id_registrasi);
        $this->db->where('id_evaluator', $this->idEvaluator);
        //$this->db->where('proses.id_status_proses <>','3');

        return $this->db->get();
    }

    public function insert() {
        $data = array('id_evaluator' => $this->idEvaluator,
            'type_evaluator' => $this->typeEvaluator,
            'tgl_kirim' => $this->tglKirim,
            'tgl_terima' => $this->tglTerima,
            'tgl_expire' => $this->tglExpire,
            'id_status_proses' => $this->idStatusProses,
            'id_jns_evaluasi' => $this->idJnsEvaluasi,
            'revisi' => $this->revisi,
            'batch' => $this->batch
        );
        $ret = $this->db->insert('proses', $data);

        $this->db->select_max('id_proses');
        $res = $this->db->get('proses');
        foreach ($res->result() as $value) {
            $this->setIdProses($value->id_proses);
        }
        return $ret;
    }

    public function update() {
        $data = array('id_evaluator' => $this->idEvaluator,
            'type_evaluator' => $this->typeEvaluator,
            'tgl_kirim' => $this->tglKirim,
            'tgl_terima' => $this->tglTerima,
            'tgl_expire' => $this->tglExpire,
            'id_status_proses' => $this->idStatusProses,
            'id_jns_evaluasi' => $this->idJnsEvaluasi,
            'revisi' => $this->revisi,
            'batch' => $this->batch
        );
        $this->db->where('id_proses', $this->idProses);
        return $this->db->update('proses', $data);
    }

    public function getBatch() {
        return $this->batch;
    }

    /**
     * 
     * @param newVal
     */
    public function setBatch($newVal) {
        $this->batch = $newVal;
    }

    public function getPeriode() {
        return $this->periode;
    }

    /**
     * 
     * @param newVal
     */
    public function setPeriode($newVal) {
        $this->periode = $newVal;
    }

    public function getIdJnsEvaluasi() {
        return $this->idJnsEvaluasi;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdJnsEvaluasi($newVal) {
        $this->idJnsEvaluasi = $newVal;
    }

    public function isExist($id_registrasi) {
        $this->db->select('proses.*');
        $this->db->from('proses');
        $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
        $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
        $this->db->where('registrasi.id_registrasi', $id_registrasi);
        $this->db->where('id_evaluator', $this->idEvaluator);
        $this->db->where('id_jns_evaluasi', $this->idJnsEvaluasi);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function search(array $params) {
        $this->db->select('proses.*');
        $this->db->from('proses');
        $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
        $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
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
            return $this->db->get();
        } else {
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
}

?>