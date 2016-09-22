<?php

$cId = htmlspecialchars($data['compo']->getCId());
if (!is_numeric($cId))
    header('Location: /compo/index');
$gId = htmlspecialchars($data['compo']->getGId());
$cName = htmlspecialchars($data['compo']->getCName());
$cTeamSize = htmlspecialchars($data['compo']->getCTeamSize());
$cMaxTeams = htmlspecialchars($data['compo']->getCMaxTeams());
$cRegistrations = htmlspecialchars($data['compo']->getCRegistrations());
$teamId = htmlspecialchars($data['team']->getTId());
if ($teamId != false)
{
    $teamName = htmlspecialchars($data['team']->getTName());
}

echo "Compo: " . $cName . "<br>"
        . "Team Size: " . $cTeamSize . "<br>"
        . "Max Teams: " . $cMaxTeams . "<br><br>";

if ($teamId == false)
    echo '<a href="/compo/newteam/' . $cId . '">Create Team</a>';
else
    echo 'Your team: <a href="/compo/team/' . $cId . '/' . $teamId . '">' . $teamName . '</a>';

echo "<br><br>";

echo "All teams:<br>";
if (is_array($data['teamList']))
{
    foreach ($data['teamList'] as $team)
    {
        echo '<a href="/compo/team/' . $cId . '/' . $team["tId"] . '">' . $team['tName'] . "</a><br>";
    }
}


?>