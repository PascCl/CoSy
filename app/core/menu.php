<div id='dolphincontainer'>
    <div id='dolphinnav'>
        <ul>
            <li><a href="/home/index"><span>Home</span></a></li>
            <li><a href="/compo/index"><span>Tournaments</span></a></li>
            <?php
            if ($_SESSION['logged_in'] == false) {
                echo '<li><a href="/user/login"><span>Login</span></a></li>
                    <li><a href="/user/register"><span>Register</span></a></li>';
            }
            if ($_SESSION['logged_in'] == true) {
                $uName = htmlspecialchars($_SESSION['uName']);
                $uPowers[3] = $_SESSION['uPowers'][3];
                if ($uPowers[3]) {
                        echo '<li><a href="/admin/index"><span>Admin</span></a></li>';
                }
                echo '<li><a href="/user/profile/"><span>' . $uName . '</span></a></li>';
                echo '<li><a href="/user/logout"><span>Logout</span></a></li>';
            }
            ?>
        </ul>
    </div>
</div><br>