<?php 
    include_once "../includes/functions.php";
    include_once "../includes/connection.php"; 
    session_start();
    if(isset($_SESSION['author_role'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!--css-stylesheet-->
    <link rel="stylesheet" href="../style/style.css">
     <!--bootstrap-file-->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <!--     <link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>-->
</head>
<body>

<!----------------------------------------------------------------------------------------->
<nav class="navbar navbar-dark sticky-top bg-dark shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
  
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="logout.php">Sign out</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <?php include_once "nav.inc.php"; ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <h6> <?php echo $_SESSION['author_name'] ?> | Your role is <?php echo $_SESSION['author_role'] ?></h6>
      </div>
      <div id="admin-index-form">
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
      <h1>Your Profile</h1>
      <form  method="post">
      Name:
      <input type="text" name="author_name" value="<?php echo $_SESSION['author_name']; ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name"><br>
      Email:
      <input type="email" name="author_email" value="<?php echo $_SESSION['author_email']; ?>"class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"><br>
      Password:
      <input type="password" name="author_password" class="form-control" id="exampleInputPassword1" placeholder="Password"><br>
      Your Bio:
      <textarea name="author_bio"  class="form-control" id="exampleFormControlTextarea1" rows="3" ><?php echo $_SESSION['author_bio']; ?></textarea><br>
  
     <button type="submit" name="update" class="btn btn-primary">Update</button>
</form>
<?php
    
    if(isset($_POST['update']))
    {
      $author_name=mysqli_real_escape_string($conn,$_POST['author_name']);
      $author_email=mysqli_real_escape_string($conn,$_POST['author_email']);
      $author_password=mysqli_real_escape_string($conn,$_POST['author_password']);
      $author_bio=mysqli_real_escape_string($conn,$_POST['author_bio']);

      //checking if fields are empty
      if(empty($author_name) OR empty($author_email) OR empty($author_bio)){
        echo "Fields are empty";
      } else{
              //checking if email is valid
              if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
                echo "Please enter a valid email";
              } else{
                //check if password is empty
                if(empty($author_password)){
                  //user dont want to channge passwword
                  $author_id=$_SESSION['author_id'];
                  $sql="UPDATE `author` SET author_name='$author_name' , author_email='$author_email' , author_bio='$author_bio' 
                  WHERE author_id='$author_id';";
                  if(mysqli_query($conn,$sql)){
                        
                            $_SESSION['author_bio']=$author_bio;
                            $_SESSION['author_name']=$author_name;
                            $_SESSION['author_email']=$author_email;
                            header("Location: index.php?message=Profile+updated");
                  } else{
                    echo "Error";
                  }
            
                } else{
                  //change password
                  $hash= password_hash($author_password,PASSWORD_DEFAULT);
                  $author_id=$_SESSION['author_id'];
                  $sql="UPDATE `author` SET author_name='$author_name' , author_email='$author_email' , author_bio='$author_bio', 
                   author_password='$hash' WHERE author_id='$author_id';";
                  if(mysqli_query($conn,$sql)){
                        
                            
                            session_unset();
                            session_destroy();
                            header("Location: login.php?message=You+may+login+again");
                  } else{
                    echo "Error";
                  }

                }
              }
      }


    }


?>

      </div>

   
      <!--</div>-->
    </main>
  </div>
</div>

<!------------------------------------------------------------------------------------->














    <!--libraries-->
    <!--<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
    <!-------------------------------------------------------------------------------------------------------------------->
</body>
</html>
<?php   
    } else{
    header("Location: login.php?message=please+login");
    }
?>
