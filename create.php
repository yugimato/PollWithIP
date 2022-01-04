<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $stmt = $pdo->prepare('INSERT INTO polls (title, description) VALUES (?, ?)');
    $stmt->execute([ $title, $description ]);
    $poll_id = $pdo->lastInsertId();
    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';
    foreach($answers as $answer) {
        if (empty($answer)) continue;
        $stmt = $pdo->prepare('INSERT INTO poll_answers (poll_id, title) VALUES (?, ?)');
        $stmt->execute([ $poll_id, $answer ]);
    }
    $msg = 'Küsitlus on edukalt loodud!';
}
?>

<script>
function limitTextareaLine(e) {
  const newLine = /\r*\n/g;
  const value = e.target.value;
  const newLines = (value.match(newLine) || []).length;

  const lines = value.split(newLine);

  //enter
  if (e.keyCode === 13 && lines.length >= e.target.rows) {
    e.preventDefault();
    return;
  }

  const lineNo = value.substr(0, e.target.selectionStart).split(newLine).length - 1;

  //backspace
  if (e.keyCode === 8 && ~value.charAt(e.target.selectionStart - 1).search(newLine)) {
    if (lines[lineNo].length + lines[lineNo - 1].length <= e.target.cols) return;

    e.preventDefault();
    return;
  }

  //del
  if (e.keyCode === 46 && ~value.charAt(e.target.selectionStart).search(newLine)) {
    if (lines[lineNo].length + lines[lineNo + 1].length <= e.target.cols) return;

    e.preventDefault();
    return;
  }

  if (e.key.length > 1) return;

  if (value.length < e.target.cols) return;

  if (lines[lineNo].length > e.target.cols - 1) {
    if (lines.length < e.target.rows) {
      const col = (e.target.selectionStart - newLines) / lines.length;
      let p1 = value.substr(0, e.target.selectionStart);
      if (col === e.target.cols) {
        p1 += '\r\n' + String.fromCharCode(e.keyCode);
      } else {
        p1 += String.fromCharCode(e.keyCode) + '\r\n';
      }

      e.target.value = p1 + value.substr(e.target.selectionStart, value.length);
      e.target.selectionStart = p1.length - 1;
      e.target.selectionEnd = p1.length - 1;
    }

    e.preventDefault();
    return;
  }
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelector('textarea.limited').addEventListener('keydown', limitTextareaLine);
});
</script>

<?php require 'templates/header.php' ?>

<div class="content update">
	<h2>Loo küsitlus</h2>
    <form action="create.php" method="post">
        <label for="title">Küsimus</label>
        <input type="text" name="title" id="title" placeholder="Küsimuse sisu" required>
        <label for="answers">Küsimuse vastused (iga vastus eraldi reale)</label>
        <textarea name="answers" class="limited" rows="3" id="answers" placeholder="Vastusevariandid" required></textarea>
        <input type="submit" value="Loo küsitlus">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<style>
.content {
    width: 1000px;
    margin: 0 auto;
}
.update form input, .update form textarea {
    padding: 10px;
    width: 100%;
    margin-right: 25px;
    margin-bottom: 15px;
    border: 1px solid #cccccc;
}
.update form textarea {
    height: 72px;
}
.update form input[type="submit"] {
    display: block;
    background-color: #38b673;
    border: 0;
    font-weight: bold;
    font-size: 14px;
    color: #FFFFFF;
    cursor: pointer;
    width: 200px;
    margin-top: 15px;
    border-radius: 5px;
}
.update form input[type="submit"]:hover {
    background-color: #32a367;
}
</style>