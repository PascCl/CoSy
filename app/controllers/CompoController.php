<?php

class CompoController extends Controller
{
    public function index($name = '')
    {
        $database = Database::getInstance();
        $compo = $this->model('Compo'); //create compo object
        $compos = $compo->listCompos($database->getConnection());
        $this->view('compo/index', ['compos' => $compos]);
    }
    
    public function compo($cId = '')
    {
        if ($cId == '')
            header('Location: /compo/index');
        
        $database = Database::getInstance();
        $compo = $this->model('Compo'); //create compo object
        $team = $this->model('Team'); //create team object
        $compo->construct($database->getConnection(), $cId);
        //returns false if usr has no team, returns teamid if user has a team for this compo
        $teamId = $team->checkIfUserHasTeam($database->getConnection(), $_SESSION['uId'], $cId);
        if ($teamId != false)
            $team->construct($database->getConnection(), $teamId);
        $this->view('compo/compo', ['compo' => $compo, 'team' => $team]);
    }
    
    public function newTeam($cId)
    {
        $database = Database::getInstance();
        $team = $this->model('Team'); //create team object
        
        $error = "";
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['teamname']))
            {
                $error = $team->createTeam($database->getConnection(), $_POST['teamname'], $cId, $_SESSION['uId']);
                if ($error === true)
                {
                    $cId = htmlspecialchars($cId);
                    header('Location: /compo/team/' . $cId);
                    die();
                } else
                {
                    $this->view('compo/newteam', ['error' => $error]);
                }
            }
        }
        
        $this->view('compo/newteam');
    }
    
    public function team($cId)
    {
        $database = Database::getInstance();
        $team = $this->model('Team'); //create team object
        $team->construct($database->getConnection(), $_SESSION['uId']);
    }

}

?>