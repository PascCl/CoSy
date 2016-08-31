<?php

$name = htmlspecialchars($data['name']);
$error = htmlspecialchars($data['error']);

if ($error != '')
{
    echo $error . "<br><br>";
}

?>

<form method="post">
    <table>
        <tr><th width="160px"></th><th width="180px"></th><th></th></tr>
        <tr><td>Name:</td><td><input type="text" name="name" 
                                     value="<?php echo $name; ?>"></td></tr>
        <tr><td>Password:</td><td><input type="password" name="pass"></td></tr>
        <tr><td></td><td><input type="submit" value="Login"></td></tr>
    </table>
</form>