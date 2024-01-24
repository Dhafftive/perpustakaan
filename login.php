
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Yeseva+One&display=swap" rel="stylesheet">
</head>
<body>
    <div class="bg-img"></div>
    <div class="head-page">
        <p class="logo">Bookshelf.<span>Idn</span></p>
        <div class="account-confirm"><p>kamu belum punya akun?</p><button class="sign-up"><a href="">Sign Up</a></button></div>
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