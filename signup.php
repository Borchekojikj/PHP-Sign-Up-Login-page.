<?php
session_start();


?>


<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
</head>

<body>

    <?php


    if (isset($_SESSION['status']) && isset($_SESSION['msgs'])) {

        echo "<div class='container'><div class='row'><div class='col'>";

        // print_r($_SESSION['msgs']);
        // // die();
        if ($_SESSION['status'] == 'error') {

            if (!empty($_SESSION['msgs'])) {
                echo "<div class='alert alert-danger'><ul>";

                foreach ($_SESSION['msgs'] as $msg) {
                    echo "<li>$msg</li>";
                }
                echo "</ul></div>";
            }

            if (isset($_SESSION['emailTaken'])) {
                $emailTaken = $_SESSION['emailTaken'];
                echo "<div class='alert alert-warning'><ul>";
                echo "<li>$emailTaken</li>";
                echo "</ul></div>";
                unset($_SESSION['emailTaken']);
            }
        }

        echo "</div></div></div>";
    }

    unset($_SESSION['msgs']);
    unset($_SESSION['status']);
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <h1>Sign up form</h1>
                <form action="auth.php" method="POST">
                    <input type="hidden" name="action" value="signup"></input>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input class="form-control" type="text" placeholder="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" placeholder="Email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input class="form-control" type="password" placeholder="Password" name="password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center" style="height: 50px;">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <div class="d-flex p-1 ">
                            <p class="my-0 me-2">Already have an Account?</p>
                            <a href="./login.php" style="text-decoration: none;">Login</a>
                        </div>
                    </div>

                </form>
            </div>


        </div>
    </div>

    <!-- POPPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>