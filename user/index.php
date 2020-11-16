<?php

require "../config/config.php";
require "../config/common.php";


if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
  
  header('location:login.php');
}


?>




<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Simple | Blog </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="">
 
  

  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Blog | Posts</h1>
          </div>
          
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid"> 
        <div class="row">
            <?php 

              if(!empty($_GET['pageno'])){
                $pageno = $_GET['pageno'];
              }else{
                $pageno = 1;
              }

              $numOfRecs = 1 ;
              $offSet = ($pageno -1) * $numOfRecs;

              
                $sql = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                $sql->execute();
                $rawResult = $sql->fetchAll();
                $total_pages = ceil(count($rawResult) / $numOfRecs );

                $sql = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offSet,$numOfRecs ");
                $sql->execute();
                $result = $sql->fetchAll();
              

              if($result){
                $i = 1;
                  foreach($result as $value){

            ?>

          <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <h4 ><?php echo escape($value['title'] )?></h4> <!-- xss attack prevent for escape-->
               
               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                <a href="blogdetail.php?id=<?php echo $value['id'] ?>">
                    <img style="height:200px !important ;" class="img-fluid pad" src="../admin/images/<?php echo escape($value['image']) ?>" alt="Photo">
                </a>
                <!-- <p>I took this photo this morning. What do you guys think?</p> -->
                
              </div>
              
              
              
            </div>
            <!-- /.card -->
          </div>


          <?php
                  $i++;
                }
            }
          ?>
          <br><br>
          

       
          <!-- /.col -->
        </div>

            <nav aria-label="Page navigation example" style="float: right !important;" >
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
            </nav><br><br>

        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left: 0 !important;">
    <div class="float-right d-none d-sm-block">
    <a href="logout.php" type="button" class="btn btn-warning">Logout</a>
    </div>
    <strong>Copyright &copy; 2020 <a href="#">Trust Blog !</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>
