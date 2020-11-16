<?php

  require "../config/config.php";
  require "../config/common.php";


  if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
    
    header('location:login.php');
  }
  if($_SESSION['role'] != 1){
    header('location:login.php');
  }


  if(!empty($_POST['search'])){
    setcookie('search', $_POST['search'], time() + (86400 * 30), "/");
  }else{
    if(empty($_GET['pageno'])){
      unset($_COOKIE['search']);
      setcookie('search',null,-1,'/');
    }
  }



?>



<?php include "header.php" ?>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Posts List Table</h3>
              </div>

              <?php 


                  if(!empty($_GET['pageno'])){
                    $pageno = $_GET['pageno'];
                  }else{
                    $pageno = 1;
                  }

                  $numOfRecs = 2 ;
                  $offSet = ($pageno -1) * $numOfRecs;

                  if(empty($_POST['search']) && empty($_COOKIE['search'])){
                    $sql = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                    $sql->execute();
                    $rawResult = $sql->fetchAll();
                    $total_pages = ceil(count($rawResult) / $numOfRecs );

                    $sql = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offSet,$numOfRecs ");
                    $sql->execute();
                    $result = $sql->fetchAll();
                  }else{
                    $searchKey = isset($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];

                    $sql = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
                    $sql->execute();
                    $rawResult = $sql->fetchAll();
                    $total_pages = ceil(count($rawResult) / $numOfRecs );

                    $sql = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offSet,$numOfRecs ");
                    $sql->execute();
                    $result = $sql->fetchAll();
                  }

              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <div>
                  <a href="add.php" class="btn btn-success" type="button">Create New Post</a><br/>
                </div>
                <br/>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php

                    

                      if($result){
                         $i = 1;
                          foreach($result as $value){

                  ?>

                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo escape($value['title']) ?></td>
                      <td>
                      <?php echo escape(substr($value['content'],0,50)) ?>
                      </td>
                      <td class="btn-group">

                        <div class="container">
                          <a href="edit.php?id=<?php echo $value['id'] ?>" class="btn btn-warning" type="button">Edit</a>
                        </div>
                        <div class="container">
                          <a href="delete.php?id=<?php echo $value['id'] ?>" 
                          onclick="return confirm('Are you want to sure delete this item ! ')"
                          class="btn btn-danger" type="button">Delete</a>
                        </div>
                        
                       

                      </td>
                    </tr>


                  <?php
                  $i++;
                          }
                      }
                  ?>

                 



                    
                   
                  
                  </tbody>
                </table><br>
                <nav aria-label="Page navigation example" style="float:right;">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1 ){ echo 'disabled'; }?>">
                      <a class="page-link" href="<?php if($pageno <= 1 ){echo '#' ; }else{ echo "?pageno = ".($pageno-1) ;} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages ){ echo 'disabled'; }?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages ){echo '#';}else{ echo "?pageno=".($pageno+1) ;} ?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno= <?php echo $total_pages; ?>">Last</a></li>
                  </ul>
                </nav>
              </div>
              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->

           
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <?php include "footer.php" ?>