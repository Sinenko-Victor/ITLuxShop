<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Mail extends Controller_Index {
    
    public function action_index() {
        
        echo"Mail - test";
        $to = 'v@sinenko.in.ua';
        $subject = 'Проверка работы почты'; //Тема сообщения
        $message = 'Текст сообщения';
        echo"to: ".$to."<br />subject: ".$subject."<br />from: <br />message: ".$message;
        //$email = Email::send($to, $this->mail_from, $subject, $message, $html = true);
        
        //mail($to, $subject, $message, 'From: Василий <info@kran.itlux.com.ua>');              
    }     
     

} 