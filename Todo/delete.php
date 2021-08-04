<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>todo delete</title>
</head>

<body>
  <a href="todo.php">->TODO LIST</a><br>
  <?php
  $lines = file('todo.txt');
  if (isset($_POST['delete'])) {
    for ($i = 0; $i < count($lines); $i++) {
      $items = explode("\t", $lines[$i]);

      if ($items[3] == $_POST['delno']) {
        array_splice($lines, $i, 1);
        header('Location: https://www.cc.kyoto-su.ac.jp/~g1842367/Todo/todo.php');
      }
    }
    $fp = fopen('todo.txt', 'w');
    foreach ($lines as $line) {
      fputs($fp, $line);
    }
    fclose($fp);
  }
  ?>
</body>

</html>