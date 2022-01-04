<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);// If the GET request "id" exists (poll id)...

$stmt = $pdo->prepare('SELECT * FROM poll_votes WHERE IP = ? AND ID = ?');
$result = $stmt->execute([ $ip, $_GET['id'] ]);
$exist = $stmt->fetch();

if ($exist) {
    header('Location: result.php?id=' . $_GET['id']);
    exit;
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($poll) {
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([ $_GET['id'] ]);
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($_POST['poll_answer'])) {
            $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?');
            $stmt->execute([ $_POST['poll_answer'] ]);
            $stmt = $pdo->prepare('INSERT INTO poll_votes (ip, id) VALUES (?, ?)');
            $stmt->execute([ $ip, $_GET['id'] ]);
            header('Location: result.php?id=' . $_GET['id']);
            exit;
        }
    } else {
        exit('Poll with that ID does not exist.');
    }
} else {
    exit('No poll ID specified.');
}
?>
<?php require 'templates/header.php' ?>

<div class="content poll-vote">
	<h2><?=$poll['title']?></h2>
	<p><?=$poll['description']?></p>
    <form action="vote.php?id=<?=$_GET['id']?>" method="post">
        <?php for ($i = 0; $i < count($poll_answers); $i++): ?>
        <label>
            <input type="radio" name="poll_answer" value="<?=$poll_answers[$i]['id']?>"<?=$i == 0 ? ' checked' : ''?>>
            <?=$poll_answers[$i]['title']?>
        </label>
        <?php endfor; ?>
        <div>
            <input type="submit" value="Vote">
            <a href="result.php?id=<?=$poll['id']?>">Vaata tulemusi</a>
        </div>
    </form>
</div>

<style>
.content {
    width: 1000px;
    margin: 0 auto;
}
.content h2 {
    margin: 0;
    padding: 25px 0;
    font-size: 22px;
    border-bottom: 1px solid #ebebeb;
    color: #666666;
}
.poll-vote form {
    display: flex;
    flex-flow: column;
}
.poll-vote form label {
    padding-bottom: 10px;
}
.poll-vote form input[type="submit"], .poll-vote form a {
    display: inline-block;
    padding: 8px;
    border-radius: 5px;
    background-color: #38b673;
    border: 0;
    font-weight: bold;
    font-size: 14px;
    color: #FFFFFF;
    cursor: pointer;
    width: 150px;
    margin-top: 15px;
}
.poll-vote form a {
    text-align: center;
    text-decoration: none;
    background-color: #37afb7;
    margin-left: 5px;
}
</style>