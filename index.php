<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id GROUP BY p.id');
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require 'templates/header.php' ?>

<div class="content home">
  <div id="main">
    <h2>Hääletused</h2>
    <p>Allpool kuvatakse kõik hääletused, kus te saate osaleda</p>
    <a href="create.php" class="create-poll">Loo küsitlus</a>
    <table>
      <tbody>
        <thead>
          <tr>
            <td>Jrk.</td>
            <td>Küsimus</td>
            <td>Vastusevariandid</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach($polls as $poll): ?>
            <tr>
              <td><?=$poll['id']?></td>
              <td><?=$poll['title']?></td>
              <td><?=$poll['answers']?></td>
              <td class="actions">
                <a href="vote.php?id=<?=$poll['id']?>" class="view" title="View Poll"><i class="fas fa-eye fa-xs"></i></a>
                <a href="delete.php?id=<?=$poll['id']?>" class="trash" title="Delete Poll"><i class="fas fa-trash fa-xs"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </tbody>
    </table>
  </div>
</div>

<style>
#main {
  padding-left: 100px;
  padding-right: 100px;
}
.content h2 {
  margin: 0;
  padding: 25px 0;
  font-size: 22px;
  border-bottom: 1px solid #ebebeb;
  color: #666666;
}
.home .create-poll {
  display: inline-block;
  text-decoration: none;
  background-color: #38b673;
  font-weight: bold;
  font-size: 14px;
  border-radius: 5px;
  color: #FFFFFF;
  padding: 10px 15px;
  margin: 15px 0;
}
.home .create-poll:hover {
  background-color: #32a367;
}
.home table {
  width: 100%;
  padding-top: 30px;
  border-collapse: collapse;
}
.home table thead {
  background-color: #ebeef1;
  border-bottom: 1px solid #d3dae0;
}
.home table thead td {
  padding: 10px;
  font-weight: bold;
  color: #767779;
  font-size: 14px;
}
.home table tbody tr {
  border-bottom: 1px solid #d3dae0;
}
.home table tbody tr:nth-child(even) {
  background-color: #fbfcfc;
}
.home table tbody tr:hover {
  background-color: #376ab7;
}
.home table tbody tr:hover td {
  color: #FFFFFF;
}
.home table tbody tr:hover td:nth-child(1) {
  color: #FFFFFF;
}
.home table tbody tr td {
  padding: 10px;
}
.home table tbody tr td:nth-child(1) {
  color: #a5a7a9;
}
.home table tbody tr td.actions {
  padding: 8px;
  text-align: right;
}
.home table tbody tr td.actions .view, .home table tbody tr td.actions .edit, .home table tbody tr td.actions .trash {
  display: inline-flex;
  text-align: right;
  text-decoration: none;
  color: #FFFFFF;
  padding: 10px 12px;
  border-radius: 5px;
}
.home table tbody tr td.actions .trash {
  background-color: #b73737;
}
.home table tbody tr td.actions .trash:hover {
  background-color: #a33131;
}
.home table tbody tr td.actions .edit {
  background-color: #37afb7;
}
.home table tbody tr td.actions .edit:hover {
  background-color: #319ca3;
}
.home table tbody tr td.actions .view {
  background-color: #37b770;
}
.home table tbody tr td.actions .view:hover {
  background-color: #31a364;
}
</style>