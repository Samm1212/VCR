<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sign up</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body style="background-color: #89CFF0;">
    <div class="pt-3"></div>
    <div class="container-fluid border rounded border-dark d-flex justify-content-center p-4" style="width: fit-content; background-color:honeydew; padding: 0.3em;">
            <div style="width: 200px;">
            <form action="register.php" method="post">
                <h2>SIGN UP</h2>
                <?php if(isset($_GET['error'])) { ?>
                    <p class="error"> <?php echo $_GET['error']; ?></p>
                <?php } ?>
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username"><br><br>
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password"><br><br>
                <label>Full Name</label>
                <input type="text" name="fullname" placeholder="Enter your full name"><br><br>
                <input type="radio" id="student" name="role" value="student" checked="true">
                <lable for="member">Student</lable><br>
                <input type="radio" id="admin" name="role" value="admin">
                <label for="admin">Admin</label><br>
                <div class="d-flex justify-content-center align-items-center pt-3 pb-4">
                <button type="submit" value="Submit">Submit</button>
                </div>
                <div class="container">
                <p>Already have an account?<br><a href="index.php">Login here</a></p>
                </div>
            </form>
            </div>
        </div>
    </body>
</html>