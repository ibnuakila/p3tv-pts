<?php


/**
 * Description of LaporanAkhirDanaPendamping
 *
 * @author ibnua
 */
class LaporanAkhirDanaPendamping extends CI_Model {
    public $id_registrasi;
    public $nama_kegiatan;
    public $mata_kuliah;
    public $tgl_pelaksanaan;
    public $dana_pts;
    public $realisasi_dana_pts;
    public $output_luaran;
    
    const table = 'laporan_akhir_pemanfaatan';
    function __construct($id = null): void {    
        parent::__construct();
        if($id != null){
            $this->db->select('*');         
            $this->db->from(self::table);
            $this->db->where('id_registrasi',$id_registrasi);
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result() as $value){
                    $this->id_registrasi = $value->id_registrasi;
                    $this->nama_kegiatan = $value->nama_kegiatan;
                    $this->mata_kuliah = $value->mata_kuliah;
                    $this->tgl_pelaksanaan = $value->tgl_pelaksanaan;
                    $this->dana_pts = $value->dana_pts;    
                    $this->realisasi_dana_pts = $value->realisasi_dana_pts;
                    $this->output_luaran = $value->output_luaran;
                }
            }
        }
    }
    
    public function insert(){
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'nama_kegiatan' => $this->nama_kegiatan,
            'mata_kuliah' => $this->mata_kuliah,
            'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
            'dana_pts' => $this->dana_pts,
            'realisasi_dana_pts' => $this->realisasi_dana_pts,
            'output_luaran' => $this->output_luaran
        ];
        return $this->db->insert(self::table, $data);
    }
    
    public function update(){
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'nama_kegiatan' => $this->nama_kegiatan,
            'mata_kuliah' => $this->mata_kuliah,
            'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
            'dana_pts' => $this->dana_pts,
            'realisasi_dana_pts' => $this->realisasi_dana_pts,
            'output_luaran' => $this->output_luaran
        ];
        $this->db->where('id_registrasi', $this->id_registrasi);
        return $this->db->update(self::table, $data);
    }
    
    public function delete(){
        return $this->db->delete(self::table, ['id_registrasi' => $this->id_registrasi]);
    }
    
    public function getResult($params){
        $this->db->select(self::table . '.*');
        $this->db->from(self::table);

        $count = false;
        foreach ($params as $key => $value) {
            if ($key == 'join') {
                foreach ($value as $key => $sub_value) {
                    foreach ($sub_value as $operator => $value) {
                        $this->db->join($key, $value, $operator);
                    }
                }
            }
            if ($key == 'field') {
                foreach ($value as $key => $sub_value) {
                    foreach ($sub_value as $operator => $item) {
                        if ($operator == 'IN') {
                            $this->db->where_in($key, $item);
                        } elseif ($operator == 'NOT IN') {
                            $this->db->where_not_in($key, $item);
                        } elseif ($operator == 'LIKE') {
                            $this->db->like('lower(' . $key . ')', strtolower($item));
                        } elseif ($operator == 'BETWEEN') {
                            $where = $key . " " . $operator . " '" . $item[0] . "' AND '" . $item[1] . "'";
                            $this->db->where($where);
                        } else {
                            $this->db->where($key . $operator, $item);
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
                $count = $value;
            }
            if ($key == 'order') {
                foreach ($value as $key => $value) {
                    $this->db->order_by($key, $value);
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
