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
        <div class="container-fluid">
            <form action="login.php" method="post">
                <h2>LOGIN</h2>
                <?php if(isset($_GET['error'])) { ?>
                    <p class="error"> <?php echo $_GET['error']; ?></p>
                <?php } ?>
                <label>Code</label>
                <input type="number" name="code" placeholder="Code"><br>
                <label>Password</label>
                <input type="password" name="password" placeholder="Password"><br>
                <input type="radio" id="member" name="role" value="member" checked="true">
                <lable for="member">Member</lable>
                <input type="radio" id="admin" name="role" value="admin">
                <label for="admin">Admin</label><br>

                <button type="submit" value="Submit">Login</button>
            </form>
        </div>
    </body>
</html>