<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Virtual Chat Room</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <div class="container-fluid border border-dark d-flex justify-content-center pt-4" style="width: fit-content;">
            <div style="width: 200px;">
            <form action="login.php" method="post">
                <h2>LOGIN</h2>
                <?php if(isset($_GET['error'])) { ?>
                    <p class="error"> <?php echo $_GET['error']; ?></p>
                <?php } ?>
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username"><br><br>
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password"><br><br>
                <input type="radio" id="student" name="role" value="student" checked="true">
                <lable for="member">Student</lable><br>
                <input type="radio" id="admin" name="role" value="admin">
                <label for="admin">Admin</label><br>
                <div class="d-flex justify-content-center align-items-center pt-3 pb-4">
                <button type="submit" value="Submit">Login</button>
                </div>
                <div class="container">
                <p>Don't have an account?<a href="signup.php">Sign up here</a></p>
                </div>
            </form>
            </div>
        </div>
    </body>
</html>