
<?php
      include_once "includes/connection.php"; 
      session_start();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">CMS SYSTEM</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home </a>
      </li>
      <?php 
      if(!isset($_SESSION['author_role'])){
        ?>
      <li class="nav-item ">
        <a class="nav-link" href="admin/login.php">Login </a>
      </li>
      <?php } else{  ?>

        <li class="nav-item ">
        <a class="nav-link" href="admin/logout.php">Logout </a>
      </li>

     <?php  }   ?>
      <?php
           $sqlpage="SELECT * FROM `page`;";
           $resultpage=mysqli_query($conn,$sqlpage);
           while($rowpage=mysqli_fetch_assoc($resultpage))
           {
             $page_id=$rowpage['page_id'];
             $page_title=$rowpage['page_title'];

             ?>
              <li class="nav-item">
             <a class="nav-link" href="page.php?id=<?php echo $page_id; ?>"><?php echo $page_title; ?></a>
             </li>

             <?php 
           }
      ?>
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          All Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php
               $sql="SELECT * FROM `category`;";
               $result=mysqli_query($conn,$sql);
               while($row=mysqli_fetch_assoc($result))
               {
                 $category_id=$row['category_id'];
                 $category_name=$row['category_name'];

                 ?>
                  <a class="dropdown-item" href="category.php?id=<?php echo $category_id; ?>"><?php echo $category_name; ?></a>

                 <?php 
               }
        ?>
        
          
          
        </div>
      </li>
      
    </ul>
    <form action="search.php" class="form-inline my-2 my-lg-0">
      <input name="s" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
