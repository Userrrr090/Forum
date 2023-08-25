<?php
// TODO 1: PREPARING ENVIRONMENT: 1) session 2) functions
session_start();

$aConfig = require_once 'dbConnect.php';

// TODO 2: ROUTINGсв

// TODO 3: CODE by REQUEST METHODS (ACTIONS) GET, POST, etc. (handle data from request): 1) validate 2) working with data source 3) transforming data

if(!empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['comment'])){

    $db = mysqli_connect(
        $aConfig['host'],
        $aConfig['user'],
        $aConfig['pass'],
        $aConfig['name']
    );
    $query = "INSERT INTO comments (email, name, comment) VALUES (
        '". $_POST['email']."',
        '". $_POST['name']."',
        '". $_POST['comment']."'
        )";
    mysqli_query($db, $query);
    mysqli_close($db);

    /*$fUserComments = 'comments.csv';
    $jsonString = json_encode($_POST); // преобразуем массив в json-строку

    $fileStream = fopen($fUserComments, 'a'); // открыть (и создать) файл
    fwrite($fileStream, $jsonString."\n"); // записать json-строку в конец файла
    fclose($fileStream); // закрыть файл*/


}
// TODO 4: RENDER: 1) view (html) 2) data (from php)

?>

<!DOCTYPE html>
<html>

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">

    <!-- navbar menu -->
    <?php require_once 'sectionNavbar.php' ?>
    <br>

    <!-- guestbook section -->
    <div class="card card-primary">
        <div class="card-header bg-primary text-light">
            GuestBook form
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6">

                 <!-- TODO: create guestBook html form   -->
                    <form method="post">

                        <label for="email">Email:</label>
                        <input id="email" type="email" name="email" value="">
                        <label for="name">Name:</label>
                        <input id="name" type="text" name="name" value="">
                        <label for="comment">Comment:</label><br>
                        <textarea id="comment" name="comment"></textarea><br>
                        <input type="submit" value="Send">

                    </form>

                </div>
            </div>

        </div>
    </div>

    <br>

    <div class="card card-primary">
        <div class="card-header bg-body-secondary text-dark">
            Сomments
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">

                    <!-- TODO: render guestBook comments   -->

                    <?php

                    $db = mysqli_connect(
                        $aConfig['host'],
                        $aConfig['user'],
                        $aConfig['pass'],
                        $aConfig['name']
                    );

                    $dbResponse = mysqli_query($db, 'SELECT * FROM comments');
                    $aComments = mysqli_fetch_all($dbResponse, MYSQLI_ASSOC);
                    mysqli_close($db);

                    foreach ($aComments as $comment) {
                        echo $comment['email'] . '<br>'; // вывести значение по ключу
                        echo $comment['name'] . '<br>'; // вывести значение по ключу
                        echo $comment['comment'] . '<br><hr>'; // вывести значение по ключу

                    }



                        /*if (file_exists('comments.csv')) { // проверяет, что файл существует
                            $fileStream = fopen('comments.csv', "r"); // открывает файл
                            while (!feof($fileStream)) { // идет по файлу, пока не будет достигнут конец
                                $jsonString = fgets($fileStream); // получает очередную строку файла
                                $array = json_decode($jsonString, true); // преобразует строку в массив
                                if (empty($array))
                                    break; // если нет данных, то конец файла и остановка
                                echo $array['email'] . '<br>'; // вывести значение по ключу
                                echo $array['name'] . '<br>'; // вывести значение по ключу
                                echo $array['comment'] . '<br><hr>'; // вывести значение по ключу
                            }
                            fclose($fileStream); // закрыть файл
                        }*/

                    ?>

                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
