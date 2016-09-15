<?php

$gId = $data['compo']->getGId();
$cName = $data['compo']->getCName();
$cTeamSize = $data['compo']->getCTeamSize();
$cMaxTeams = $data['compo']->getCMaxTeams();
$cRegistrations = $data['compo']->getCRegistrations();

$error = $data['error'];

if ($error != '')
    echo $error . '<br><br>';

echo "<form method='post'><table>
    <tr><td>Name:</td><td><input type='text' name='cName' value='" . $cName . "'></td></tr>
    <tr><td>Game: </td><td><select name='gId'>
        <option value='1'" . (($gId == 1) ? 'selected' : '') . ">League of Legends</option>
        <option value='2'" . (($gId == 2) ? 'selected' : '') . ">Counter-Strike: Global Offensive</option>
    </select></td></tr>
    <tr><td>Team size:</td><td><input type='text' name='cTeamSize' value='" . $cTeamSize . "'></td></tr>
    <tr><td>Max teams:</td><td><input type='text' name='cMaxTeams' value='" . $cMaxTeams . "'></td></tr>
    <tr><td></td><td><input type='submit' value='Save'></td></tr>
    </table></form><br><br>";

	
//registrations

if ($cRegistrations == 0) {
    echo "<form method='post'><input type='hidden' name='cRegistrations' value='1'>Registrations closed - <input type='submit' value='Open registrations'>";
} else {
    echo "<form method='post'><input type='hidden' name='cRegistrations' value='0'>Registrations open - <input type='submit' value='Close registrations'>";
}
echo "<br><br><br>";

?>