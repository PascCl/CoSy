<?php

class User
{
    private $uId;
    private $uName;
    private $uPass;
    private $uPowers;
    
    /*public function __construct($uId = '', $uName = '', $uPass = '', $uPowers = '')
    {
        if ($uId === '')
        {
            this::findUId();
        } else 
        {
            $this->uId = $uId;
        }
        
        $this->uName = $uName;
        $this->uPass = $uPass;
        
        if ($uPowers === '')
        {
            this::findUPowers();
        } else
        {
            $this->uPowers = $uPowers;
        }
    }*/
    
    function getUId()
    {
        return $this->uId;
    }
    
    function setUId($uId)
    {
        $this->uId = $uId;
    }
    
    function getUName()
    {
        return $this->uName;
    }

    function setUName($uName)
    {
        $this->uName = $uName;
    }
    
    function setUPass($uPass)
    {
        $this->uPass = $uPass;
    }

    function getUPowers()
    {
        return $this->uPowers;
    }

    function setUPowers($conn)
    {
        $query = $conn->prepare('SELECT * FROM tbluserpowers WHERE uId=?');
        $id = mysqli_real_escape_string($conn, $this->getUId());
        $query->bind_param('s', $id);
        $query->execute();
        $result = $query->get_result();
        if (mysqli_num_rows($result) > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $power = $row['uPower'];
                $uPowers[$power] = true;
            }
            $this->uPowers = $uPowers;
        }
    }
    
    public function checkLogin($conn, $name, $pass)
    {
        $name = mysqli_real_escape_string($conn, $name);
        $query = $conn->prepare('SELECT * FROM tblusers WHERE uName=?');
        $query->bind_param('s', $name);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        
        if ($result->num_rows == 1 && password_verify($pass, $row['uPass']))
        {   
            $this->setUId($row['uId']);
            $this->setUName($row['uName']);
            $this->setUPass($row['uPass']);
            $this->setUPowers($conn);
            return true;
        } else
        {
            return false;
        }
    }

}

?>