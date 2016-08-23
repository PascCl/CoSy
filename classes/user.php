<?php

class User {
	
	private $uId;
	private $uName;
	private $uSteam;
	private $uRiot;
	private $uBlizzard;
	private $uPhone;
	
	public function __construct($conn, $uId) {
		$query = "SELECT * FROM tblUsers WHERE uId = '$uId'";
		$result = $conn->query($query);
		$rows = $result->fetch_array(MYSQLI_ASSOC);	
		
		$this->uId = $rows['uId'];
		$this->uName = $rows['uName'];
		$this->uMail = $rows['uMail'];
		$this->uSteam = $rows['uSteam'];
		$this->uRiot = $rows['uRiot'];
		$this->uBlizzard = $rows['uBlizzard'];
		$this->uPhone = $rows['uPhone'];
	}
	
	public function getUserName() {
		return $this->uName;
	}
	
	public function getUserSteam() {
		return $this->uSteam;
	}
	
	public function getUserRiot() {
		return $this->uName;
	}
	
	public function getUserBlizzard() {
		return $this->uName;
	}
	
	public static function getUserPowers($conn, $uId) {
		$query = "SELECT uPower FROM tbluserpowers WHERE uId = '$uId'";
		$result = $conn->query($query);
		if (mysqli_num_rows($result) > 0) {
			while ($row = $result->fetch_assoc()) {
				$power = $row['uPower'];
				$uPowers[$power] = true;
			}
			return $uPowers;
		}
		return 0;
	}
	
	public static function getUserId($conn, $userName) {
		$query = "SELECT uId FROM tblusers WHERE uName = '$userName'";
		$result = $conn->query($query);
		if (mysqli_num_rows($result) == 1) {
			$row = $result->fetch_assoc();
			$id = $row['uId'];
			return $id;
		} else {
			return false;
		}
	}
	
	//returns a list of suggestions from a partly typed username
	public static function getSuggestions($conn, $userpart) {
		$query = "SELECT uName FROM tblusers WHERE uName LIKE '%" . $userpart . "%'";
		$result = $conn->query($query);
		return $result;
	}
	
	public static function checkLogin($conn, $name, $pass) {
		$query = "SELECT uId, uName, uPass FROM tblusers WHERE uName = '$name' LIMIT 10";
		$result = $conn->query($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
		if ($result->num_rows == 1 && password_verify($pass, $row['uPass'])) {
			return $row['uId'];
		} else {
			return 0;
		}
	}
	
	public static function listUsers($conn) {
		$query = "SELECT * FROM tblUsers";
		$result = $conn->query($query);		
		
		return $result;
	}
	
	public static function getTotalUsers($conn) {
		$query = "SELECT COUNT(*) FROM tblUsers";
		$result = $conn->query($query);
		$rows = mysqli_fetch_row($result);			
		
		return $rows[0];
	}
	
	public static function validateName($conn, $name) {
		$error = "";
		$query = "SELECT * FROM tblUsers WHERE uName = '$name'";
		$result = $conn->query($query);
		if ($result->num_rows != 0) {
			$error = "Username already exists.";
		}
		return $error;
	}
	
	public static function validateMail($conn, $mail) {
		$error = "";
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			$error = "E-mail is not valid.";
			return $error;
		}
		$query = "SELECT * FROM tblusers WHERE uMail = '$mail'";
		$result = $conn->query($query);
		if ($result->num_rows != 0) {
			$error = "E-mail is already in use.";
		}
		return $error;
	}
	
	public static function encryptPass($pass) {
		return password_hash($pass, PASSWORD_DEFAULT);
	}
	
	public static function validatePhone($conn, $phone) {
		//Insert code to validate phone number here.
	}
	
	public static function validateSteam($conn, $phone) {
		//Insert code to validate Steam here.
	}
	
	public static function validateRiot($conn, $phone) {
		//Insert code to validate Riot account here.
	}
	
	public static function validateBlizzard($conn, $phone) {
		//Insert code to validate Battle.net account here.
	}
	
	public static function saveUser($conn, $name, $mail, $phone, $steam, $riot, $blizzard, $pass) {
		$query = "INSERT INTO tblusers (uName, uMail, uPass, uSteam, uRiot, uBlizzard, uPhone) VALUES('$name', '$mail', '$pass', '$steam', '$riot', '$blizzard', '$phone')";
		$result = $conn->query($query);
		return $result;
	}
	
}

?>