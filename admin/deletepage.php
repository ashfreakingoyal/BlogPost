<?php
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    session_start();
    if(!isset($_GET['id'])){
        header("Location: page.php?message=Please+Click+the+Delete+button");
        exit();

    } else{
        if(!isset($_SESSION['author_role'])){
            header("Location: login.php?message=Please+login");
             exit();
        } else{
            if($_SESSION['author_role']!="admin"){
                echo "You cannot access this page";
            }else{
                $page_id=$_GET['id'];
                $sql="SELECT * FROM `page` WHERE page_id='$page_id';";
                $result= mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)<=0){
                    //we dont have any page
                    header("Location: page.php?message=No+page+found");
                   exit();

                }else{
                    $page_id= $_GET['id'];
                    $sql= "DELETE FROM `page` WHERE page_id='$page_id';";
                   if(mysqli_query($conn,$sql)){
                    header("Location: page.php?message=page+deleted");
                    exit();
                   } else{
                    header("Location: page.php?message=could+not+delete+your+page");
                    exit();
                   }
                }
            }
        }
    }

?>