<?php
// TODO 1: PREPARING ENVIRONMENT: 1) session 2) functions
session_start();

$aConfig = require_once 'dbConnect.php';

// TODO 2: ROUTING
if (!empty($_SESSION['auth'])) {
    header('Location: /admin.php');
    die;
}

// TODO 3: CODE by REQUEST METHODS (ACTIONS) GET, POST, etc. (handle data from request): 1) validate 2) working with data source 3) transforming data

// 1. Create empty $infoMessage
$infoMessage = '';

// 2. handle form data


if (!empty($_POST['email']) && !empty($_POST['password'])) {

    $isAlreadyRegistered = false;

    // 3. Check that user has already existed
    $db = mysqli_connect(
        $aConfig['host'],
        $aConfig['user'],
        $aConfig['pass'],
        $aConfig['name']
    );

    $dbResponse = mysqli_query($db, 'SELECT * FROM users');
    $aUsers = mysqli_fetch_all($dbResponse, MYSQLI_ASSOC);
    mysqli_close($db);

    foreach ($aUsers as $user) {
        if (($user['email'] == $_POST['email']) && ($user['password'] == $_POST['password'])) {
            $isAlreadyRegistered = true;

            $infoMessage = "Такой пользователь уже существует! Перейдите на страницу входа. ";
            $infoMessage .= "<a href='/login.php'>Страница входа</a>";
        }
    }

    if (!$isAlreadyRegistered) {
        // 4. Create new user

        $db = mysqli_connect(
            $aConfig['host'],
            $aConfig['user'],
            $aConfig['pass'],
            $aConfig['name']
        );
        $query = "INSERT INTO users (email, password) VALUES (
        '" . $_POST['email'] . "',
        '" . $_POST['password'] . "'
        )";
        mysqli_query($db, $query);
        mysqli_close($db);
        header('Location: /login.php');
        die;
    }
}
elseif (!empty($_POST)) {
    $infoMessage = 'Заполните форму регистрации!';
}

// TODO 4: RENDER: 1) view (html) 2) data (from php)

?>


<!DOCTYPE html>
<html>

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">

    <?php require_once 'sectionNavbar.php' ?>

    <br>

    <div class="card card-primary">
        <div class="card-header bg-success text-light">
            Register form
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email"/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password"/>
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="formRegister"/>
                </div>
            </form>

            <!-- TODO: render php data   -->
            <?php
                if ($infoMessage) {
                    echo '<hr/>';
                    echo "<span style='color:red'>$infoMessage</span>";
                }
            ?>

        </div>

    </div>
</div>

</body>
</html>