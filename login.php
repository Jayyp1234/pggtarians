<?php
include_once('backend/connection.php');

error_reporting(0);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/css/boxicons.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Login</title>
</head>
<body>

<!-- php code starts here   -->

<?php

$errors = array(
    'phone_or_email' => '',
    'password' => ''
);

if (isset($_POST['login'])){

    $email = $connection->real_escape_string($_POST['email']);
    $number = $connection->real_escape_string($_POST['number']);
    $password = $connection->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM pggtarians WHERE `email` = '$email' OR `phone_number` = '$number'";
    $result = $connection->query($sql);
    $row = mysqli_fetch_array($result);

    // checking error for email or phone number
    if($row['email'] != $email){
        $errors['phone_or_email'] = "<i class='bx bxs-error-circle'></i> &nbsp; &nbsp; Email is not registered"; 
    }
     // checking error for password
     if($row['email'] == $email && $row['password'] != $password){
        $errors['password'] = "<i class='bx bxs-error-circle'></i> &nbsp;  &nbsp; Password incorrect";
    }else{

    }
    // elseif($row['phone_number'] != $number){
    //     $errors['phone_or_email'] = "<i class='bx bxs-error-circle'></i> &nbsp; &nbsp; Phone number is not registered"; 
    // }

   


}
 

?>



<!-- php code ends here   -->


    <style>
        header{
            text-align: center;
        }
        header .img-fluid{
            max-width: clamp(90px, 18%, 10rem);
            margin-bottom: 1.5rem;
        }
        header h4{
            border-radius: 2px;
            margin-bottom: 2rem;
            background-color: var(--secondary-color);
            color: white;
            padding: 0.7rem 0.7rem 0.9rem;
            font-family: Poppins;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: .7px;
        }
    </style>
    <div class="main row col-12 p-0">
        <div class=" col-12 col-md-8 col-lg-6 mx-auto">
            <header>
                <img src="assets/images/pgg 2.svg" alt="" class="img-fluid">
                <h4>Log in</h4>
            </header>
            <main>
                <form action="" method="POST" autocomplete="off">
                    <div class="">
                        <label for="email_username" class="form-label d-none d-md-block">Email/Phone number:</label>
                        <input type="text" name="email" value="<?php echo $_POST['email']?>" class="form-control" id="fullname" placeholder="Email or phone number"required>
                        <p class="errors"><?php echo $errors['phone_or_email']?></p>
                    </div>
                    <div class="password">
                        <label for="password" class="form-label d-none d-md-block">Password:</label>
                        <div class="position-relative">
                            <input type="password" name="password" value="<?php echo $_POST['password']?>" class="form-control" id="password" placeholder="Password" required>
                            <i class="bx bx-show" onclick="show_hide();"></i>
                        </div>
                            <p class="errors"><?php echo $errors['password']?></p>
                        <div class="keep_forgot">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineFormCheck">
                                <label class="form-check-label" for="inlineFormCheck">
                                    Stay logged in
                                </label>
                            </div>
                            <div class="forgot_password d-none d-md-block">
                                <a href="">I forgot my password?</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="sign_in">
                        <button type="submit" name="login">
                            <span>Sign In</span>
                            <i class="bx bx-rocket" style="transform: rotateZ(-45deg);
                            font-size: clamp(12px, calc(1vw + .25rem), 14px); margin-left: .4rem;"></i>
                        </button>
                    </div>
                    <div class="forgot_password_sm d-md-none">
                        <a href="">Forgot your password?</a>
                    </div>
                </form>
                <div class="other_section">
                    <div class="hr text-center">
                        <small>Or sign in with</small>
                    </div>
                    
                    <div class="other_signIn_method row col-12 p-0">
                            <div class="icon col-12 col-md-5">
                                <a href="">
                                    <img src="assets/images/google.png" alt="" class="img-fluid">
                                    <span>Sign in with Google</span>
                                </a>
                            </div>
                            <div class="icon col-12 col-md-5">
                                <a href="">
                                    <img src="assets/images/facebook.png" alt="" class="img-fluid">
                                    <span>Sign in with facebook</span>
                                </a>
                            </div>
                    </div>
                    
                    <div class="create_account">
                        <p class="m-0">Don't have an account? <a href="">Join now</a></p>
                    </div>
                </div>          
            </main>
        </div>        
    </div>

       <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Launch static backdrop modal
  </button>
  
  <!-- Modal -->
    <!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Thank you for blah blah blah</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --> 


    <script type="text/javascript">
        const body = document.querySelector(' body '),
              showHideIcon = body.querySelector(' form > div .position-relative i '),
              passwordinput = body.querySelector(' form > div input[type="password"] ');

        function show_hide(){
            showHideIcon.addEventListener('click', () => {
                if(passwordinput.type == 'password'){
                    showHideIcon.classList.remove('bx-show');
                    showHideIcon.classList.add('bx-hide');
                    passwordinput.type = 'text';
                }else{
                    showHideIcon.classList.add('bx-show');
                    showHideIcon.classList.remove('bx-hide');
                    passwordinput.type = 'password'; 
                }
            })
        }

    </script>
</body>
</html>