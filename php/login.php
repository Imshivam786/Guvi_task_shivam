<?php

require 'functions.php';

if(!empty($_POST['data_type'] ))
{
    $info['data_type'] = $_POST['data_type'];
    $info['errors'] = [];
    $info['success'] = false;
    
    if($_POST['data_type'] == "login")
    {
        // validate email
        if(empty($_POST['email']))
        {
            $info['errors']['email'] = "An email is required";
        }else
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        {
            $info['errors']['email'] = "Email is not valid ";
        }

        if(empty($info['errors']))
        {
            // using sql prepared statements to avoid sql injections
            
            $arr = [];
        $arr['email'] = $_POST['email'];

        $row = db_query("select * from users where email = :email limit 1",$arr);
        // print_r($row);
            if(!empty($row))
            {
            $row = $row[0];
            // checking password
            if(password_verify($_POST['password'], $row['password'])){
                //password correct
                $info['success'] = true;
                $_SESSION['PROFILE'] = $row;
            }else{
                $info['errors']['email'] = "Wrong email or password";
            }
        } else{
            $info['errors']['email'] = "Wrong email or password";
        }

        }
    }
    echo json_encode($info);
}
