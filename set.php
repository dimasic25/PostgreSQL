<html lang="rus">
<head><title>Изменение данных</title></head>
<body>
<form method='get' action='set.php'>
    Введите id записи: <input type='text' name='id'>
    <input type='submit' value='Загрузить'>
</form>


<?php
try {
    $myPDO = new PDO("pgsql:host=localhost;port=5432;dbname=blog", "postgres", "01234567");

    // Здесь обновляется запись в базе
    if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['date'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $date = $_POST['date'];
        $id = $_POST['read_id'];

        $sql1 = "UPDATE posts SET title=:title, content=:content, date=:date WHERE id=:id";
        $stmt1 = $myPDO->prepare($sql1);
        $stmt1->bindParam(':id', $id);
        $stmt1->bindParam(':title', $title);
        $stmt1->bindParam(':content', $content);
        $stmt1->bindParam(':date', $date);
        $stmt1->execute();
        echo "Данные успешно обновлены";
        $flag = false;
    }
    // Здесь мы получаем запись по id
    if (isset($_GET['id'])) {
        try {
            $id = $_GET['id'];
            errorId($id);
            $id = +$id;

            $sql = "SELECT * FROM posts WHERE id=:id";
            $stmt = $myPDO->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_LAZY);
            echo <<< _END
<form method="post" action="set.php">
    <input type='text' name='read_id' value="$row[0]" readonly>
    <br><br>
    <input type='text' name='title' value="$row[1]">
    <br><br>
    <textarea name='content'>$row[2]</textarea>
    <br><br>
   <input type='date' name='date' value="$row[3]">
    <br><br>
    <input type='submit' value='Загрузить'>
</form>
_END;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}


/**
 * @throws Exception
 */
function errorId($id)
{
    if (!is_numeric($id)) throw new Exception("id должно быть целочисленным");
    if (!is_int(+$id) || $id <= 0) throw new Exception("Неверное id");
}

?>

</body>
</html>
