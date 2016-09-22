<?php

class CompoController extends Controller
{
    public function index($name = '')
    {
        $database = Database::getInstance();
        $compo = $this->model('Compo');
        $compos = $compo->listCompos($database->getConnection());
        $this->view('compo/index', ['compos' => $compos]);
    }
    
    public function compo($cId = '')
    {
        if ($cId == '')
            header('Location: /compo/index');
        
        $database = Database::getInstance();
        $compo = $this->model('Compo');
        $team = $this->model('Team');
        $compo->construct($database->getConnection(), $cId);
        $teamId = $team->checkIfUserHasTeam($database->getConnection(), $_SESSION['uId'], $cId);
        if ($teamId != false)
            $team->construct($database->getConnection(), $teamId);
        $teamList = $team->getAllTeams($database->getConnection(), $cId);
        $this->view('compo/compo', ['compo' => $compo, 'team' => $team, 'teamList' => $teamList]);
    }
    
    public function newTeam($cId)
    {
        $database = Database::getInstance();
        $team = $this->model('Team');
        
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
    
    public function team($cId = '', $teamId = '')
    {
        if ($cId == '')
            header('Location: /compo/index');
        if ($teamId == '')
            header('Location: /compo/compo/' . $cId);
        
        $database = Database::getInstance();
        $team = $this->model('Team');
        $teamMember = $this->model('TeamMember');
        $compo = $this->model('Compo');

        $team->construct($database->getConnection(), $teamId);
        $compo->construct($database->getConnection(), $cId);
        $teamMemberIds = $team->getTeamMembers($database->getConnection());
        $teamMembers = "";
        $count = 0;
        foreach ($teamMemberIds as $teamMemberId)
        {
            $teamMembers[$count] = new TeamMember();
            $teamMembers[$count]->construct($database->getConnection(), $teamId, $teamMemberId['uId']);
            $count++;
        }
        $this->view('compo/team', ['compo' => $compo, 'team' => $team, 'teamMembers' => $teamMembers]);

    }

}

?>