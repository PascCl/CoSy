<?php

$compos = $data['compos'];

echo '<table border="1"><tr>'
    . '<th width="150">Name</th>'
    . '<th width="150">Game</th>'
    . '<th width="150">Team Size</th>'
    . '<th width="150">Max Teams</th>'
    . '<th width="150">Registrations</th>';

foreach($compos as $compo)
{
    echo '<tr><td><a href="/compo/compo/' . $compo["cId"] . '">' . $compo["cName"] . '</a></td>'
        . '<td>' . $compo["gName"] . '</td>'
        . '<td>' . $compo["cTeamSize"] . '</td>'
        . '<td>' . $compo["cMaxTeams"] . '</td>'
        . '<td>' . $compo["cRegistrationsText"] . '</td>';
}

echo '</table>';

?>