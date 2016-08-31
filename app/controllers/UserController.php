<?php

class UserController extends Controller
{
    public function index()
    {
        echo "Index of User.";
    }
    
    
    public function login()
    {
        if ($_SESSION['logged_in'] === false)
        {
            $name = '';
            $error = '';
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                if (!empty($_POST['name']) && !empty($_POST['pass']))
                {
                    $user = $this->model('User'); //create user object
                    $name = $_POST['name'];
                    $pass = $_POST['pass'];
                    
                    $database = Database::getInstance();
                    
                    if ($user->checkLogin($database->getConnection(), $name, $pass))
                    {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['uId'] = $user->getUId();
                        $_SESSION['uName'] = $user->getUName();
                        $_SESSION['uPowers'] = $user->getUPowers(); //only use this to show menu options - always check database for any action that requires powers!
                        header('Location: /home/index');
                        die();
                    }
                }
                $error = 'Wrong name or password.';
            }

            $this->view('user/login', ['name' => htmlspecialchars($name), 'error' => $error]);
        } else
        {
            $this->view('home/index');
        }
    }
    
    
    public function logout()
    {
        if ($_SESSION['logged_in'] == true) {
            session_destroy();
            header('Location: /home/index');
            die();
        }
    }
}