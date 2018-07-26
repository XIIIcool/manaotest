<?php

class Db{
    
    private $filename;


    public function __construct($file) {
        $this->filename = $file;
        
        if(!file_exists('db/'.$file)){
            
            $str = '<?xml version="1.0" encoding="utf-8"?>
            <xml>
            </xml>';
            $xml = new SimpleXMLElement($str);
            $xml->asXML('db/'.$file);
            
        }
    }
    
    public function insert($data = []){
        
	$xml = simplexml_load_file('db/'.$this->filename);
        $user = $xml->addChild('user');
        foreach($data as $key=>$value){
            $user->addChild($key,$value);
        }    
       
        $xml->asXML('db/'.$this->filename);

    }
    
    public function search($params = []){
        if(count($params>0)){
            $xml = simplexml_load_file('db/'.$this->filename);
      
            foreach($params as $key=>$value){
                
                foreach($xml->user as $user){
                    
                     if($user->$key == $value){
                        
                        return false;
                    }
                }
            }
            return true;
        } 
    }
    
    public function searchUser($params = []){
        if(count($params>0)){
            $xml = simplexml_load_file('db/'.$this->filename);
            
      
                foreach($xml->user as $user){
                
                     if($user->login == $params['login'] && $user->password == $params['password']){
                        return $user;
                        
                    }
                }
            
            return false;
        } 
    }
    
    public function insertcode($code,$login)
    
    {
     $xml = simplexml_load_file('db/'.$this->filename);

                foreach($xml->user as $user){
                
                     if($user->login == $login){
                         $user->code = $code;
    
                    }
                } 
                $xml->asXML('db/'.$this->filename);
    }
    
    public function checkCode($code,$login){
          
    
     $xml = simplexml_load_file('db/'.$this->filename);

                foreach($xml->user as $user){
                
                     if($user->login == $login && $user->code = $code){
                         
                        return $user;    
                    }
                } 
                $xml->asXML('db/'.$this->filename);
    
      return false;
    }

    
}

class User{
    public function checkUserCode(){
        if (isset($_SESSION['login']) and isset($_SESSION['name'])) return true;
            else {
              
              if (isset($_COOKIE['login']) and isset($_COOKIE['code'])) {
              
                $helper = new Helper();
                $db = new Db('database.xml');
                
                $code=$helper->clear_input($_COOKIE['code']);
                $login = $_COOKIE['login'];
                $user = $helper->xml2array($db->checkCode($code, $login));
                  if ($user) {
                  
               
                   $_SESSION['auth'] = true;
                   $_SESSION['name'] = $user['name'];
                    $_SESSION['login'] = $user['login'];

                setcookie("login", $_SESSION['login'], time()+3600*24*14);
                setcookie("name", $_SESSION['name'], time()+3600*24*14);
                setcookie("code", $code, time()+3600*24*14);
                    return true;
                  } else return false; 
                
              } else return false;
            }
    }
}

class Helper{
    public function clear_input($text){
        
        $text = filter_var($text,FILTER_SANITIZE_EMAIL);

	$code_match = ['-', '"', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', ';', "'", ',', '.', '/', '\\', '~', '`', '='];
	$text = str_replace($code_match, '', $text);
	

        return trim(strip_tags($text));
    }
    
    public function xml2array ( $xmlObject, $out = array () )
            
    {
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

     return $out;
    
    }

    
    public function generateCode($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;  
        while (strlen($code) < $length) {
          $code .= $chars[mt_rand(0,$clen)];  
        }
        return $code;
    }
}

