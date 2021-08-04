<?php

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, "utf-8");
}

function e($msg)
{
  echo "$msg\n";
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>TODO LIST</title>
  <link rel="stylesheet" href="styles.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <main>
    <header>
      <h1>TODO LIST</h1>
      <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <select name="field">
          <option value="blue">Daily</option>
          <option value="green">Homework</option>
          <option value="purple">Shopping</option>
          <option value="orange">Original</option>
        </select><br>
        <b>Title</b>: <br><input type="text" name="title"><br>
        <b>Comment</b>: <br><input type="text" name="comment"><br>
        <b>Due</b>: <br><input type="text" name="due_date"><br>
        <input type="submit" name="submit" value="Add">
        <input type="reset" name="reset" value="Reset">

      </form>
    </header>
    <hr>
    <div class="todos">
      <?php
      $lines = file("todo.txt");

      if (isset($_POST["submit"])) {
        $title = h($_POST["title"]);
        $comment = h($_POST["comment"]);
        $comment = str_replace("\r\n", "<br>", $comment);
        $comment = str_replace("\r", "<br>", $comment);
        $comment = str_replace("\n", "<br>", $comment);
        if (!$comment) {
          e("コメントを入力してください");
        }
        $items = @explode("\t", $lines[0]);
        $due_date = $_POST["due_date"];
        $no = @$items[3] + 1;
        $delno = @$items[3] + 1;;
        $color = $_POST["field"];

        $data = "$title\t$comment\t$due_date\t$no\t$delno\t$color\n";
        array_unshift($lines, $data);
      }

      foreach ($lines as $line) {
        $line = rtrim($line);
        $items = explode("\t", $line);
        echo '<div class="todo ' . $items[5]  . '">';
        echo $items[0];
        echo "<div class='comment'>" . $items[1] . "&nbsp;&nbsp;-" . $items[2];
      ?>
      <form action="delete.php" method="post" style="display: inline">
        <input type="hidden" name="delno" value="<?php echo $items[4] ?>">
        <input type="submit" name="delete" value="×">
      </form>
      <br>
      <?php
        echo "</div>";
        echo '</div>';
      }
      ?>

      <?php
      if (isset($_POST["submit"])) {
        $fp = fopen("todo.txt", "w");
        foreach ($lines as $line) {
          fputs($fp, $line);
        }
        fclose($fp);
      }
      ?>
    </div>
  </main>
</body>

</html>