<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Pendaftaran Siswa</title>


    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Custom styles for this template -->
    <link href="../src/signin.css" rel="stylesheet">
    <link href="../src/mycss.css" rel="stylesheet">
</head>
</head>

<body class="text-center">
    <?php include "../config.php" ?>
    <?php
    session_start();
    if (isset($_COOKIE['cookielogin'])) {
        $username = $_COOKIE['cookielogin']['user'];
        $password = $_COOKIE['cookielogin']['pass'];
        $sql = "SELECT * FROM `login` WHERE nim = '$username'";
        $query = mysqli_query($koneksi, $sql);
        $login = mysqli_fetch_object($query);


        if ($username == $login->nim && $password == $login->password) {
            $_SESSION['logged'] = 1;
            $_SESSION['username'] = $login->nim;
            header('Location: ../index.php');
        } else {
            header('Location: ../index.php');
        }
    } elseif (isset($_SESSION['logged'])) {
        header('Location: index.php');
    }
    ?>


    <form class="form-signin" method="POST" action="proses-login.php">
        <a href="../index.php" class="navbar-brand">
            <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        </a>
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <?php if (isset($_GET['login'])) : ?>
            <p>
                <div class="alert alert-danger" role="alert">
                    Usrname atau Password yang anda masukkan salah
                </div>
            </p>
        <?php endif; ?>
        <label for="inputUsername" class="sr-only">NIM</label>
        <input type="text" name="username" id="inputEmail" class="form-control" placeholder="EX : xx.xx.xxx" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me" name="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="sign-in">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>


    <?php require "../tema/footer.php" ?>