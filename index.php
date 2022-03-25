<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <header>
        <div class="left">
            <form action="" method="post" id="topSubmit" enctype="multipart/form-data">
                <input type="file" name="file" accept=".csv" required />
                <input type="submit" value="Import" name="import" />
                <br>
            </form>
            <form action="" method="post" id="lowSubmit" onsubmit="">
                <select name="choiceDict" onchange='changed()'>
                    <option selected value="" disabled>Выбрать словарь</option>
                    <?php
                    $root = 'root';
                    $pass = '';
                    $host = 'localhost';
                    $db_name = 'dict1';
                    $db = new mysqli($host, $root, $pass, $db_name);
                    $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = N'$db_name'";
                    $result = $db->query($query);
                    while ($line = $result->fetch_row()) {
                        $query = "SELECT COUNT(*) FROM {$line[0]}";
                        echo "<option value='$line[0]'>$line[0]</option>";
                    }
                    ?>
                </select>
                <input type="submit" id="sub1" value="Export" name="export" disabled />
                <input type="submit" id="sub2" value="Delete" name="delete" disabled />
            </form>
        </div>
        <div class="right">
            <input class="checkbox" type="checkbox" name="lang" id="changeLang" onclick="checkChange()" />
            <label>ENG &rarr; RUS</label>
        </div>
    </header>
</body>

</html>

<?php
if (isset($_POST['import'])) {
    require_once 'import.php';
    header("Location: index.php");
    die;
}

if (isset($_POST['delete'])) {
    require_once 'delete.php';
    header("Location: index.php");
    die;
}
if (isset($_POST['export'])) {
    require_once 'export.php';
    echo "<script>",
    "NextWord();",
    "</script>";
}
?>

<script>
    var sub1 = document.getElementById('sub1');
    var sub2 = document.getElementById('sub2');

    function changed() {
        sub1.removeAttribute('disabled');
        sub2.removeAttribute('disabled');
    }
</script>