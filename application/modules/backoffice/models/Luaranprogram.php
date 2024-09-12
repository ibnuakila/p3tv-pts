<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Luaranprogram
 *
 * @author ibnua
 */
class LuaranProgram extends CI_Model {
    const table = 'luaran_program';
    public $id;
    public $id_registrasi;
    public $nama_prodi;
    public $ruang_lingkup;
    public $program_pengembangan;
    public $bentuk_luaran;
    public $jumlah_luaran;
    public $tahun;
    public $waktu_pelaksanaan;
    public $biaya;
    public $target_iku;
    public $keterangan;
            
    function __construct($id = null) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from(self::table);
            $this->db->where('id', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->id = $value->id;
                    $this->id_registrasi = $value->id_registrasi;
                    $this->nama_prodi = $value->nama_prodi;
                    $this->ruang_lingkup = $value->ruang_lingkup;
                    $this->program_pengembangan = $value->program_pengembangan;
                    $this->bentuk_luaran = $value->bentuk_luaran;
                    $this->jumlah_luaran = $value->jumlah_luaran;
                    $this->tahun = $value->tahun;
                    $this->waktu_pelaksanaan = $value->waktu_pelaksanaan;
                    $this->biaya = $value->biaya;
                    $this->target_iku = $value->target_iku;
                    $this->keterangan = $value->keterangan;
                }
            }
        }
    }
    
    public function insert(){
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'nama_prodi' => $this->nama_prodi,
            'ruang_lingkup' => $this->ruang_lingkup,
            'program_pengembangan' => $this->program_pengembangan,
            'bentuk_luaran' => $this->bentuk_luaran,
            'jumlah_luaran' => $this->jumlah_luaran,
            'tahun' => $this->tahun,
            'waktu_pelaksanaan' => $this->waktu_pelaksanaan,
            'biaya' => $this->biaya,
            'target_iku' => $this->target_iku,
            'keterangan' => $this->keterangan];
        return $this->db->insert(self::table, $data);
    }
    
    public function update($id) {
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'nama_prodi' => $this->nama_prodi,
            'ruang_lingkup' => $this->ruang_lingkup,
            'program_pengembangan' => $this->program_pengembangan,
            'bentuk_luaran' => $this->bentuk_luaran,
            'jumlah_luaran' => $this->jumlah_luaran,
            'tahun' => $this->tahun,
            'waktu_pelaksanaan' => $this->waktu_pelaksanaan,
            'biaya' => $this->biaya,
            'target_iku' => $this->target_iku,
            'keterangan' => $this->keterangan];
        $this->db->where('id', $id);
        return $this->db->update(self::table, $data);
    }
    
    public function delete($id) {
        return $this->db->delete(self::table, ['id' => $id]);
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
