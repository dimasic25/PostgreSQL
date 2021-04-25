<html lang="rus">
<head><title>Ввод данных</title></head>
<body>
<form method='post' action='insert.php'>
    Введите название поста: <input type='text' name='title'>
    <br><br>
    <textarea name='content'>Текст поста</textarea>
    <br><br>
    Введите дату: <input type='date' name='date'>
    <br><br>
    <input type='submit' value='Загрузить'>
</form>

<?php
if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['date'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date'];
    try {
        $myPDO = new PDO("pgsql:host=localhost;port=5432;dbname=blog", "postgres", "01234567");
        $sql = "INSERT INTO posts (title, content, date) VALUES (:title, :content, :date)";
        $stmt = $myPDO->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        echo "Данные внесены!";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

</body>
</html>
