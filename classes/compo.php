<?php

class Compo {
	
	private $cId;
	private $cName;
	private $gId;
	private $cMaxTeams;
	private $cTeamSize;
	private $cRegistrations;
	
	public function __construct($conn, $cId) {
		
		$query = "SELECT * FROM tblcompos WHERE cId = '$cId'";
		$result = $conn->query($query);
		$rows = mysqli_fetch_row($result);	
		
		$this->cId = $rows[0];
		$this->cName = $rows[1];
		$this->gId = $rows[2];
		$this->cMaxTeams = $rows[3];
		$this->cTeamSize = $rows[4];
		$this->cRegistrations = $rows[5];
		
	}
	
	public function getCompoName() {
		return $this->cName;
	}
	
	public function getGameName($conn) {
		$query = "SELECT gName FROM tblgames WHERE gId = '$this->gId'";
		$result = $conn->query($query);
		$rows = mysqli_fetch_row($result);
		
		return $rows[0];
	}
	
	public function getCompoMaxTeams() {
		return $this->cMaxTeams;
	}
	
	public function getCompoTeamSize() {
		return $this->cTeamSize;
	}
	
	public function getCompoRegistrations() {
		//returns 0 if closed, returns 1 if open
		return $this->cRegistrations;
	}
	
	public function getTeams($conn) {
		$query = "SELECT * FROM tblteams WHERE cId = '$this->cId'";
		$result = $conn->query($query);
		
		return $result;
	}
	
	public static function getUserTeamInfo($conn, $userId, $compoId) {
		$query = "SELECT tId FROM tblteammembers WHERE uId='$userId'";
		$result = $conn->query($query);
		
		while ($row = $result->fetch_assoc()) {
			$query = "SELECT tId, tName FROM tblteams WHERE tId = '" . $row['tId'] . "' AND cId = '$compoId'";
			$result2 = $conn->query($query);
			if ($result2) {
				$row2 = $result2->fetch_assoc();
				$tId = $row2['tId'];
				$tName = $row2['tName'];			
				return array($tId, $tName);
			}
		}
		
		//Handle Error?
		
	}
	
	public static function checkIfUserHasTeam($conn, $user, $compo) {
		$query = "SELECT tId FROM tblteammembers WHERE uId='$user'";
		$result = $conn->query($query);
		
		while ($row = $result->fetch_assoc()) {
			$query = "SELECT * FROM tblteams WHERE tId = '" . $row['tId'] . "' AND cId = '$compo'";
			$result2 = $conn->query($query);
			if ($result2) {
				return $result2;
			}
		}
		
		return false;
	}
	
	public static function listCompos($conn) {
		$query = "SELECT cId FROM tblcompos";
		$result = $conn->query($query);
		
		return $result;
	}
	
	public static function getTotalCompos($conn) {
		
		$query = "SELECT COUNT(*) FROM tblcompos";
		$result = $conn->query($query);
		$rows = mysqli_fetch_row($result);			
		
		return $rows[0];
		
	}
	
}

?>