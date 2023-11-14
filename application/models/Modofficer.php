<?php

class Modofficer extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
    }

    public function getMenu($userid) {
        $query = $this->db->query("select ssm.sub_module_id, ssm.sub_module_name, ssm.menu_name as submodulename, sm.module_name, sm.menu_name as modulname, si.system_name, ssm.is_menu
            from sub_system_module ssm, system_module sm, system_information si, user_access ua
            where ssm.module_id=sm.module_id and sm.system_id=si.system_id and ua.sub_module_id=ssm.sub_module_id and ua.user_id='$userid' order by si.system_id, sm.module_id");
        return $query;
    }
    
	
	public function getUserRole($user_type, $unit_id){
		$query = $this->db->query("select sub_module_id from user_type_role where user_type='$user_type' and unit_id='$unit_id' ");
		return $query->result();
	}
	
	public function getSI($user_id){
		$query = $this->db->query("SELECT si.* from system_information si, system_module sm, sub_system_module ssm,
			user_access ua WHERE si.system_id=sm.system_id and sm.module_id=ssm.module_id AND
			ssm.sub_module_id=ua.sub_module_id and ua.user_id='$user_id' GROUP BY si.system_id
			ORDER BY si.system_id;");
		return $query->result();
	}
	
	
		
	public function getUserAccess($id){
		$query = $this->db->query("SELECT * from user_access where user_id='$id'");
		return $query->result();
	}
	
	public function getOfficer(){
		$query = $this->db->query("select a.*, b.*, c.* from users a , unit_kerja b, user_type c where c.user_type=a.user_type and a.unit_id=b.unit_id");
		return $query->result();
	}
	
	public function insert_user($data){
		$this->db->insert('users',$data);
	}
	
	public function insert_userAccess($data){
		$this->db->insert('user_access',$data);
	}
	public function delete_user($id){
		$this->db->where('user_id',$id);
		$this->db->delete('users');
	}
	public function update_user($data,$userid){
		$this->db->where('user_id',$userid);
		$this->db->update('users',$data);
	}
	public function delete_userAccess($userid){
		$this->db->where('user_id',$userid);
		$this->db->delete('user_access');
	}
	public function get_userType(){
		$query = $this->db->get('user_type');
		return $query->result();
	}
	public function get_unitKerja(){
		$query = $this->db->get('unit_kerja');
		return $query->result();
	}
	public function get_si(){
		$query = $this->db->get('system_information');
		return $query->result();
	}
	public function get_modules_selected($id){
		$query = $this->db->where('system_id',$id);
		$this->db->where('module_name <>',"");
		$query = $this->db->get('system_module');
		return $query->result();
	}
	public function get_subModules_selected($id){
		$this->db->where('module_id',$id);
		$this->db->where('sub_module_name <>',"");
		$query = $this->db->get('sub_system_module');
		return $query->result();
	}
	public function user_selected($id){
		$query = $this->db->query("select a.*, b.*, c.* from users a , unit_kerja b, user_type c where c.user_type=a.user_type and a.unit_id=b.unit_id and a.user_id='$id'");
		
		return $query->row();
	}
	
	public function user_selected_email($email){
		$this->db->where('email',$email);
		$query = $this->db->get('users');
		return $query->row();
	}
	public function get_userAccess($id){
		$this->db->where('user_id',$id);
		$query = $this->db->get('user_access');
		return $query->result();
	}
}
