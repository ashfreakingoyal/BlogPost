<?php 
    session_start();
    include_once "../includes/functions.php";
    include_once "../includes/connection.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--css-stylesheet-->
    <link rel="stylesheet" href="..style/style.css">
     <!--bootstrap-file-->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <!--     <link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>-->
</head>
<body>

     
        
<!-------------------form------------------------->
<div style="width:500px;margin:auto auto;margin-top:250px;">
  
        <?php
             if(isset($_GET['message']))
             {
                 $msg=$_GET['message'];
                 echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">'
                 .$msg.'
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
                 ';
             }
        ?>
<!--login-form---------------------->
<form method="post" class="form-signin">
  <h1 class="h3 mb-3 font-weight-normal">Please Login</h1>
  
  <input type="email" name="author_email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
  <input type="password" name="author_password" id="inputPassword" class="form-control" placeholder="Password" required>
      <button name="signup" class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
  </form>
</div>
<!------------------------------------>
<?php
   if(isset($_POST['signup']))
   {    
       
       
       $author_email= mysqli_real_escape_string($conn,$_POST['author_email']);
       $author_password= mysqli_real_escape_string($conn,$_POST['author_password']);

       //checking for empty fields
        if(empty($author_email) OR empty($author_password))
        {
            header("Location: login.php?message=Empty+fields");
            exit();
        }

        //checking for validity of email
        if(!filter_var($author_email,FILTER_VALIDATE_EMAIL))
        {
            header("Location: login.php?message=Please+Enter+A+Valid+Email");
            exit();
        }
        else{
            
               //if email doesnot exist
            $sql="SELECT * FROM `author` WHERE author_email='$author_email';";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)<=0){
                header("Location: login.php?message=Login+Error");
                exit();
            } else{
                //if email exists
               while($row=mysqli_fetch_assoc($result)){
                   //checking if password matches
                   if(!password_verify($author_password,$row['author_password'])){
                    header("Location: login.php?message=Login+Error");
                    exit();
                   } else if(password_verify($author_password,$row['author_password'])){
                            $_SESSION['author_id']=$row['author_id'];
                            $_SESSION['author_name']=$row['author_name'];
                            $_SESSION['author_email']=$row['author_email'];
                            //$_SESSION['author_password']=$row['author_password'];
                            $_SESSION['author_bio']=$row['author_bio'];
                            $_SESSION['author_role']=$row['author_role'];

                            header("Location: index.php");
                            exit();
                   }
               }


            }

        }
   }

?>








    <!--libraries-->
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
    <!-------------------------------------------------------------------------------------------------------------------->
</body>
</html>