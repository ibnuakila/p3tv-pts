<?php
require_once ('yayasan.php');
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:39:06
 */
class Account extends CI_Model implements BaseModel
{

	private $accountStatus;
	private $dateRegistered;
	private $email;
	private $idAccount;
	private $idYayasan;
	private $password;
	private $objYayasan;

	function __construct($id=NULL)
	{
            parent::__construct();
            if($id != NULL){
                $this->db->select('*');         
                $this->db->from('account');
                $this->db->where('id_account',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){
                        $this->setIdAccount($value->id_account);
                        $this->setIdYayasan($value->id_yayasan);
                        $this->setEmail($value->email);
                        $this->setDateRegistered($value->date_registered);
                        $this->setAccountStatus($value->account_status);
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getAccountStatus()
	{
		return $this->accountStatus;
	}

	public function getDateRegistered()
	{
		return $this->dateRegistered;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getIdAccount()
	{
		return $this->idAccount;
	}

	public function getIdYayasan()
	{
		return $this->idYayasan;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getYayasan()
	{
            $this->db->select('*');
            $this->db->from('yayasan');
            $this->db->where('id_yayasan',  $this->idYayasan);
            $result = $this->db->get();
            $this->objYayasan = NULL;
            if($result->num_rows()>0){
                
                foreach ($result->result() as $obj){
                    $this->objYayasan = new Yayasan($obj->id_yayasan);
                }
                    
            }
            return $this->objYayasan;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setAccountStatus($newVal)
	{
		$this->accountStatus = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setDateRegistered($newVal)
	{
		$this->dateRegistered = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setEmail($newVal)
	{
		$this->email = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdAccount($newVal)
	{
		$this->idAccount = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdYayasan($newVal)
	{
		$this->idYayasan = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPassword($newVal)
	{
		$this->password = $newVal;
	}

	public function delete()
	{
	}

	/**
	 * 
	 * @param row
	 * @param segment
	 */
	public function get($row = Null, $segment = Null)
	{
            $this->db->select('*');
            $this->db->from('account');
            if($row==NULL && $segment==NULL){
                return $this->db->count_all_results();
            }elseif($row==0 && $segment==0){
                return $this->db->get('');
            }else{
                return $this->db->get('', $row, $segment);
            }
	}

	/**
	 * 
	 * @param field
	 * @param value
	 */
	public function getBy($field, $value)
	{
            $this->db->select('*');
            $this->db->from('account');
            $this->db->where($field, $value);
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result() as $value){
                    $this->setIdAccount($value->id_account);
                    $this->setIdYayasan($value->id_yayasan);
                    $this->setEmail($value->email);
                    $this->setDateRegistered($value->date_registered);
                    $this->setAccountStatus($value->account_status);
                }
                return TRUE;
            }else{
                return FALSE;
            }
	}

	/**
	 * 
	 * @param related
	 * @param field
	 * @param value
	 */
	public function getByRelated($related, $field, $value, $row = Null, $segment = Null)
	{
            $this->db->select('account.*');
            $this->db->from('account');
            $this->db->join('yayasan','account.id_yayasan = yayasan.id_yayasan');
            $this->db->like($related.'.'.$field, $value);
            if($row==NULL && $segment==NULL){
                return $this->db->count_all_results();
            }else{
                return $this->db->get('', $row, $segment);
            }
	}

	public function insert()
	{
	}

	public function update()
	{
	}

}
?>