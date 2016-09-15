<?php

class UserController extends Controller
{
    public function index()
    {
        echo "Index of User.";
    }
    
    public function profile()
    {
        $this->view('user/profile', ['name' => $_SESSION['uName']]);
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

            $this->view('user/login', ['name' => $name, 'error' => $error]);
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
    
    public function register()
    {
        $name = '';
        $mail = '';

        $nameError = '';
        $mailError = '';
        $passError = '';
        $register = false;
        
        $error = false;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (!empty($_POST['name']))
            {
                $name = $_POST['name'];
            } else
            {
                $error = true;
                $nameError = "Name cannot be empty.";
            }
            
            if (!empty($_POST['mail']))
            {
                $mail = $_POST['mail'];
            } else
            {
                $error = true;
                $mailError = "E-mail cannot be empty.";
            }
            
            if (!empty($_POST['pass']))
            {
                $pass = $_POST['pass'];
            } else
            {
                $error = true;
                $passError = "Password cannot be empty.";
            }
            
            if (!$error)
            {
                $user = $this->model('User'); //create user object
                $database = Database::getInstance();
                    
                if ($user->checkRegister($database->getConnection(), $name, $mail, $pass))
                {
                    $register = true;
                } else
                {
                    $nameError = 'Username or e-mail address already exists.';
                }
            }
        }
        
        $this->view('user/register', ['register' => $register, 'name' => $name, 'mail' => $mail, 'nameError' => $nameError,
            'mailError' => $mailError, 'passError' => $passError]);
    }
}

?>