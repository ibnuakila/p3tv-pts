<?php




/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:49:43
 */
interface BaseModel
{

	public function delete();

	/**
	 * 
	 * @param row
	 * @param segment
	 */
	public function get($row = Null, $segment = Null);

	/**
	 * 
	 * @param field
	 * @param value
	 */
	public function getBy($field, $value);

	/**
	 * 
	 * @param related
	 * @param field
	 * @param value
	 */
	public function getByRelated($related, $field, $value, $row = Null, $segment = Null);

	public function insert();

	public function update();

}
?>