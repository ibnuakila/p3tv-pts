<?php

require_once ('Basemodel.php');

//namespace models;
//use models;
/**
 * @author LENOVO
 * @version 1.0
 * @created 27-May-2020 11:20:26 AM
 */
class ItemBarang extends CI_Model implements BaseModel {

    private $barang;
    private $berat;
    private $harga;
    private $idItem;
    private $kdBarang;
    private $noBarang;
    private $skema;
    private $spesifikasi;
    const table = 'tbl_item_barang';
    
    function __construct($params = null) {
        parent::__construct();
        if (is_array($params)) {
            $this->db->select('*');
            $this->db->from('tbl_item_barang');
            $this->db->where('id_item', $params['id_item']);
            $this->db->where('periode', $params['periode']);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $this->barang = $row->barang;
                $this->berat = $row->berat;
                $this->harga = $row->harga;
                $this->idItem = $row->id_item;
                $this->kdBarang = $row->kd_barang;
                $this->noBarang = $row->no_barang;
                $this->skema = $row->skema;
                $this->spesifikasi = $row->spesifikasi;
            }
        }
    }

    function __destruct() {
        
    }

    public function getBarang() {
        return $this->barang;
    }

    public function getBerat() {
        return $this->berat;
    }

    public function getHarga() {
        return $this->harga;
    }

    public function getIdItem() {
        return $this->idItem;
    }

    public function getKdBarang() {
        return $this->kdBarang;
    }

    public function getNoBarang() {
        return $this->noBarang;
    }

    public function getSkema() {
        return $this->skema;
    }

    public function getSpesifikasi() {
        return $this->spesifikasi;
    }

    /**
     * 
     * @param newVal
     */
    public function setBarang($newVal) {
        $this->barang = $newVal;
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
    public function setHarga($newVal) {
        $this->harga = $newVal;
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
    public function setKdBarang($newVal) {
        $this->kdBarang = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setNoBarang($newVal) {
        $this->noBarang = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setSkema($newVal) {
        $this->skema = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setSpesifikasi($newVal) {
        $this->spesifikasi = $newVal;
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
        $this->db->from('tbl_item_barang');

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
        $this->db->from('tbl_item_barang');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $row = $result->row();
            $this->barang = $row->barang;
            $this->berat = $row->berat;
            $this->harga = $row->harga;
            $this->idItem = $row->id_item;
            $this->kdBarang = $row->kd_berang;
            $this->noBarang = $row->no_barang;
            $this->skema = $row->skema;
            $this->spesifikasi = $row->spesifikasi;
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
        $this->db->from('tbl_item_barang');
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
    
    public function search(array $params)
	{
            $this->db->select("tbl_item_barang.*");
            $this->db->from("tbl_item_barang");
            $row = ''; $segment=''; $count=FALSE;
            foreach ($params as $key => $value) {
                if($key=='join'){
                    foreach ($value as $key => $value){
                        $this->db->join($key, $value);
                    }
                }
                if($key=='field'){
                    foreach ($value as $key => $value) {
                        if(is_array($value)){
                            $this->db->where_in($key, ($value));
                        }else{
                            if(is_numeric($value)){
                                $this->db->where($key, ($value));
                            }else{
                                $this->db->like('lower('.$key.')', strtolower($value));
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
                    if(count($value)==1){
                        $count=TRUE;
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