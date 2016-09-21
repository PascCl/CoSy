<?php

class Team
{
    private $tId = false;
    private $tName;
    private $cId;
    
    public function getTName()
    {
        return $this->tName;
    }
    
    public function getTId()
    {
        return $this->tId;
    }
    
    function setTId($tId) {
        $this->tId = $tId;
    }

    function setTName($tName) {
        $this->tName = $tName;
    }

    function setCId($cId) {
        $this->cId = $cId;
    }
    
    public function construct($conn, $tId)
    {
        $query = $conn->prepare('SELECT * FROM tblteams WHERE tId = ?');
        $tId = mysqli_real_escape_string($conn, $tId);
        $query->bind_param('s', $tId);
        if ($query->execute())
        {
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            $this->setTId($row['tId']);
            $this->setTName($row['tName']);
            $this->setCId($row['cId']);
        }
    }
    
    public function createTeam($conn, $tName, $cId, $uId)
    {
        if (!$this->checkTeamName($conn, $tName))
        {
            $error = "Team name already exists.";
            return $error;
        }
        
        if ($this->checkIfUserHasTeam($conn, $uId, $cId) != false)
        {
            $error = "That person is already in a team for this competition.";
            return $error;
        }
        
        $query = $conn->prepare('INSERT INTO tblteams (tName, cId) VALUES (?, ?)');
        $tName = mysqli_real_escape_string($conn, $tName);
        $cId = mysqli_real_escape_string($conn, $cId);
        $query->bind_param('ss', $tName, $cId);
        if ($query->execute())
        {
            $tId = $query->insert_id;
            $this->construct($conn, $tId);
            if ($this->addMember($conn, $uId, 2))
            {
                return true;
            }
        }
        return false;
    }
    
    public function checkTeamName($conn, $tName)
    {
        $query = $conn->prepare('SELECT tId FROM tblteams WHERE tName = ?');
        $tName = mysqli_real_escape_string($conn, $tName);
        $query->bind_param('s', $tName);
        $query->execute();
        $result = $query->get_result();
        if (mysqli_num_rows($result) > 0)
        {
            return false;
        }
        return true;
    }
    
    //returns false if user has no team, returns teamId if user has a team
    public function checkIfUserHasTeam($conn, $uId, $cId)
    {
        $query = $conn->prepare('SELECT tId FROM tblteams WHERE cId = ?');
        $cId = mysqli_real_escape_string($conn, $cId);
        $query->bind_param('s', $cId);
        $query->execute();
        $result = $query->get_result();
        
        $uId = mysqli_real_escape_string($conn, $uId);
        while ($row = $result->fetch_assoc())
        {
            $query = $conn->prepare('SELECT tId FROM tblteammembers WHERE uId = ?');
            $query->bind_param('s', $uId);
            $query->execute();
            $result = $query->get_result();
            if (mysqli_num_rows($result) == 1)
            {
                $row = $result->fetch_assoc();
                return $row['tId'];
            }
        }
        return false;
    }
    
    public function addMember($conn, $uId, $uTeamPowers)
    {
        $query = $conn->prepare('INSERT INTO tblteammembers (tId, uId, uTeamPowers) VALUES (?, ?, ?)');
        $tId = mysqli_real_escape_string($conn, $this->getTId());
        $uId = mysqli_real_escape_string($conn, $uId);
        $uTeamPowers = mysqli_real_escape_string($conn, $uTeamPowers);
        $query->bind_param('sss', $tId, $uId, $uTeamPowers);
        if ($query->execute())
        {
            return true;
        }
        return false;
    }
    
}

?>