<?php
   include_once "includes/connection.php";
   include_once "includes/functions.php"; 
 if(!isset($_GET['id'])){
       header("Location: index.php");
 } else{
      $id= mysqli_real_escape_string($conn, $_GET['id']);
      if(!is_numeric($id)){
        header("Location: index.php");
        exit();
      } else if(is_numeric($id)){
          $sql="SELECT * FROM `page` WHERE page_id='$id';"; 
          $result=mysqli_query($conn,$sql);
          //check if post exits
          if(mysqli_num_rows($result)<=0){
              //no post
              header("Location: index.php?nopagefound");
          } else if(mysqli_num_rows($result)>0){
              while($row=mysqli_fetch_assoc($result)){
                  $page_title=$row['page_title'];
                  $page_content=$row['page_content'];
                  $page_title2=$row['page_title'];
                  

                  

                  ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <!--css-stylesheet-->
    <link rel="stylesheet" href="../style/style.css">
     <!--bootstrap-file-->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <!--     <link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>-->
</head>
<body>
<!-------nav-bar-starts-here-------------->
      <?php include_once "includes/nav.php"; ?>
<!------------------------------------------->



<!--posts---------------------------------->
<div class="container">
     
     <h1 style="width:100%;background-color:grey;padding-top:25px;padding-bottom:25px;text-align:center;color:white"><?php echo $page_title2; ?></h1>
     <hr>
     
     <p><?php echo $page_content; ?></p>

</div>
<!------------------------------------------>













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
              }
          }
      }
 }
 

?>