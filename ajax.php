<?php
require_once 'config.php';
require_once 'class.php';

$helper = new Helper();
$db = new Db('database.xml');


if(isset($_POST)){
    switch($_POST['method']){
        case "register":
           $error = 0;
            
           parse_str($_POST['data'], $data);

           $login = $helper->clear_input($data['login']); 
           $name = $helper->clear_input($data['name']); 
           $email = $data['email']; 
           $password = $helper->clear_input($data['password']); 
           $confirm_password = $helper->clear_input($data['confirm_password']); 
           
           if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
               $error++;
               $error_text .= ' wrong email '; 
           }
           if($login == '' && $name == '' && $email == '' && $password == '' && $confirm_password == ''){
               $error++;
              $error_text .= ' empty all input '; 
           }
           if($password != $confirm_password){
               $error++;
               $error_text .= ' Passwords do not match '; 
               
           }
           
           
           if(!$db->search(["login"=>$login,'email'=>$email])){
               $error++;
               $error_text .= ' Login or email already exists '; 
           } else {
                if($error == 0){
                    $db->insert(['login'=>$login,
                        'name'=>$name,
                        'email'=>$email,
                        'password'=>md5($config['salt'].$password),
                        'code'=>'000'
                        ]);
                    
                    $result['status'] = 'OK';
                    $result['text'] = 'Successful registration';
                } 
            }
            
            if($error > 0){
                $result['status'] = 'ERROR';
                $result['text'] = 'Registration error: '.$error_text;
            }
            
            header('Content-Type: application/json');
            echo json_encode($result);
            
        break;
        case "auth":
            $error = 0;
            parse_str($_POST['data'], $data);
            $login = $helper->clear_input($data['login']); 
            $password = $helper->clear_input($data['password']);
            $password = md5($config['salt'].$password);
            $request = $db->searchUser(["login"=>$login,'password'=>$password]);
            if($request){
                $user = $helper->xml2array($request);
                $code = $helper->generateCode(8);
                $db->insertcode($code, $user['login']);
                
                $_SESSION['auth'] = true;
                $_SESSION['name'] = $user['name'];
                $_SESSION['login'] = $user['login'];
                
              
                
                setcookie("login", $_SESSION['login'], time()+3600*24*14);
                setcookie("name", $_SESSION['name'], time()+3600*24*14);
                setcookie("code", $code, time()+3600*24*14);
               
                
               
                
                $result['status'] = 'OK';
                $result['text'] = 'Authorization successful';
            }else {
                $result['status'] = 'ERROR';
                $result['text'] = 'Authorization error';
            } 
                header('Content-Type: application/json');
                echo json_encode($result);
        break;
        case "logout":
            session_destroy();
            setcookie("login", '', time()-3600);
            setcookie("name", '', time()-3600);
        break;
    }
}