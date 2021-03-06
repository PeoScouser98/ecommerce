<?php
require './library/validate.php';
require './library/execute_query.php';
if (!isset($_COOKIE['user_id']))
    header("location:./");
$error = [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./site/view/node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./site/view/styles/css/login.css">
    <link rel="stylesheet" href="./site/view/styles/css/main.css" />
    <script src="./view/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d2bf59f6fb.js" crossorigin="anonymous"></script>
    <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
</head>


<body>
    <div class=" d-flex justify-content-center align-items-center position-fixed top-0 w-100 h-100">
        <form action="" method="POST" id="form" class="d-flex justify-content-center flex-column align-items-center p-5">
            <!-- title -->
            <h1 class="fw-light text-white text-center mb-5" style="font-size: 2.5em">Reset Password</h1>
            <div class="d-flex justify-content-center flex-column align-items-center gap-2 w-100">
                <!-- Verification code -->
                <div class="mb-3 w-100 h-auto">
                    <input type="text" class="form-control rounded-pill" name="code" id="" aria-describedby="helpId" placeholder="Verification Code" />
                    <small class="text-danger fw-bold">
                        <?php
                        check_empty('code', 'verification code');
                        ?>
                    </small>
                </div>
                <div class="mb-3 w-100 h-auto">
                    <input type="password" class="form-control rounded-pill" name="new_password" id="" aria-describedby="helpId" placeholder="New Password" />
                    <small class="text-danger fw-bold">
                        <?php
                        check_empty('new_password', 'new password');
                        check_length('new_password', 8, 'new password')
                        ?>
                    </small>
                </div>
                <div class="mb-3 w-100 h-auto">
                    <input type="password" class="form-control rounded-pill" name="cfm_password" id="" aria-describedby="helpId" placeholder="Confirm Password" />
                    <small class="text-danger fw-bold">
                        <?php
                        check_empty('cfm_password', 'confirm password');
                        check_matching('new_password', 'cfm_password', 'confirm password');

                        ?>
                    </small>
                </div>
                <div class="mb-5 w-100 h-auto d-flex justify-content-center">
                    <input type="submit" class="btn text-white rounded" name="change-password" id="submit-btn" value="Change Password" />
                </div>
                <p class="text-secondary text-center">Still haven't received code? <a href="./password-recover.php" class="ps-2 text-center text-white">Try again</a></p>
            </div>
        </form>
    </div>
</body>

</html>
<?php
if (isset($_POST['change-password']) && isset($_COOKIE['user_id'])) :
    $code = $_POST['code'];
    $verifyCode = select_one_value("SELECT user_password FROM users WHERE user_id = '{$_COOKIE['user_id']}'");
    echo $verifyCode;
    if (empty($error)) {
        if ($code == $verifyCode) {
            $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            execute_query("UPDATE users SET user_password = '{$newPassword}' WHERE user_id = '{$_COOKIE['user_id']}'");
            echo "<script>alert(`Change password successfully!`);</script>";
            setcookie("user_id", "", time() - 301);
            echo "<script>window.location = window.location.href</script>";
        } else
            echo "<script>alert(`Verification code is incorrect!`);</script>";
    } else
        echo "<script>alert(`Fail to change password!`);</script>";
endif;
