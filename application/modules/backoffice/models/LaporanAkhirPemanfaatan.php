<?php



/**
 * Description of LaporanAkhirPemanfaatan
 *
 * @author ibnua
 */
class LaporanAkhirPemanfaatan extends CI_Model{
    public $id_registrasi;
    public $paket_barang;
    public $nama_peralatan;
    public $jumlah_unit;
    public $peruntukkan;

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
                    $this->paket_barang = $value->paket_barang;
                    $this->nama_peralatan = $value->nama_peralatan;
                    $this->jumlah_unit = $value->jumlah_unit;
                    $this->peruntukkan = $value->peruntukkan;                    
                }
            }
        }
    }
    
    public function insert(){
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'paket_barang' => $this->paket_barang,
            'nama_peralatan' => $this->nama_peralatan,
            'jumlah_unit' => $this->jumlah_unit,
            'peruntukkan' => $this->peruntukkan
        ];
        return $this->db->insert(self::table, $data);
    }
    
    public function update(){
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'paket_barang' => $this->paket_barang,
            'nama_peralatan' => $this->nama_peralatan,
            'jumlah_unit' => $this->jumlah_unit,
            'peruntukkan' => $this->peruntukkan
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
