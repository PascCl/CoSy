<?php

$cId = htmlspecialchars($data['compo']->getCId());
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
    echo $teamName;

?>