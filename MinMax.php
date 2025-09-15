<?php
include_once "LogicalTest.php";

$min = null;
$max = null;
$factResults = [];


if (isset($_GET['btn_submit']) && $_GET['num1'] !== '' && $_GET['num2'] !== '' && $_GET['num3'] !== '') {
    $num1 = (int) $_GET['num1'];
    $num2 = (int) $_GET['num2'];
    $num3 = (int) $_GET['num3'];

    $result = LogicalTest::MinMax([$num1, $num2, $num3]);
    $min = $result['min'];
    $max = $result['max'];


    foreach ([$num1, $num2, $num3] as $num) {
        $fact = 1;
        for ($i = 1; $i <= $num; $i++) {
            $fact *= $i;
        }
        $factResults[$num] = $fact;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Largest Number</title>
</head>
<body>
    <h2>Find Minimum Or Maximum Number</h2>
    <form action="" method="GET">
        <label>Enter 1st Number:</label><br>
        <input type="number" name="num1" required value="<?= isset($_GET['num1']) ? htmlspecialchars($_GET['num1']) : '' ?>"><br><br>

        <label>Enter 2nd Number:</label><br>
        <input type="number" name="num2" required value="<?= isset($_GET['num2']) ? htmlspecialchars($_GET['num2']) : '' ?>"><br><br>

        <label>Enter 3rd Number:</label><br>
        <input type="number" name="num3" required value="<?= isset($_GET['num3']) ? htmlspecialchars($_GET['num3']) : '' ?>"><br><br>

        <button type="submit" name="btn_submit">Submit</button>
    </form>

<?php
if (isset($_GET['btn_submit']) && $_GET['num1'] !== '' && $_GET['num2'] !== '' && $_GET['num3'] !== '') {
    echo '<h2>The largest number is <b style="color:red">' . $max . '</b> among those numbers</h2>';
}
?>


</body>
</html>
