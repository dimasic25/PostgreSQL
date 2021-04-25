<?php

try {
    $myPDO = new PDO("pgsql:host=localhost;port=5432;dbname=blog", "postgres", "01234567");
    echo "Соединение успешно<br>";


    $sql = 'SELECT * FROM posts';



    echo "Список постов<br>";
    foreach ($myPDO->query($sql) as $row) {
        print "<br>";
        echo sprintf("%d - %10s , %20s , %s<br>", $row['id'], $row['title'], $row['content'], $row['date']);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
