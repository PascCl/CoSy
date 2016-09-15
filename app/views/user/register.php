<?php

$register = $data['register'];

if ($register)
{
    echo "Registration successful.";
} else
{
    $name = htmlspecialchars($data['name']);
    $mail = htmlspecialchars($data['mail']);

    $nameError = htmlspecialchars($data['nameError']);
    $mailError = htmlspecialchars($data['mailError']);
    $passError = htmlspecialchars($data['passError']);

    echo "<form method='post'>
            <table>
            <tr><th width='160px'></th><th width='180px'></th><th></th></tr>
            <tr><td>Name:</td><td><input type='text' name='name' value='$name'></td><td>$nameError</td></tr>
            <tr><td>E-mail:</td><td><input type='text' name='mail' value='$mail'></td><td>$mailError</td></tr>
            <tr><td>Password:</td><td><input type='password' name='pass'></td><td>$passError</td></tr>
            <tr><td></td><td><input type='submit' value='Register'></td><td></td></tr>
            </table>
            </form>";
}

?>