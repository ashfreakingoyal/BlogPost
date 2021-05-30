<?php
include_once "includes/connection.php";
if(!isset($_GET['s'])){
    header("Location: index.php");
    exit();
} else{
    $search=mysqli_real_escape_string($conn,$_GET['s']);
    $sql="SELECT * FROM `post` WHERE `post_title` LIKE '%$search%' OR `post_content` LIKE '%$search%' OR `post_keywords` LIKE '%$search%' ;";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS system</title>
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
<h1>Showing All Results for Search <?php echo $search;?></h1>
<div class="card-columns">
<?php
    $sql="SELECT * FROM `post` WHERE `post_title` LIKE '%$search%' OR `post_content` LIKE '%$search%' OR `post_keywords` LIKE '%$search%';";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)<=0){
          header("Location:index.php?noresult");
          exit();
    } else{
            while($row=mysqli_fetch_assoc($result)){
      $post_title=$row['post_title'];
      $post_image=$row['post_image'];
      $post_author=$row['post_author'];
      $post_content=$row['post_content'];
      $post_id=$row['post_id'];
    
      $sqlauth="SELECT * FROM `author` WHERE author_id='$post_author';";
      $resultauth=mysqli_query($conn,$sqlauth);
      while($authrow=mysqli_fetch_assoc($resultauth)){
          $post_author_name= $authrow['author_name'];
      

      ?>
      
<div class="card" style="width: 18rem;">
  <img src="<?php echo $post_image ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo $post_title ?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?php echo $post_author_name ?></h6>
    <p class="card-text"><?php echo substr($post_content,0,90)."..."?></p>  
    <a href="post.php?id=<?php echo $post_id ?>" class="btn btn-primary">Read More</a>
  </div>
</div>

    <?php } }?>

</div>

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
} }

?>