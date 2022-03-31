<?php
// ob_start();
//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "pdo-sandbox-b";

//try {
   // $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
   // $stmt = $conn->prepare("INSERT INTO users (id, firstname, infix, lastname)
   // VALUES (:id, :firstname, :infix, :lastname)");
   // $stmt->bindParam(':id', $id);
   // $stmt->bindParam(':firstname', $firstname);
    //$stmt->bindParam(':infix', $infix);
    //$stmt->bindParam(':lastname', $lastname);

    // insert a row
  //  $id = NULL;
   // $firstname = $_POST["firstname"];
   // $infix = $_POST["infix"];
   // $lastname = $_POST["lastname"];

    //var_dump($stmt->queryString);

   // $stmt->execute();

  //  echo "New record created successfully";
   // header("Refresh:3; ./read.php");
//}catch(PDOException $e) {
  //  echo $e->getMessage();
   // header("Location: ./index.php");
//}
//$conn = null;
?>

<?php 

include("./pdo_handler.php");

$db_manager = new pdo_handler();


$burittoformaat = $db_manager->sanitize($_POST["burritoformaat"]);
$saus = $db_manager->sanitize($_POST["saus"]);


$bonen = "";

if(isset($_POST["Kidney bonen"])){
    $bonen.= "Kidney bonen";
}
if(isset($_POST["Zwarte bonen"])){
    $bonen.= "Zwarte bonen ";
}
if(isset($_POST["Bruine bonen"])){
    $bonen.= "Bruine bonen ";
}


$rijst = "";

if(isset($_POST["Witte rijst"])){
    $rijst.= "Witte rijst";
}
if(isset($_POST["Zwarte rijst"])){
    $rijst.= "Zwarte rijst ";
}
if(isset($_POST["Bruine rijst"])){
    $rijst.= "Bruine rijst ";
}


$db_manager->create($burritoformaat,$saus,$bonen,$rijst);


?>