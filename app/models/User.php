<?php

class User
{
    private $uId;
    private $uName;
    private $uPass;
    private $uPowers; //array of powers with value true/false: $uPowers[0] == true
    
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
    
    function construct($conn, $id)
    {
        $id = mysqli_real_escape_string($conn, $id);
        $query = $conn->prepare('SELECT * FROM tblusers WHERE uId=?');
        $query->bind_param('s', $id);
        $query->execute();
        $result = $query->get_result();
        if (mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $this->setUId($row['uId']);
            $this->setUName($row['uName']);
            $this->setUPass($row['uPass']);
            $this->setUPowers($conn);
        }
    }
    
    public function checkLogin($conn, $name, $pass)
    {
        $name = mysqli_real_escape_string($conn, $name);
        $query = $conn->prepare('SELECT uId, uPass FROM tblusers WHERE uName=?');
        $query->bind_param('s', $name);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        
        if ($result->num_rows == 1 && password_verify($pass, $row['uPass']))
        {   
            $this->construct($conn, $row['uId']);
            return true;
        } else
        {
            return false;
        }
    }
    
    function checkPowers($conn, $reqPower)
    {
        $error = true;

        $uPowers = $this->getUPowers($conn); //returns an array of powers with value true, example: $uPowers[1] == true
        //check if the required power is set
        if (array_key_exists($reqPower, $uPowers) && $uPowers[$reqPower]) {
            $error = false;
        }

        if ($error)
        {
            //add logging
            //
            echo "Please don't hack my site!<br>
                Actually, do hack my site and contact me when you find something I should fix.";
            session_destroy();
            die();
        } else
        {
            return true;
        }
    }
    
    public function checkRegister($conn, $name, $mail, $pass)
    {
        $name = mysqli_real_escape_string($conn, $name);
        $mail = mysqli_real_escape_string($conn, $mail);
        $pass = mysqli_real_escape_string($conn, $pass);
        $query = $conn->prepare('SELECT uId FROM tblusers WHERE uName=? OR uMail = ?');
        $query->bind_param('ss', $name, $mail);
        $query->execute();
        $result = $query->get_result();
        
        if ($result->num_rows == 0)
        {   
            $query = $conn->prepare('INSERT INTO tblUsers (uName, uPass, uMail) VALUES (?, ?, ?)');
            $query->bind_param('sss', $name, $pass, $mail);
            $result = $query->execute();
            if ($result)
            {
                return true;
            }
        }
        
        return false;

    }

}

?>