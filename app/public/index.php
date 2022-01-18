<?php
$db_host = 'test_mysql';
$db_root = 'root';
$db_root_pass = '12345';
try {
    $mysql = new mysqli($db_host, $db_root, $db_root_pass);
    if (!$mysql->query("SHOW DATABASES LIKE 'app';")->fetch_array()){
        // создаём бд
        $mysql->query("CREATE DATABASE app");
        $mysql->select_db('app');
        // создаём в бд таблицу под справочник
        $mysql->query("CREATE TABLE `Handbook` (
                            `key` VARCHAR(255) PRIMARY KEY,
                            `value` VARCHAR(255) NOT NULL
                            ) ENGINE=InnoDB;");
    }
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}?>
<html>
    <head>
        <!-- подключаем jquery -->
        <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>
    </head>
    <body>
        <form>
            <input id="file-input" type="file" accept=".csv">
        </form>
        <button id="submit">Отправить</button>
        <script>
            // скрипт на посылание файла аяксом на бэк
            $('#submit').on('click',() => {
                let file = $('#file-input').prop('files')[0];
                let fd = new FormData;
                fd.append('csv',file);
                if (file != null) {
                    $.ajax({
                        url: 'post.php',
                        data: fd,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function (data) {
                            // скачиваем получившийся файл
                            window.location.href = "file.csv";
                        }
                    })
                };
            });
        </script>
    </body>
</html>

