<?php
include_once('backend/connection.php');
error_reporting(0);

// ==== for reference to the sql database table ==== //
// CREATE TABLE pggtarians (
// 	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//     fullname VARCHAR(255) NOT NULL,
//     email VARCHAR(255) NOT NULL,
//     username VARCHAR(255) NOT NULL,
//     phone_number VARCHAR(255) NOT NULL,
//     dob VARCHAR(255) NOT NULL,
//     password VARCHAR(255) NOT NULL
// );



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/css/boxicons.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <title>Registration Form</title>
</head>
<body>

    <!-- php codes go in here -->

<?php

$errors = array(
    'fullname' => '',
    'email' => '',
    'username' => '',
    'number' => '',
    'day' => '',
    'year' => '',
    'password' => '',
    'cpassword' => '',
    'general' => ''
);

if(isset($_POST['register'])){
    $fullname = $connection->real_escape_string($_POST['fullname']);
    $email = $connection->real_escape_string($_POST['email']);
    $username = $connection->real_escape_string($_POST['username']);
    $number = $connection->real_escape_string($_POST['number']);
    $month = $connection->real_escape_string($_POST['month']);
    $day = $connection->real_escape_string($_POST['day']);
    $year = $connection->real_escape_string($_POST['year']);
    $password = $connection->real_escape_string($_POST['password']);
    $cpassword = $connection->real_escape_string($_POST['cpassword']);

    $dates = array($day, $month, $year);
    function date_of_birth($dates){
        
        $date_of_birth = [];
        $counter = 0;

        foreach($dates as $date){
            $date = htmlspecialchars($date);
            $date = trim($date);
            $date = stripslashes($date); 
            $date_of_birth[$counter] = $date;
            $counter++;
        }
        return implode('-', $date_of_birth);

    }
    $dob = date_of_birth($dates);


    $sql = "SELECT * FROM pggtarians WHERE email = '$email';";
    $result = $connection->query($sql);
    if(mysqli_num_rows($result) > 0){
        $errors['email'] = '<i class="bx bxs-error-circle"></i> &nbsp; An account already exists using this email';
    }else{
        // checking for errors in fullname
        if(ctype_digit($fullname)){
            $errors['fullname'] = '<i class="bx bxs-error-circle"></i> &nbsp; Fullname should be only alphabets and special characters';
        }else{
            $fullname = ucwords($fullname);
        }

        // checkiing for errors in email address
        if($email){
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if(!$email){
                $errors['email'] = '<i class="bx bxs-error-circle"></i> &nbsp; Enter valid email address';
            }
        }

        // error in day input
        if(intval($day) < 1 || intval($day) > 31){
            $errors['day'] = '<i class="bx bxs-error-circle"></i> &nbsp;  Error';
        }

        // error in year input
        if(intval($year) < 1960 || intval($year) > 2022){
            $errors['year'] = '<i class="bx bxs-error-circle"></i> &nbsp;  Error';
        }

        // checking for errors with phone number
        if(!preg_match('/^(\+234|0)[789][01]\d{8}/', $number)){
            $errors['number'] = '<i class="bx bxs-error-circle"></i>'. ' Phone number can only start with country code or local phone number';
        }

        // cross-checking if password condition are met
        if(strlen($password) < 6){
            $errors['password'] = '<i class="bx bxs-error-circle"></i>'. ' Password should be 6 characters or more, contain lowercase, uppercase and a character';
        }elseif(strlen($password) >= 6 && !preg_match('/[^a-zA-Z0-9\.]/', $password)){
            $errors['password'] = '<i class="bx bxs-error-circle"></i> &nbsp; &nbsp; Password should be 6 characters or more, contain lowercase, uppercase and a character';           
        }

        // checking for password match
        if($password != $cpassword){
            $errors['cpassword'] = '<i class="bx bxs-error-circle"></i> &nbsp; Passwords do not match';           
        }

        if($cpassword && $password && $number && $year && $day && $email && $fullname && $username){
            $sql = "INSERT INTO pggtarians (`fullname`, `email`, `username`, `phone_number`, `dob`, `password`) VALUES('$fullname', '$email','$username', '$number', '$dob', '$password')";
            $result = $connection->query($sql);
            if(!$result){
                $errors['general'] = "<i class='bx bxs-error-circle'></i>". "Error submitting form";
            }else{
                $fullname = $email = $username = $month = $day = $year = $password = $cpassword = '';
                ?>
                <!-- <script type="text/javascript">
                     const body = document.querySelector('body'),
                           getPopup = body.querySelector('.modal_btn');

                    getPopup.click();
                </script> -->
                <?php
            }
        }    
    }
}

?>

<!-- end of php codes -->
    <style>
        .header{
            text-align: center;
        }
        /* === if image is on the form side === */
        /* .header .img-fluid{
            max-width: clamp(80px, 18%, 10rem);
            margin-bottom: 1.5rem;
        } */
        /* === image is on 3d imag, check stylesheet === */
    </style>
    
    <div class="row col-12">
        <div class="col-11 d-lg-block col-lg-5 image text-center position-relative">
            <div class="header d-block">
                <img src="assets/images/pgg 2.svg" alt="" class="img-fluid">
            </div>
            <img src="assets/images/image141.png" alt="" class="img-fluid">
            <img src="assets/images/image_cog2.png" alt="" class="img-fluid cog_2">
            <img src="assets/images/business-3d-three-grey-metal-gears.png" alt="" class="img-fluid cog_1">
        </div>
        
        <div class=" col-11 mx-auto col-lg-7 form">
            <div class="create_acct col-12 col-md-10 mx-auto text-center">
                <h3>Create an account</h3>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" autocomplete="off">
                <div class="col-md-10 mx-auto">
                    <label for="fullname" class="form-label">Fullname:</label>
                    <input type="text" value="<?php echo $_POST['fullname'];?>" class="form-control" name="fullname" id="fullname" placeholder="" required>
                    <div class="errors"><span><?php echo $errors['fullname']?></span></div>
                </div>
                <div class="col-md-10 mx-auto">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" value="<?php echo $_POST['email'];?>" class="form-control" name="email" id="email" placeholder="e.g user@user.com" required>
                    <div class="errors"><span><?php echo $errors['email']?></span></div>
                </div>
                <div class="col-md-10 mx-auto">
                    <label for="dob" class="form-label">Date of birth:</label>
                    <div class="row col-12 date">
                        <div class="month col-5">
                            <i class="bx bx-caret-down"></i>
                            <select name="month" value="<?php echo $_POST['month']?>" required>
                                <option selected style="
                                    font-size: clamp(14px, calc(.7vw + .25rem), 16px);" value" "> -- Month --</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <input type="number" value="<?php echo $_POST['day'];?>" name="day" placeholder="Day" required>
                            <div class="errors"><span><?php echo $errors['day']?></span></div>
                        </div>
                        <div class="col-3">
                            <input type="number" value="<?php echo $_POST['year'];?>" name="year" placeholder="Year" required>
                            <div class="errors"><span><?php echo $errors['year']?></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 mx-auto input">
                    <div class="col-md-12">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" value="<?php echo $_POST['username'];?>" class="form-control" name="username" id="username" placeholder="" required>
                        <div class="errors"><span><?php echo $errors['username']?></span></div>
                    </div>
                    <div class="col-md-12">
                        <label for="number" class="form-label">Phone number:</label>
                        <input type="number" value="<?php echo $_POST['number'];?>" class="form-control" name="number" id="number" placeholder="e.g +234  __ ____ ____" required>
                        <div class="errors"><span><?php echo $errors['number']?></span></div>
                    </div>
                </div>
                <div class="col-md-10 mx-auto">
                    <label for="password" class="form-label">Password:</label>
                    <div class="position-relative password">
                        <input type="password" value="<?php echo $_POST['password'];?>" class="form-control" name="password" placeholder="e.g Password123</>" required>
                        <i class="bx bx-show password"></i>
                        <p>Password should contain atleast one uppercase, lowercase, number and a character</p>
                    </div>
                    <div class="errors"><span><?php echo $errors['password']?></span></div>
                </div>
                <div class="col-md-10 mx-auto">
                    <label for="cpassword" class="form-label">Confirm password:</label>
                    <div class="position-relative password">
                        <input type="password" value="<?php echo $_POST['cpassword'];?>" class="form-control" name="cpassword" placeholder="Re-enter password" required>
                        <i class="bx bx-show password"></i>
                    </div>
                    <div class="errors"><span><?php echo $errors['cpassword']?></span></div>
                </div>
                <div class="col-md-10 button">
                    <button type="submit" name="register" class="button">
                        <span>Sign Up</span>
                        <i class="bx bx-rocket" style="transform: rotateZ(-45deg);
                        font-size: clamp(12px, calc(1vw + .25rem), 14px); margin-left: .4rem;"></i>
                    </button>
                </div>
                <div class="col-10 agreement">
                    <p>By clicking sign-up, you agree to be a member of PGGTARIAN</p>
                </div>
                <div class="errors">
                    <span><?php echo $errors['general'];?></span>
                </div>
            </form>
        </div>
    </div>

    <style>
        
    </style>
                <!-- Button trigger modal -->
<button type="button" class="btn btn-primary pop_up_btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Launch static backdrop modal
  </button>
  
  <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="assets/images/business-3d-joyful-young-black-man-jumping.png" alt="" class="img-fluid">
                    <p>Registration successful</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div> 

      


    <script src="assets/js/bootstrap.min.js"></script>
    <script>
        const body = document.querySelector('body'),
              showIcons = body.querySelectorAll('.password i.password'),
              submitBtn = body.querySelector('.button button'),
              form = body.querySelector('form'),
              pop = body.querySelector('.btn.btn-primary');

            // popup after successfull registration
                submitBtn.onclick = e => {
                    e.preventDefault();
                    pop.click();
                }

            // toggle each password input icons //

            for(let showIcon of showIcons){
                showIcon.addEventListener('click', () => {
                    showIcon.onclick = () => {
                        if(showIcon.previousElementSibling.type == 'password'){
                            showIcon.previousElementSibling.type = 'text';
                            showIcon.classList.add('bx-hide');
                            showIcon.classList.remove('bx-show');
                        }else{
                            showIcon.previousElementSibling.type = 'password';
                            showIcon.classList.remove('bx-hide');
                            showIcon.classList.add('bx-show');
                        }
                    }
                })
            }
            

    </script>


</body>
</html>