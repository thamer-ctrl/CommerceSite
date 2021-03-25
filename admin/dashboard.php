<?php
    session_start();
    
    #$noNavbar='';

    if(isset($_SESSION['username'])){
        $pageTitle="Dashboard";
        include 'init.php';
        
        include "navbar.php";
        #print_r($_SESSION);
        
    }else{

        header('location: index.php');
        exit();
    }