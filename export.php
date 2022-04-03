<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <script src="translate.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <article>
        <input type="text" id="t1" name="word" value="" readonly><br>
        <input type="text" id="t2" name="translation" value="" readonly><br>
        <button id="b1" onclick="ShowTranslation()">Показать перевод</button>
        <button id="b2" onclick="NextWord()">Следующее слово</button><br>
        <input type="text" id="t3" name="currentDict" value="" readonly><br>
    </article>
</body>

<?php
require_once 'db_connect.php';
$choice = $_POST['choiceDict'];
$queryExportDict = "select engWords,rusWords from $choice;";
$startExport = mysqli_query($dbcon, $queryExportDict);
$engWords = [];
$rusWords = [];
while ($item = mysqli_fetch_assoc($startExport)) {
    $engWords[] = $item['engWords'];
    $rusWords[] = $item['rusWords'];
}
mysqli_close($dbcon);
?>

<script>
    var i = -1;
    var changed = false;
    var chbox = document.getElementById('changeLang');
    var currentDict = <?php echo json_encode($choice) ?>;
    var getEngWords = <?php echo json_encode($engWords); ?>;
    var getRusWords = <?php echo json_encode($rusWords); ?>;
    var t1 = document.getElementById('t1');
    var t2 = document.getElementById('t2');
    var t3 = document.getElementById('t3');

    function checkChange() {
        if (chbox.checked) changed = true;
        else changed = false;
        NextWord();
    }

    function ShowTranslation() {
        if (changed == true) t2.setAttribute('value', getEngWords[i]);
        else t2.setAttribute('value', getRusWords[i]);
    }

    function NextWord() {
        t2.setAttribute('value', '? ? ?')
        if (i == getEngWords.length - 1) i = 0;
        else i++;
        if (changed == true) t1.setAttribute('value', getRusWords[i]);
        else t1.setAttribute('value', getEngWords[i]);
        var remains = getEngWords.length - i - 1;
        t3.setAttribute('value', 'Текущий словарь: ' + currentDict + ' (осталось слов: ' + remains + ' )');
    }
</script>