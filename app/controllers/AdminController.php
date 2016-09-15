<?php

if (!isset($_SESSION['uId']))
{
    session_destroy();
    header('Location: /home/index');
    die();
}

class AdminController extends Controller
{
    
    function checkAdmin($conn, $reqPow = 3)
    {
        $user = $this->model('User'); //create user object
        $user->construct($conn, $_SESSION['uId']);
        if (!$user->checkPowers($conn, $reqPow))
        {
            //should never happen, will die in function checkPowers
            session_destroy();
            die();
        }
    }
    
    public function index($name = '')
    {
        $database = Database::getInstance();
        $this->checkAdmin($database->getConnection());
        $compo = $this->model('Compo'); //create compo object
        $compos = $compo->listCompos($database->getConnection());
        $this->view('admin/index', ['compos' => $compos]);
    }
    
    public function compo($cId = '')
    {
        if ($cId == '')
        {
            die();
        }
        
        $database = Database::getInstance();
        $this->checkAdmin($database->getConnection(), 3);
        $compo = $this->model('Compo'); //create compo object
        $compo->construct($database->getConnection(), $cId);
        
        //validate form data
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (isset($_POST['cName']) && isset($_POST['gId'])
                    && isset($_POST['cTeamSize']) && isset($_POST['cMaxTeams']))
            {
                $cNameError = $compo->setCName($_POST['cName']);
                $gIdError = $compo->setGId($_POST['gId']);
                $cTeamSizeError = $compo->setCTeamSize($_POST['cTeamSize']);
                $cMaxTeamsError = $compo->setCMaxTeams($_POST['cMaxTeams']);
                $compo->update($database->getConnection());
            } elseif (!isset($_POST['cRegistrations']))
            {
                $error = "None of these fields can be left empty.";
            }

            if (isset($_POST['cRegistrations']))
            {
                $cRegistrationsError = $compo->setCRegistrations($_POST['cRegistrations']);
                $compo->updateRegistrations($database->getConnection());
            }
        }
        
        $this->view('admin/compo', ['compo' => $compo, 'error' => $error]);
    }
}

?>