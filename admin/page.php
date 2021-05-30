<?php 
    include_once "../includes/functions.php";
    include_once "../includes/connection.php"; 
    session_start();
    if(isset($_SESSION['author_role'])){
        if($_SESSION['author_role']=="admin"){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page</title>
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
        <h1 class="h2">Pages</h1>
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
      
     <h1>ALL PAGES:</h1>
     <button id="toggleForm" class="btn btn-info">Add New</button>
     <hr>
     <div style="display:none;" id="newPageForm"> 
     <form action="newpage.php" method="post">
        <input type="text" name="page_title" class="form-control" placeholder="Enter Page Title"><br>
        <textarea name="page_content" class="form-control" rows="3" placeholder="Enter Content"></textarea><br>
        <button name="submit" class="btn btn-success">Add Page</button><br><br>
     </form>
     </div>

     <table class="table">
  <thead>
    <tr>
      <th scope="col">Page Id</th>
      
      <th scope="col">Page Title</th>
      <th scope="col">Actions</th>
      
      
    </tr>
  </thead>
  <tbody>
  <?php
           $sql="SELECT * FROM `page` ORDER BY page_id DESC;";
           $result=mysqli_query($conn,$sql);
           while($row=mysqli_fetch_assoc($result)){
             $page_id=$row['page_id'];
             $page_title=$row['page_title'];
             
           
             
  ?>

    <tr>
      <th scope="row"><?php echo $page_id; ?></th>
      
      <td><?php echo $page_title; ?></td>
      
      
      <td><a href="editpage.php?id=<?php echo $page_id; ?>"><button class="btn btn-info">Edit</button></a>
      <a onclick="return confirm('Are you sure?')" href="deletepage.php?id=<?php echo $page_id; ?>"><button class="btn btn-danger">Delete</button></a>
      </td>
      
    </tr>
    <?php  }?>

    
  </tbody>
</table>

      </div>

   
      <!--</div>-->
    </main>
  </div>
</div>

<!------------------------------------------------------------------------------------->














    <!--libraries-->
    <!--<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
    <!-------------------------------------------------------------------------------------------------------------------->
    <script>
       $(document).ready(function(){
          $("#toggleForm").click(function(){
               $("#newPageForm").slideToggle();
          });
       });
       </script>
</body>
</html>
<?php
        }   
    } else{
    header("Location: login.php?message=please+login");
    }
?>
