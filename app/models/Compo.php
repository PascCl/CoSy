<?php

class Compo
{
    private $cId;
    private $cName;
    private $gId;
    private $gName;
    private $cTeamSize;
    private $cMaxTeams;
    private $cRegistrations;
    
    function getCId() {
        return $this->cId;
    }
    
    function getCName() {
        return $this->cName;
    }

    function getGId() {
        return $this->gId;
    }

    function getCTeamSize() {
        return $this->cTeamSize;
    }

    function getCMaxTeams() {
        return $this->cMaxTeams;
    }

    function getCRegistrations() {
        return $this->cRegistrations;
    }
    
    function setCId($cId) {
        $this->cId = $cId;
    }

    function setCName($cName) {
        $this->cName = $cName;
    }

    function setGId($gId) {
        $this->gId = $gId;
    }

    function setCTeamSize($cTeamSize) {
        $this->cTeamSize = $cTeamSize;
    }

    function setCMaxTeams($cMaxTeams) {
        $this->cMaxTeams = $cMaxTeams;
    }

    function setCRegistrations($cRegistrations) {
        $this->cRegistrations = $cRegistrations;
    }
    
    function getGName() {
        return $this->gName;
    }

    function setGName($gName) {
        $this->gName = $gName;
    }
    
    function construct($conn, $id)
    {
        $query = $conn->prepare('SELECT * FROM tblcompos WHERE cId=?');
        $id = mysqli_real_escape_string($conn, $id);
        $query->bind_param('s', $id);
        $query->execute();
        $result = $query->get_result();
        
        if (mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $this->setCId($row['cId']);
            $this->setCName($row['cName']);
            $this->setGId($row['gId']);
            $this->setGName($this->getGameName($conn, $id));
            $this->setCTeamSize($row['cTeamSize']);
            $this->setCMaxTeams($row['cMaxTeams']);
            $this->setCRegistrations($row['cRegistrations']);
            $registrationsText = $this->createRegistrationsText($this->getCRegistrations());
        }
    }
    
    public function update($conn)
    {
        $cId = mysqli_real_escape_string($conn, $this->getCId());
        $cName = mysqli_real_escape_string($conn, $this->getCName());
        $gId = mysqli_real_escape_string($conn, $this->getGId());
        $cTeamSize = mysqli_real_escape_string($conn, $this->getCTeamSize());
        $cMaxTeams = mysqli_real_escape_string($conn, $this->getCMaxTeams());
        
        $query = $conn->prepare('UPDATE tblcompos
                SET cName=?, gId=?, cTeamSize=?, cMaxTeams=?
                WHERE cId=?');
        $query->bind_param('sssss', $cName, $gId, $cTeamSize, $cMaxTeams, $cId);
        $query->execute();
    }
    
    public function updateRegistrations($conn)
    {
        $cId = mysqli_real_escape_string($conn, $this->getCId());
        $cRegistrations = mysqli_real_escape_string($conn, $this->getCRegistrations());
        
        $query = $conn->prepare('UPDATE tblcompos
                SET cRegistrations=?
                WHERE cId=?');
        $query->bind_param('ss', $cRegistrations, $cId);
        $query->execute();
    }
    
    function listCompos($conn)
    {
        $query = $conn->prepare('SELECT * FROM tblcompos');
        $query->execute();
        $result = $query->get_result();
        if (mysqli_num_rows($result) > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $gameName = $this->getGameName($conn, $row['gId']);
                $row['gName'] = $gameName;
                
                $registrations = $this->createRegistrationsText($row['cRegistrations']);
                $row['cRegistrationsText'] = $registrations;
                
                $compos[] = $row;
            }
            return $compos;
        }
        return array();
    }
    
    private function getGameName($conn, $id)
    {
        $query = $conn->prepare("SELECT gName FROM tblgames WHERE gId=?");
        $id = mysqli_real_escape_string($conn, $id);
        $query->bind_param('s', $id);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        return $row['gName'];
    }
    
    private function createRegistrationsText($regis)
    {
        $registrations = ($regis == 0) ? 'Closed' : 'Open';
        return $registrations;
    }

}

?>