<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="password.css">
    <meta charset="UTF-8">
</head>
<body>
    <h1>Change Password<hr></h1>
    <div class="box box1">
        <div class="header">
            Basic Info
        </div>
        <div class="nameemail">
            <p><strong>Name: </strong>Placeholder Name</p>
            <p><strong>Email: </strong><?php echo $_SESSION['email'] ?></p>
        </div>
    </div>
    <div class="box box2">
        <div class="header">
            Change Password
        </div>
        <form class="changepassword">
            <p>
                <strong>New Password</strong>
            </p>
            <input type="password" maxlength="20">
            <p>
                <strong>Confirm Password</strong>
            </p>
            <input type="password" maxlength="20">
            <br><br>
            <input type="submit">
        </div>
    </div>
</body>