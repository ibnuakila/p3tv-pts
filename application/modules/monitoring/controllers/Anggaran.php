<?php
class Anggaran extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Modusers');
        $this->load->library('sessionutility');
        $this->load->helper('datatables');
        //if (!$this->sessionutility->validateSession()){
        //    redirect(base_url().'backoffice/');
        //}
    }


    public function index(){
        echo add_header_js('https://code.jquery.com/jquery-3.3.1.js');
        echo add_footer_css('vendor/DataTables-1.10.6/media/css/jquery.dataTables.css');
        echo add_footer_css('vendor/DataTables-1.10.6/extensions/TableTools/css/dataTables.tableTools.css');
        echo add_footer_css('vendor/DataTables/media/css/dataTables.bootstrap.css');
        echo add_footer_js('vendor/DataTables-1.10.6/media/js/jquery.dataTables.js');
        echo add_footer_js('vendor/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.js');
        echo add_footer_js('admin/js/plugins/dataTables/dataTables.bootstrap.js');
                
        $data['title'] = 'Anggaran';
        showNewBackEnd('anggaran/index', $data,'index-1');
    }

    public function data_anggaran_pt()
    {
        /*$this->load->model('Mdatatables');
        $sql = "
            select tbl_pti.kdpti as kdpti,
            tbl_pti.nmpti as nmpti,	
            sum(tbl_item_hibah.jml_item * tbl_item_hibah.hrg_satuan ) total 
            from tbl_item_hibah 
            join tbl_item_barang on tbl_item_hibah.id_item = tbl_item_barang.id_item  and tbl_item_barang.periode='20241'
            join registrasi on tbl_item_hibah.id_registrasi = registrasi.id_registrasi
            join tbl_pti on tbl_pti.kdpti = registrasi.kdpti 
            join jadwal_presentasi on jadwal_presentasi.id_registrasi = registrasi.id_registrasi 
        ";
 
        $search = array('tbl_pti.nmpti');
        $where  = array('jadwal_presentasi.tgl_presentasi'=>'2024-06-21') ; 
        $isWhere = null;
        
        header('Content-Type: application/json');
        echo $this->Mdatatables->get_tables_query($sql,$search,$where,$isWhere);*/

        $sql = "
            select e.kdpti,nmpti,	sum(a.jml_item *	(a.hrg_satuan + g.ongkir) ) total from 
            tbl_item_hibah a join tbl_item_barang b on a.id_item = b.id_item  and b.periode='20241'
            join registrasi d on a.id_registrasi = d.id_registrasi
            join tbl_pti e on e.kdpti = d.kdpti 
            join tbl_item_ongkir_pt g on g.id_registrasi = d.id_registrasi and a.id_item = g.id_item
            join jadwal_presentasi f on f.id_registrasi = d.id_registrasi where 
            f.tgl_presentasi>'2024-01-01'  group by e.kdpti
            ORDER BY e.kdpti    
        ";
        $rs = $this->db->query($sql);
        $html = '
        <table id="anggaran" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Perguruan Tinggi</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
        ';
        $no = 1;
        foreach($rs->result() as $row) {
            $html .= "<tr>";
            $html .= "<td>".$no."</td>"."<td>".$row->nmpti."</td>"."<td>".number_format($row->total,1,',','.')."</td>";;
            $html .= "</tr>";
            $no++;
        }

        $html .= '</table>';
        echo $html;
        
    }

    public function data_anggaran_total()
    {

        $sql = "
            select sum(a.jml_item *	(a.hrg_satuan + g.ongkir) ) total from 
            tbl_item_hibah a join tbl_item_barang b on a.id_item = b.id_item  and b.periode='20241'
            join registrasi d on a.id_registrasi = d.id_registrasi
            join tbl_pti e on e.kdpti = d.kdpti 
            join tbl_item_ongkir_pt g on g.id_registrasi = d.id_registrasi and a.id_item = g.id_item
            join jadwal_presentasi f on f.id_registrasi = d.id_registrasi where 
            f.tgl_presentasi>'2024-01-01'
        ";

       $rs =  $this->db->query($sql);
       $data = $rs->row();

       if($data->total!=null)
       {
            echo "Rp. ".number_format($data->total,1,',','.');
       } else {
            echo 0;
       }
       
 

    }

}