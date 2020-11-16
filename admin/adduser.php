<?php

session_start();
require "../config/config.php";

if(!empty($_POST)){
    
    $name = $_POST['name'];
    $password =password_hash( $_POST['password'],PASSWORD_DEFAULT);
    $email = $_POST['email'];

    if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
      header('Location: login.php');
    }
    
    if($_SESSION['role'] != 1){
      header('location:login.php');
    }

    if(empty($name) || empty($password) || empty($email) || strlen($password) < 4 ){
      if(empty($name)){
        $nameError = ' * Fill name';
      }
      if(empty($password)){
        $passwordError = ' * Fill password';
      }
      if(empty($email)){
        $emailError = ' * Fill email';
      }
      if(strlen($password) < 4) {
        $passwordError = '* Password must be at least 4 ';
      }
    }else{

      $eFit = $pdo->prepare("SELECT * FROM users ORDER BY id DESC ");
    
      $eFit->execute();
      
      $res = $eFit->fetchAll();
  
      
      if($res[0]['email'] != $email){
  
  
          if(empty($_POST['role'])){
              $role = 0;      
          }else{
              $role = 1;
          }
  
              $stmt = $pdo->prepare("INSERT INTO users (name,password,email,role) VALUES(:name,:password,:email,:role) ");
                  $result = $stmt->execute(
                      array(':name'=>$name , ':password'=>$password , ':email'=>$email , ':role'=>$role )
                  );
              if($result){
                  echo "<script>alert('Add New User Successfully ');window.location.href='userlist.php'; </script>";
              }
  
  
  
          
  
      }else{
          echo "<script>alert('This user email already exit ') </script>";
      }
  

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
            <h3 class="card-title">Create New User</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              
               

                <form action="adduser.php" method="post" enctype="multipart/form-data" > 
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
                    <div class="form-group">
                        <label for="">Name</label><br>
                        <p style="color:red;"><?php echo empty($nameError) ? '' : $nameError; ?></p>
                        <input type="text" class="form-control" name="name" >
                    </div>
                    <div class="form-group">
                        <label for="">Password</label><br>
                        <p style="color:red;"><?php echo empty($passwordError) ? '' : $passwordError; ?></p>
                        <input type="password" class="form-control" name="password" >
                    </div>
                    <div class="form-group">
                        <label for="">Email</label><br>
                        <p style="color:red;"><?php echo empty($emailError) ? '' : $emailError; ?></p>
                        <input type="email" class="form-control" name="email" >
                    </div>

                    <div class="form-group">
                                            
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name ='role'>
                            <label class="custom-control-label" for="defaultUnchecked">Admin | User </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="SUBMIT">
                        <a href="index.php" class="btn btn-warning" type="button">Back</a>
                    </div>
                </form>

                
              
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