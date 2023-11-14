<?php




/**
 * @author user
 * @version 1.0
 * @created 26-Aug-2014 12:00:12 PM
 */
interface IModel
{

	public function delete();

	/**
	 * 
	 * @param criteria
	 * @param value
	 * @param row
	 * @param segment
	 */
	public function getObjectFiltered($criteria, $value, $row, $segment);
        
        /**
	 * 
	 * @param row
	 * @param segment
	 */
	public function getObjectList($row, $segment);

	public function insert();

	public function update();

}
?>