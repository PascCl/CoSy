<?php

class Team {
	
	public static function saveNewTeam($conn, $teamName, $compoId, $leaderId) {
		
		//add something to check if user is allowed to sign up for this compo here
		//
		
		$query = "INSERT INTO tblteams (tName, cId) VALUES ('$teamName', '$compoId')";
		$result = $conn->query($query);
		
		if ($result) {
			$teamId = $conn->insert_id;
			$query = "INSERT INTO tblteammembers (tId, uId, uRights) VALUES ($teamId, $leaderId, 2)";
			$result = team::addTeamMember($conn, $teamId, $leaderId, "2");
			return $result;
		}
		return false;
	}
	
	public static function addTeamMember($conn, $teamId, $userId, $rights) {
		
		//add something to check if user is allowed to join this compo here
		//
		
		//check if user is already in a team for this compo
		$query = "SELECT uId FROM tblteammembers WHERE uId = '$userId'";
		$result = $conn->query($query);
		if (mysqli_num_rows($result) == 0) {
			$query = "INSERT INTO tblteammembers (tId, uId, uRights) VALUES ($teamId, $userId, $rights)";
			$result = $conn->query($query);
			return $result;
		}
		return false;
	}
	
	public static function getMemberRights($conn, $teamId, $userId) {
		$query = "SELECT uRights FROM tblteammembers WHERE tId = '$teamId' AND uId = '$userId'";
		$result = $conn->query($query);
		if ($result) {
			$row = $result->fetch_assoc();
			if (mysqli_num_rows($result) == 1 && $row['uRights'] > 0) {
				return true;
			} else {
				//add logging, should never happen
				//
			}
		}
		return false;
	}
	
	public static function getTeamInfo($conn, $teamId) {
		$query = "SELECT * FROM tblteams WHERE tId = '$teamId'";
		$result = $conn->query($query);
		return $result;
	}
	
	public static function getMembers($conn, $teamId) {
		$query = "SELECT * FROM tblteammembers WHERE tId ='$teamId'";
		$result = $conn->query($query);
		return $result;
	}
	
	public static function listTeams($conn) {
		$query = "SELECT * FROM tblteams";
		$result = $conn->query($query);		
		
		return $result;
	}
	
	public static function getTotalTeams($conn) {
		
		$query = "SELECT COUNT(*) FROM tblteams";
		$result = $conn->query($query);
		$rows = mysqli_fetch_row($result);			
		
		return $rows[0];
		
	}
	
}

?>