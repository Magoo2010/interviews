<?php
class Logs {
	protected static $table_name = "logs";
	
	public $uid;
	public $date_created;
	public $type;
	public $title;
	public $description;
	public $userUID;
	public $ip;
	
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
		
		$sql  = "SELECT uid, date_created, type, title, description, userUID, INET_NTOA(ip) AS ip FROM " . self::$table_name . " ";
		$sql .= "WHERE uid = '" . $uid . "' ";
		$sql .= "LIMIT 1";
		
		$results = self::find_by_sql($sql);
		
		return !empty($results) ? array_shift($results) : false;
	}
	
	public static function find_by_user_uid($userUID = NULL) {
		global $database;
		
		$sql  = "SELECT uid, date_created, type, title, description, userUID, INET_NTOA(ip) AS ip FROM " . self::$table_name . " ";
		$sql .= "WHERE userUID = '" . $userUID . "' ";
		$sql .= "ORDER BY date_created DESC";
		
		$results = self::find_by_sql($sql);
		
		return $results;
	}
	
	public static function find_all() {
		global $database;
		
		$sql  = "SELECT uid, date_created, type, title, description, userUID, INET_NTOA(ip) AS ip FROM " . self::$table_name . " ";
		$sql .= "ORDER BY date_created DESC";

		$results = self::find_by_sql($sql);
		
		return $results;
	}
	
	public function create() {
		global $database;
		
		$sql  = "INSERT INTO " . self::$table_name . " (";
		$sql .= "date_created, type, title, description, ip, userUID";
		$sql .= ") VALUES ('";
		$sql .= $database->escape_value(date('c')) . "', '";
		$sql .= $database->escape_value($this->type) . "', '";
		$sql .= $database->escape_value($this->title) . "', '";
		$sql .= $database->escape_value($this->description) . "', ";
		$sql .= "INET_ATON('" . $_SERVER['REMOTE_ADDR'] . "'), '";
		$sql .= $database->escape_value($this->userUID) . "')";
		
		
		if ($database->query($sql)) {
		}
	}
}
?>

