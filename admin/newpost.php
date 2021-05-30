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
    <title>Add New Post</title>
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
        <h1 class="h2">Add New Post</h1>
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

        <form method="post" enctype="multipart/form-data">
        Post Title
        <input type="text" name="post_title" class="form-control"  aria-describedby="emailHelp" placeholder="Post Title"><br>

        Post Category
        <select name="post_category"class="form-control" id="exampleFormControlSelect1">
        <?php
           $sql="SELECT * FROM `category`;";
           $result=mysqli_query($conn,$sql);
           while($row=mysqli_fetch_assoc($result)){
               $category_id=$row['category_id'];
               $category_name=$row['category_name'];
               ?>
                 <option value="<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
               <?php

           }
        
        ?>
         </select><br>

        Post Content 
        <textarea class="form-control" name="post_content" id="exampleFormControlTextarea1" rows="3"></textarea><br>

        Post Image 
        <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1"><br>

        Post Keywords
        <input type="text" name="post_keywords" class="form-control"  aria-describedby="emailHelp" placeholder="Enter Keywords"><br>
        
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
      <?php
           if(isset($_POST['submit'])){
               $post_title= mysqli_real_escape_string($conn,$_POST['post_title']);
               $post_category= mysqli_real_escape_string($conn,$_POST['post_category']);
               $post_content= mysqli_real_escape_string($conn,$_POST['post_content']);
               $post_keywords= mysqli_real_escape_string($conn,$_POST['post_keywords']);
               $post_author=$_SESSION['author_id'];
               $post_date=date("d/m/y");
            //checking if above fields are empty
            if(empty($post_title) OR empty($post_category) OR empty($post_content)){
                header("Location: newpost.php?message=empty+fields");
                exit();
            } 

               $file=$_FILES['file'];

               $fileName=$file['name'];
               $fileType=$file['type'];
               $fileTmp=$file['tmp_name'];
               $fileErr=$file['error'];
               $fileSize=$file['size'];
               
               $fileEXT= explode('.',$fileName);
               $fileExtension= strtolower(end($fileEXT));

               $allowedExt= array("jpeg","jpg","png","gif");

               if(in_array($fileExtension,$allowedExt)){
                   if($fileErr===0){
                       if($fileSize < 3000000){
                           $newFileName=uniqid('',true).'.'.$fileExtension;
                           $destination="../uploads/$newFileName";
                           $dbdestination="uploads/$newFileName";
                           move_uploaded_file($fileTmp,$destination);
                           $sql="INSERT INTO `post` (`post_title`,`post_content`,`post_category`,`post_author`,`post_date`,`post_keywords`,`post_image`) 
                           VALUES ('$post_title','$post_content','$post_category','$post_author','$post_date','$post_keywords','$dbdestination');";

                           if(mysqli_query($conn,$sql)){
                               header("Location: posts.php?message=Post+Published");
                           } else{
                            header("Location: newpost.php?message=Error");
                           }

                           
                           

                       } else{
                           header("Location: newpost.php?message=YOUR FILE TOO BIG TO UPLOAD");
                           exit();
                       }

                   } else{
                        header("Location: newpost.php?message=Oops Error uploading file");
                        exit();
                         
                   }
               } else{
                   
                   header("Location: newpost.php?message=You have uploaded a wrong file");
                           exit();
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
<!--<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>tinymce.init({selector:'textarea'});</script>-->
    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
    <!-------------------------------------------------------------------------------------------------------------------->
</body>
</html>
<?php   
    } else{
    header("Location: login.php?message=please+login");
    }
?>
