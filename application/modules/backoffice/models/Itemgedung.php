<?php

require_once ('Basemodel.php');

//namespace models;
//use models;
/**
 * @author LENOVO
 * @version 1.0
 * @created 27-May-2020 1:30:26 PM
 */
class ItemGedung extends CI_Model implements BaseModel {

    private $kdGedung;
    private $nmGedung;

    function __construct($id = null) {
        parent::__construct();
        if ($id != null) {
            $this->db->select('*');
            $this->db->from('tbl_item_gedung');
            $this->db->where('kd_gedung', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $this->kdGedung = $row->kd_gedung;
                $this->nmGedung = $row->nm_gedung;
            }
        }
    }

    function __destruct() {
        
    }

    public function getKdGedung() {
        return $this->kdGedung;
    }

    public function getNmGedung() {
        return $this->nmGedung;
    }

    /**
     * 
     * @param newVal
     */
    public function setKdGedung($newVal) {
        $this->kdGedung = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setNmGedung($newVal) {
        $this->nmGedung = $newVal;
    }

    public function delete() {
        
    }

    /**
     * 
     * @param row
     * @param segment    segment
     */
    public function get($row = Null, $segment = Null) {
        
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
        $this->db->select('*');
        $this->db->from('tbl_item_gedung');
        if ($related == '') {
            $this->db->where($field, $value);
        } else {
            $this->db->like($related . '.' . $field, $value);
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
        
    }

    public function search(array $params) {
        $this->db->select("tbl_item_gedung.*");
        $this->db->from("tbl_item_gedung");
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

}

?>