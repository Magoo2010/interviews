<?php
class Students {
	protected static $table_name = "auth";
	
	public $uid;
	public $ucas;
	public $title;
	public $forenames;
	public $surname;
	public $course;
	public $add1;
	public $add2;
	public $add3;
	public $add4;
	public $add5;
	public $email;
	public $phone;
	public $skype;
	public $arrival_date;
	public $arrival_time;
	public $disability;
	public $diet;
	public $photograph;
	public $date_created;
	public $date_updated;
	public $confirmed_attendance;
	public $allow_feedback;
	public $location_type;
	
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
	
	public static function find_all() {
		global $database;
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "ORDER BY surname ASC";
		
		$results = self::find_by_sql($sql);
		
		return $results;
	}
	
	public static function find_all_invitees() {
		global $database;
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "ORDER BY surname ASC";
		
		$results = self::find_by_sql($sql);
		
		return $results;
	}
	
	public static function find_all_confirmed() {
		global $database;
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE confirmed_attendance = '1' ";
		$sql .= "ORDER BY surname ASC";
		
		$results = self::find_by_sql($sql);
		
		return $results;
	}
	
	public static function find_all_confirmed_by_course($course = null) {
		global $database;
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE confirmed_attendance = '1' ";
		$sql .= "AND course = '" . $course . "' ";
		$sql .= "ORDER BY surname ASC";
		
		$results = self::find_by_sql($sql);
		
		return $results;
	}
	
	public static function find_all_unconfirmed() {
		global $database;
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE confirmed_attendance <> '1' ";
		$sql .= "ORDER BY surname ASC";
		
		$results = self::find_by_sql($sql);
		
		return $results;
	}
	
	public function fullDisplayName() {
		$title = $this->title;
		$firstname = $this->forenames;
		
		$familyname = $this->surname;
		
		return $title . " " . $firstname . " " . $familyname;
	}
	
	public function updatePhotograph() {
		global $database;
		
		$sqlUpdate  = "UPDATE " . self::$table_name . " set ";
		$sqlUpdate .= "photograph = '" . $database->escape_value($this->photograph) . "', ";
		$sqlUpdate .= "date_updated = '" . date('Y-m-d H:i:s') . "' ";
		$sqlUpdate .= "WHERE uid = " . $this->uid;
		
		if ($database->query($sqlUpdate)) {
			$log = new Logs();
			$log->type = "success";
			$log->title = "File Upload";
			$log->description = $this->fullDisplayName() . " uploaded file '" . $this->photograph . "'";
			$log->userUID = $this->uid;
			$log->create();
			
			return true;
		} else {
			
			return false;
		}
		
	}
	
	public function imageURL($fullImgTag = false) {
		$pathToFiles = "uploads/";
		$pathToFile = $pathToFiles . $this->photograph;
		
		if (!file_exists($pathToFile)|| $this->photograph == null) {
			$pathToFile = "img/no_user_photo.png";
		}
		
		if ($fullImgTag == true) {
			$output  = "<img src=\"" . $pathToFile . "\" class=\"img-polaroid hidden-phone pull-right\" style=\"max-width: 100%; max-height: 300px;\">";
		} else {
			$output = $pathToFile;
		}
		
		return $output;
	}
	
	public function logon($surname = null, $ucas = null) {
		global $database;
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE ucas = '" . $database->escape_value($ucas) . "' ";
		$sql .= "AND surname = '" . $database->escape_value($surname) . "' ";
		$sql .= "LIMIT 1";
		
		$results = self::find_by_sql($sql);
		
		if (count($results) == 1) {
			return array_shift($results);
		} else {
			return false;
		}
	}
	
	public function update() {
		global $database;
		
		$sqlUpdate  = "UPDATE " . self::$table_name . " set ";
		
		foreach (get_object_vars($this) AS $dbRow => $value) {
			$sqlUpdates[] = "confirmed_attendance = '1'";
			
			if (isset($value) && $dbRow != "uid") {
				$sqlUpdates[] = $dbRow . " = '" . $database->escape_value($value) . "'";
			}
		}
		
		$sqlUpdate .= implode(", ", $sqlUpdates);
		
		$sqlUpdate .= "WHERE uid = '" . $database->escape_value($this->uid) . "' LIMIT 1";
		
		if ($database->query($sqlUpdate)) {
			$log = new Logs();
			$log->type = "success";
			$log->title = "Details Update";
			$log->description = "User updated their details";
			$log->userUID = $this->uid;
			$log->create();
			
			return true;
		} else {
			$log = new Logs();
			$log->type = "warning";
			$log->title = "Details Update Failure";
			$log->description = "User attempted to update their details, but a failure occurred";
			$log->userUID = $this->uid;
			$log->create();
			
			return false; // something when wrong with updatings the db
		}
	}
}
?>
