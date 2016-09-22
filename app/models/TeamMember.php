<?php

class TeamMember
{
    private $teamMemberId;
    private $teamId;
    private $teamMemberUserId;
    private $teamMemberUserName;
    private $teamMemberPowers; //0 = member, 1 = admin, 2 = owner
    
    function getTeamMemberId() {
        return $this->teamMemberId;
    }

    function getTeamId() {
        return $this->teamId;
    }

    function getTeamMemberUserId() {
        return $this->teamMemberUserId;
    }

    function getTeamMemberPowers() {
        return $this->teamMemberPowers;
    }
    
    function getTeamMemberUserName() {
        return $this->teamMemberUserName;
    }
    
    function setTeamMemberId($teamMemberId) {
        $this->teamMemberId = $teamMemberId;
    }

    function setTeamId($teamId) {
        $this->teamId = $teamId;
    }

    function setTeamMemberUserId($teamMemberUserId) {
        $this->teamMemberUserId = $teamMemberUserId;
    }

    function setTeamMemberPowers($teamMemberPowers) {
        $this->teamMemberPowers = $teamMemberPowers;
    }
    
    function setTeamMemberUserName($teamMemberUserName) {
        $this->teamMemberUserName = $teamMemberUserName;
    }

        
    function construct($conn, $teamId, $teamMemberId)
    {
        $teamId = mysqli_real_escape_string($conn, $teamId);
        $teamMemberId = mysqli_real_escape_string($conn, $teamMemberId);
        $query = $conn->prepare('SELECT * FROM tblteammembers WHERE tId = ? AND uId = ?');
        $query->bind_param('ss', $teamId, $teamMemberId);
        $query->execute();
        $result = $query->get_result();
        if (mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $this->setTeamId($row['tId']);
            $this->setTeamMemberId($row['mId']);
            $this->setTeamMemberUserId($row['uId']);
            $this->setTeamMemberPowers($row['uTeamPowers']);
            
            $query2 = $conn->prepare('SELECT uName FROM tblusers WHERE uId = ?');
            $teamMemberUserId = $this->getTeamMemberUserId();
            $query2->bind_param('s', $teamMemberUserId);
            $query2->execute();
            $result2 = $query2->get_result();
            $row2 = $result2->fetch_assoc();
            $this->setTeamMemberUserName($row2['uName']);
        }
    }
    
}

?>