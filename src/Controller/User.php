<?php

namespace Upvote\Controller;

use Framework\Base;

class User extends Base\Controller {
    
    public function create() {
        $error = null;
        
        // Do the create
        if(isset($_POST['create'])) {
            if(empty($_POST['username']) || empty($_POST['email']) ||
               empty($_POST['password']) || empty($_POST['password_check'])) {
                $error = 'You did not fill in all required fields.';
            }
            
            if(is_null($error)) {
                if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                    $error = 'Your email address is invalid';
                }
            }
            
            if(is_null($error)) {
                if($_POST['password'] != $_POST['password_check']) {
                    $error = "Your passwords didn't match.";
                }
            }
            
            if(is_null($error)) {
                $check_sql = 'SELECT * FROM user WHERE username = :username';
                $result = $this->adapter->fetchOne(array('username' => $_POST['username']));
                if(count($result) > 0) {
                    $error = 'Your chosen username already exists. Please choose another.';
                }
            }
            
            if(is_null($error)) {
                $params = array(
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => md5($_POST['username'] . $_POST['password']),
                );
            
                $sql = 'INSERT INTO user (username, email, password) VALUES (:username, :email, :password)';
                $this->adapter->query($sql, $params);
                header("Location: /user/login");
                exit;
            }
        }
        // Show the create form
        
        $content = '
            <form method="post">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="username" value="" /><br />
                <label>Email</label> <input type="text" name="email" value="" /><br />
                <label>Password</label> <input type="password" name="password" value="" /><br />
                <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
                <input type="submit" name="create" value="Create User" />
            </form>
        ';
        
        require_once '../layout.phtml';
        
    }
    
    public function account() {
        $error = null;
        if(!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }
        
        if(isset($_POST['updatepw'])) {
            if(!isset($_POST['password']) || !isset($_POST['password_check']) ||
               $_POST['password'] != $_POST['password_check']) {
                $error = 'The password fields were blank or they did not match. Please try again.';       
            }
            else {
                $sql = 'UPDATE user SET password = :password WHERE username = :username';
                $this->adapter->query($sql, ['password' => md5($_SESSION['username'] . $_POST['password']), 'username' => $_SESSION['username']]);
                $error = 'Your password was changed.';
            }
        }

        $dsql = 'SELECT * FROM user WHERE username = :username';
        $details = $this->adapter->fetchOne($dsql, array('username' => $_SESSION['username']));

        $content = '
        ' . $error . '<br />
        
        <label>Username:</label> ' . $details['username'] . '<br />
        <label>Email:</label>' . $details['email'] . ' <br />
        
         <form method="post">
                ' . $error . '<br />
            <label>Password</label> <input type="password" name="password" value="" /><br />
            <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
            <input type="submit" name="updatepw" value="Create User" />
        </form>';
        
        require_once '../layout.phtml';
    }

    public function login() {
        $error = null;
        // Do the login
        if(isset($_POST['login'])) {
            $username = $_POST['user'];
            $password = $_POST['pass'];
            $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
            $sql = 'SELECT * FROM user WHERE username = :username AND password = :password LIMIT 1';
            $results = $this->adapter->fetchOne($sql, ['username' => $username, 'password' => $password]);
            if($results) {
               $data = $results;
               session_regenerate_id();
               $_SESSION['username'] = $data['username'];
               $_SESSION['AUTHENTICATED'] = true;
               header("Location: /");
               exit;
            }
            else {
                $error = 'Your username/password did not match.';
            }
        }
        
        $content = '
            <form method="post">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="user" value="" />
                <label>Password</label> <input type="password" name="pass" value="" />
                <input type="submit" name="login" value="Log In" />
            </form>
        ';
        
        require_once('../layout.phtml');
        
    }
    
    public function logout() {
        // Log out, redirect
        session_destroy();
        header("Location: /");
    }
}