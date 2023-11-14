<?php

require_once ('Basemodel.php');

//namespace models;
//use models;
/**
 * @author LENOVO
 * @version 1.0
 * @created 27-May-2020 11:20:19 AM
 */
class ItemSubKategori extends CI_Model implements BaseModel {

    private $kdSubKategori;
    private $nmSubKategori;
    const table = 'tbl_item_sub2kategori';
    
    function __construct($id = null) {
        parent::__construct();
        if ($id != null) {
            $this->db->select('*');
            $this->db->from('tbl_item_sub2kategori');
            $this->db->where('kd_sub2_kategori', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $this->kdSubKategori = $row->kd_sub2_kategori;
                $this->nmSubKategori = $row->nm_sub2_kategori;
            }
        }
    }

    function __destruct() {
        
    }

    public function getKdSubKategori() {
        return $this->kdSubKategori;
    }

    public function getNmSubKategori() {
        return $this->nmSubKategori;
    }

    /**
     * 
     * @param newVal
     */
    public function setKdSubKategori($newVal) {
        $this->kdSubKategori = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setNmSubKategori($newVal) {
        $this->nmSubKategori = $newVal;
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
        $this->db->from('tbl_item_sub2kategori');

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
     * @param value    value
     */
    public function getBy($field, $value) {
        $this->db->select('*');
        $this->db->from('tbl_item_sub2kategori');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $row = $result->row();
            $this->kdSubKategori = $row->kd_sub2_kategori;
            $this->nmSubKategori = $row->nm_sub2_kategori;
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
        $this->db->from('tbl_item_sub2kategori');  
        if($related==''){
            $this->db->where($field, $value);
        }else{
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