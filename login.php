<?php 

    if (isset($_POST['submit'])) {
        $user_name = trim(strip_tags($_POST['user_name'])) ? trim(strip_tags($_POST['user_name'])) : null;
        $user_password = trim(strip_tags($_POST['user_password'])) ? trim(strip_tags($_POST['user_password'])) : null;

        if (!$user_name) {
            $error = 'Please insert your username!';
        }else if (!$user_password) {
            $error = 'Please insert your password!';
        } else {

            $query = $db->prepare('SELECT * FROM users WHERE user_name = ?');
            $query->execute([
                $user_name
            ]);

            $rows = $query->fetch(PDO::FETCH_ASSOC);

            if ($rows) {

                $password_verify = password_verify($user_password , $rows['user_password']);

                if ($password_verify) {
                    $_SESSION['session'] = true;
                    $_SESSION['user_name'] = $rows['user_name'];
                    header('location:index.php');
                    exit;
                } else {
                    $error = 'Wrong password!';
                }
            } else {
                $error = "The username you specified is not found in the system.";
            }
        }

    }
    
    



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Crud PHP - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <style>
        .sign-in {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
          }

        .sign-in .form-floating:focus-within {
            z-index: 2;
        }

        .sign-in input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .sign-in input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>

</head>
<body>

    <div class="sign-in mt-3">
        <form method="POST" action="">
            <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>
        
            <div class="form-floating">
              <input name="user_name" type="text" class="form-control" id="floatingInput" placeholder="John">
              <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
              <input name="user_password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
              <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" name="submit" type="submit">Sign in</button>
            <?php if(isset($error)): ?>
            <div class="alert alert-danger mt-3">
                <?= $error ?>
            </div>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>