<?php

$teamName = htmlspecialchars($data['team']->getTName());
$teamMembers = $data['teamMembers'];
$currentMembers = count($teamMembers);
$maxMembers = $data['compo']->getCTeamSize();

echo $teamName . '<br><br>';

echo "Members: (" . $currentMembers . " / " . $maxMembers . ")<br>";

foreach ($teamMembers as $teamMember)
{
    echo $teamMember->getTeamMemberUserName();
    if ($teamMember->getTeamMemberPowers() == 2)
        echo ": owner";
    elseif ($teamMember->getTeamMemberPowers() == 1)
        echo ": captain";
    else
        echo ": member";
}

?>