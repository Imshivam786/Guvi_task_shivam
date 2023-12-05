<?php

require 'functions.php';


if(!empty($_POST['data_type'] ))
{
    $info['data_type'] = $_POST['data_type'];
    $info['errors'] = [];
    $info['success'] = false;
    
    if($_POST['data_type'] == "register")
    {
        // validate firstname
        if(empty($_POST['firstname']))
        {
            $info['errors']['firstname'] = "A first name is required";
        }else
        if(!preg_match("/^[\p{L}]+$/", $_POST['firstname']))
        {
            $info['errors']['firstname'] = "First name can't have special characters or spaces or numbers";
        }

        // validate lastname
        if(empty($_POST['lastname']))
        {
            $info['errors']['lastname'] = "A lastname is required";
        }else
        if(!preg_match("/^[\p{L}]+$/", $_POST['lastname']))
        {
            $info['errors']['lastname'] = "Last name can't have special characters or spaces or numbers";
        }
        // validate gender
        if(empty($_POST['gender']))
        {
            $info['errors']['gender'] = "A gender is required";
        }

        // validate email
        if(empty($_POST['email']))
        {
            $info['errors']['email'] = "An email is required";
        }else
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        {
            $info['errors']['email'] = "Email is not valid ";
        }
        

        // validate password
        if(empty($_POST['password']))
        {
            $info['errors']['password'] = "A password is required";
        }else
        if($_POST['password'] !== $_POST['retype_password'])
        {
            $info['errors']['password'] = "Password don't match";
        }

        if(empty($info['errors']))
        {
            // using sql prepared statements to avoid sql injections
            $arr['firstname'] = $_POST['firstname'];
            $arr['lastname'] = $_POST['lastname'];
            $arr['email'] = $_POST['email'];
            $arr['gender'] = $_POST['gender'];
            $arr['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $arr['date'] = date('Y-m-d H:i:s');

            db_query("insert into users (firstname,lastname,gender,password,date,email) values (:firstname,:lastname,:gender,:password,:date,:email)",$arr);

            $info['success'] = true;
            

        }
    } else 
    if($_POST['data_type'] == "profile-edit")
    {
        // validate firstname
        if(empty($_POST['firstname']))
        {
            $info['errors']['firstname'] = "A first name is required";
        }else
        if(!preg_match("/^[\p{L}]+$/", $_POST['firstname']))
        {
            $info['errors']['firstname'] = "First name can't have special characters or spaces or numbers";
        }

        // validate lastname
        if(empty($_POST['lastname']))
        {
            $info['errors']['lastname'] = "A lastname is required";
        }else
        if(!preg_match("/^[\p{L}]+$/", $_POST['lastname']))
        {
            $info['errors']['lastname'] = "Last name can't have special characters or spaces or numbers";
        }
        // validate gender
        if(empty($_POST['gender']))
        {
            $info['errors']['gender'] = "A gender is required";
        }

        // validate email
        if(empty($_POST['email']))
        {
            $info['errors']['email'] = "An email is required";
        }else
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        {
            $info['errors']['email'] = "Email is not valid ";
        }
        

        // validate password
        if(!empty($_POST['password']))
        {
            if($_POST['password'] !== $_POST['retype_password'])
            {
                $info['errors']['password'] = "Password don't match";
            }
        }

        if(empty($info['errors']))
        {
            // using sql prepared statements to avoid sql injections
            $arr['firstname'] = $_POST['firstname'];
            $arr['lastname'] = $_POST['lastname'];
            $arr['email'] = $_POST['email'];
            $arr['gender'] = $_POST['gender'];
            $arr['date'] = date('Y-m-d H:i:s');

            if(!empty($_POST['password'])){
                $arr['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                db_query("update users  set firstname = :firstname,lastname = :lastname,gender = :gender,password = :password,date = :date,email = :email",$arr);
            }else{
                db_query("update users set firstname = :firstname,lastname = :lastname,gender = :gender,date = :date,email=:email",$arr);
            }
            $info['success'] = true;
        }
    
}
    echo json_encode($info);
}


