<?php
class Courses {
	protected static $table_name = "courses";
	
	public $uid;
	public $name;
	public $code;
	public $interview_startdate;
	
	public static function find_by_sql($sql="") {
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($result_set)) {
			global $database;
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	private static function instantiate($record) {
		$object = new self;
		
		foreach ($record as $attribute=>$value) {
			if ($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
		// get_object_vars returns as associative array with all attributes
		// (incl. private ones!) as the keys and their current values as the value
		$object_vars = get_object_vars($this) ;
		
		// we don't care about the value, we just want to know if the key exists
		// will return true or false
		return array_key_exists($attribute, $object_vars);
	}
	
	///////////////////////
	
	public static function find_by_uid($uid = NULL) {
		global $database;
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE uid = '" . $uid . "' ";
		$sql .= "LIMIT 1";
		
		$results = self::find_by_sql($sql);
		
		return !empty($results) ? array_shift($results) : false;
	}
	
	public static function find_by_multiple_uid($uidArray = NULL) {
		global $database;
		
		$uids = implode(",", $uidArray);
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE uid IN (" . $uids . ")";
		
		$results = self::find_by_sql($sql);
		
		return $results;
	}
	
	public static function find_all() {
		global $database;
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "ORDER BY name ASC";
		
		$results = self::find_by_sql($sql);
		
		return $results;
	}
	
	public static function find_all_in_use() {
		global $database;
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE uid IN (SELECT DISTINCT(course_code) FROM auth) ";
		$sql .= "ORDER BY name ASC";
		
		$results = self::find_by_sql($sql);
		
		return $results;
	}
	
	public function displayName() {
		$output  = $this->name;
		$output .= " (" . $this->code . ")";
		
		return $output;
	}
	
	public function displayShortName() {
		if (strlen($this->name) >= 28) {
			$output  = substr($this->name, 0, 28) . "...";
		} else {
			$output  = $this->name;
		}
		
		$output .= " (" . $this->code . ")";
		
		return $output;
	}
	
	public function inlineUpdate($courseUID = NULL, $key, $value) {
		global $database;
		
		$sql  = "UPDATE " . self::$table_name . " ";
		$sql .= "SET " . $database->escape_value($key) . " = '" . $database->escape_value($value) . "' ";
		$sql .= "WHERE uid = '" . $database->escape_value($courseUID) . "' ";
		$sql .= "LIMIT 1";
		
		$results = self::find_by_sql($sql);
		
		$log = new Logs();
		$log->type = "success";
		$log->title = "Courses Update";
		$log->description = "Course UID " . $this->uid . " was updated";
		$log->create();
	}
	
	function is_in_use() {
		global $database;
		
		$sql  = "SELECT * FROM auth ";
		$sql .= "WHERE course_code = '" . $this->uid . "'";
		
		$results = self::find_by_sql($sql);
		
		if (count($results) > 0) {
			return true;
		} else {
			return false;
		}
		
	}
}
?>

