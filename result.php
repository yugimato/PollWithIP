<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($poll) {
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ? ORDER BY votes DESC');
        $stmt->execute([ $_GET['id'] ]);
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total_votes = 0;
        foreach($poll_answers as $poll_answer) {
            $total_votes += $poll_answer['votes'];
        }
    } else {
        exit('Poll with that ID does not exist.');
    }
} else {
    exit('No poll ID specified.');
}
$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);// If the GET request "id" exists (poll id)...
$idene = $_GET['id'];
$stmt = $pdo->prepare('SELECT COUNT(ip) FROM poll_votes WHERE id = ?');
$result = $stmt->execute([$idene]);
$count = $stmt->fetch(PDO::FETCH_NUM)[0];

?>
<?php require 'templates/header.php' ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>
    <div class="card" id="card">
      <h2 style="color: white"><?=$poll['title']?></h2>
      <div class="content poll-result">
        <div class="wrapper">
          <?php foreach ($poll_answers as $poll_answer): ?>
            <div id="pollAnswers" class="poll-question mt-2">
              <p class="text-center"><?=$poll_answer['title']?> <span>(<?=$poll_answer['votes']?>)</span></p>
              <div class="result-bar" style= "background: linear-gradient(to right, #157902 <?=@round(($poll_answer['votes']/$total_votes)*100)?>%, #9df08d <?=@round(($poll_answer['votes']/$total_votes)*100)?>%)">
                <?=@round(($poll_answer['votes']/$total_votes)*100)?>%
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        </div>
        <div id="lowerBar">
          <p style="color: white">Küsitluses on osalenud <?=$count?> inimest</p>
        </div>
      </div>
    </div>
  </body>
</html>

<style>
#pollAnswers {
  padding-left: 30px;
}
#lowerBar {
  background-color: #05951b;
  height: 30px;
  width: 100%;
}
#card {
  margin-top: 100px;
  width: 27rem;
  background-color: #b0d203;
  text-align: center;
  margin-left: 38%;
  justify-content: center;
}
#percentage{
  display: flex;
  float: right;
}
#main {
  display: flex;
  justify-content: center;
  flex-direction: row;
}
.content {
  width: 800px;
}
.poll-vote form {
  display: flex;
  flex-flow: column;
}
.poll-vote form label {
  padding-bottom: 10px;
}
.poll-vote form input[type="radio"] {
  transform: scale(1.1);
}
.poll-vote form input[type="submit"]:hover, .poll-vote form a:hover {
  background-color: #32a367;
}
.poll-vote form a:hover {
  background-color: #319ca3;
}
.poll-result .wrapper {
  display: flex;
  flex-flow: column;
}
.poll-result .wrapper .poll-question {
  width: 50%;
  padding-bottom: 5px;
}
.poll-result .wrapper .poll-question p {
  margin: 0;
  padding: 5px 0;
}
.poll-result .wrapper .poll-question p span {
  font-size: 14px;
}
.poll-result .wrapper .poll-question .result-bar {
  display: flex;
  height: 25px;
  min-width: 5%;
  background-color: lime;
  border-radius: 5px;
  font-size: 14px;
  color: white;
  justify-content: center;
  align-items: center;
}
</style>