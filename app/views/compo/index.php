<?php

$compos = $data['compos'];

echo '<table border="1"><tr>'
    . '<th width="150">Name</th>'
    . '<th width="150">Game</th>'
    . '<th width="150">Team Size</th>'
    . '<th width="150">Max Teams</th>'
    . '<th width="150">Registrations</th>'
    . '<th border="0" width="100"></th></tr>';

foreach($compos as $compo)
{
    echo '<tr><td>' . $compo["cName"] . '</td>'
        . '<td>' . $compo["gName"] . '</td>'
        . '<td>' . $compo["cTeamSize"] . '</td>'
        . '<td>' . $compo["cMaxTeams"] . '</td>'
        . '<td>' . $compo["cRegistrationsText"] . '</td>'
        . '<td><a href="/compo/newteam/' . $compo['cId'] . '/">Create Team</a></td></tr>';
}

echo '</table>';

?>