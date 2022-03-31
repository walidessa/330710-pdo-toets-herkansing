<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pdo_toets_herkansingen";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // sql to delete a record
  $sql = "DELETE FROM users WHERE id=:id";


  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);

  if (!isset($_GET['id'])) {
      header("Location: ./index.php");
      exit();
  }


  $id = $_GET['id'];


  // echo met een bericht dat het is verwijderd

  $stmt->execute();
  echo "Record met id={$id} is verwijderd!";
  header("Refresh:3; ./read.php");
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>