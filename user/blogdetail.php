<?php

require "../config/config.php";
require "../config/common.php";

    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id =".$_GET['id']);
    $stmt->execute();
    $res = $stmt->fetchAll();



   
    $postid = $_GET['id'];
    
    $authorid = $_SESSION['user_id'] ;


    if(!empty($_POST)){
      
        $comment = $_POST['comment'];

        if(empty($comment)){
          if(empty($comment)){
            $commentError = ' * Fill comment';
          }

        }else{
        $com = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES(:content,:author_id,:post_id) ");
        $comRs = $com->execute(
            array(':content'=>$comment , ':author_id'=>$authorid ,':post_id'=>$postid)
        );
        if($comRs){
          header('location:blogdetail.php?id='.$postid);
        }


        }


    }


    $comSh = $pdo->prepare("SELECT * FROM comments WHERE post_id =$postid");
    $comSh->execute();
    $showResult = $comSh->fetchAll();

   
    $showUser = [];
    if($showResult){
      foreach($showResult as $key => $value){
        $au_id = $showResult[$key]['author_id'];

        $userSh = $pdo->prepare("SELECT * FROM users WHERE id ='$au_id' ");
        $userSh->execute();
        $showUser[] = $userSh->fetchAll();
      }
    }




?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Simple |Blog </title>
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
          <div class="col-sm-6" style="float: none !important;">
            <h1><?php echo escape($res[0]['title']) ?></h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
        <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="user-block">
                  <img class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Image">
                  <span class="username"><a href="#">Jonathan Burke Jr.</a></span>
                  <span class="description">Shared publicly - 7:30 PM Today</span>
                </div>
                <!-- /.user-block -->
               
               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad" src="../admin/images/<?php echo escape($res[0]['image'] )?>" alt="Photo" style="width: 100% !important;">

                <br><br><br>

                <p><?php echo escape($res[0]['content']) ?></p><br>

                <h3>Comment</h3><br><hr>
                <a href="index.php" type="button" class="btn btn-primary">Go Back</a>


                
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">

              <?php if($showResult){ ?>

              
                <div class="card-comment">
                  <?php
                      foreach($showResult as $key => $value) {

                  ?>

                  <img class="img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image" >

                  <div class="comment-text">
                    <span class="username">

                      <h4><b><?php print_r($showUser[$key][0]['name']) ; ?></b> </h4>
                      <span class="text-muted float-right"><?php echo $value['created_at'] ?></span>
                    </span><!-- /.username -->
                    <?php echo escape($value['content']) ?>
                  </div>


                  <?php
                      }

                    ?>

                 
                  
                  <!-- /.comment-text -->
                </div>
                
                <?php } ?>
              
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="" method="post">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
                  <img class="img-fluid img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="Alt Text">
                  
                  <div class="img-push">
                  <p style="color:red;"><?php echo empty($commentError) ? '' : $commentError; ?></p><br>
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
       
          <!-- /.col -->
        </div>
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