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


// Add Members //

?>
<script>
function findUsers(str) {
    if (str == "") {
        document.getElementById("livesearch").innerHTML = "no suggestions";
        xmlhttp.send();
    } else {
        if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
        } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var actualResponse = xmlhttp.responseText;
                        actualResponse = actualResponse.split("_split88after99this_").pop();
                        document.getElementById("livesearch").innerHTML = actualResponse;
                }
        };
        xmlhttp.open("GET","/user/search/"+str,true);
        xmlhttp.send();
    }
}
</script>
<?php

echo "<br><br><form action='' method='post'>
    <input type='text' name='username' oninput='findUsers(this.value)' list='livesearch'>
    <datalist id='livesearch'></datalist>
    <input type='submit' value='Add Member'>";

?>