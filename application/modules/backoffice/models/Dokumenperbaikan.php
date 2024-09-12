<?php

require_once ('Basemodel.php');

//use ;
/**
 * @author LENOVO
 * @version 1.0
 * @created 28-Apr-2020 3:42:32 PM
 */
class DokumenPerbaikan extends CI_Model implements BaseModel {

    private $formName;
    private $idForm;
    private $jnsUsulan;
    private $periode;
    private $skema;

    function __construct($params=null) {
        parent::__construct();
        if (is_array($params)) {
            $this->db->select('*');
            $this->db->from('dokumen_perbaikan');
            $this->db->where('id_form', $params['id_form']);
            $this->db->where('periode', $params['periode']);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->idForm = $value->id_form;
                    $this->formName = $value->form_name;
                    $this->jnsUsulan = $value->jns_usulan;
                    $this->skema = $value->skema;
                    $this->periode = $value->periode;
                }
            }
        }
    }

    function __destruct() {
        
    }

    public function getFormName() {
        return $this->formName;
    }

    public function getIdForm() {
        return $this->idForm;
    }

    public function getJnsUsulan() {
        return $this->jnsUsulan;
    }

    public function getPeriode() {
        return $this->periode;
    }

    public function getSkema() {
        return $this->skema;
    }

    /**
     * 
     * @param newVal
     */
    public function setFormName($newVal) {
        $this->formName = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdForm($newVal) {
        $this->idForm = $newVal;
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
    public function setSkema($newVal) {
        $this->skema = $newVal;
    }

    public function delete() {
        
    }

    /**
     * 
     * @param row
     * @param segment    segment
     */
    public function get($row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('dokumen_perbaikan');
        $this->db->where('skema', $this->skema);
        $this->db->where('periode', $this->periode);
        $this->db->where('jns_usulan', $this->jnsUsulan);

        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == '0' && $segment == '0') {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    /**
     * 
     * @param field
     * @param value    value
     */
    public function getBy($field, $value) {
        
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
        
    }

    public function insert() {
        
    }

    public function update() {
        
    }
}

?>