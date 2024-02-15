
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="bg-img"></div>
    <div class="head-page">
        <p class="logo">Bookshelf.<span>Idn</span></p>
        <div class="account-confirm"><p>kamu belum punya akun?</p><button class="sign-up"><a href="sign-up.php">Sign Up</a></button></div>
    </div>
    <div class="page-login">
        <h1 class="hdr">Masuk Akun</h1>
        <form action="process_login.php" method="post">
            <div class="input-form">
                <label for="username">Username atau email</label>
                <input placeholder="Masukkan username atau email" id="username" type="text" name="username" required>
                <label for="password">Password</label>
                <input placeholder="Masukkan password" type="password" id="password" name="password" required>
            </div>
            <input type="submit" value="Login" name="login">
        </form>
    </div>

</body>
</html>