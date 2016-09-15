<?php

if (isset($data['error']))
{
    if ($data['error'] != "")
    {
        $error = htmlspecialchars($data['error']);
        echo $error . "<br><br>";
    }
}

echo '<form method="post">
    Team name:
    <input type="textbox" name="teamname">
    <input type="submit">
    </form>';

?>