<?php


/**
 * Description of Laporankemajuan
 *
 * @author ibnua
 */
class Laporankemajuan extends CI_Model{
    
    public $id;
    public $filePath;
    public $uploadDate;
    public $idRegistrasi;

    public $luaranProgramId;
    public $namaDokumen;

    const table = "laporan_kemajuan";
            
    function __construct($id=null) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from('laporan_kemajuan');
            $this->db->where('id_registrasi', $id);
            $this->db->or_where('id', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->id = $value->id;
                    $this->idRegistrasi = $value->id_registrasi;                   
                    $this->filePath = $value->filepath;
                    $this->uploadDate = $value->upload_date;                   
                    $this->luaranProgramId = $value->luaran_program_id;
                    $this->namaDokumen = $value->nama_dokumen;
                }
            }
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
