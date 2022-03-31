<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pdo_toets_herkansingen";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, burritoformaat, saus, bonen, rijst FROM burrito");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);

    $tableRows = "";
    foreach ($stmt->fetchALL() as $key=>$value) {
        $tableRows .="<tr>
                        <td>$value->id</td>
                        <td>$value->burritoformaat</td>
                        <td>$value->saus</td>
                        <td>$value->bonen</td>
                        <td>$value->rijst</td>
                        <td><a href='update.php?id=$value->id'><i class='bi bi-pencil-square'></i></></td>
                        <td><a href='delete.php?id=$value->id'><i class='bi bi-x-circle'></i></></td>
                    </tr>";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";

if (!empty($_GET)) {
    switch ($_GET["err"]) {
        case "conn-failed":
            $message = '<div class="alert alert-danger" style="text-align: center;" role="alert">
                        Connection failed
                        </div>';
            break;

        case "create-failed":
            $message = '<div class="alert alert-danger" style="text-align: center;" role="alert">
                        Failed creating record
                        </div>';
            break;
        case "update-failed":
            $message = '<div class="alert alert-danger" style="text-align: center;" role="alert">
                        Could not update this record
                        </div>';
            break;
        case "update-success":
            $message = '<div class="alert alert-success" style="text-align: center;" role="alert">
                        Succesfully updated
                        </div>';
            break;
        case "deleting-success":
            $message = '<div class="alert alert-success" style="text-align: center;" role="alert">
                        Succesfully deleted
                        </div>';
            break;
        case "deleting-failed":
            $message = '<div class="alert alert-danger" style="text-align: center;" role="alert">
                        Deleting failed
                        </div>';
            break;
        default:
            break;
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Maak je eigen burrito</title>
  </head>
  <body>
      <main class="container">
          <div class="row text-center">
              <div class="col-12">
              <h1>Maak je eigen burrito</h1>
            </div>

        <div class="row">
            <div class="col-3">
        </div>

        <div class="col-6">
            <form action="./create.php" method="post">
                <div class="mb-4">
                <label for="saus">Burritoformaat</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Maak je keuze</option>
                        <option value="1">20 cm</option>
                        <option value="2">25 cm</option>
                        <option value="3">30 cm</option>
                    </select>
                </div>
                <div class="mb-4">
                <label for="saus">Saus</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Maak je keuze</option>
                        <option value="1">Salsa crudo</option>
                        <option value="2">Salsa verde</option>
                        <option value="3">Salsa roja</option>
                        <option value="4">Creme fraiche</option>
                    </select>
                </div>
                <div class="mb-4">
                    <p>Kies je bonen:</p>
                    <div>
                        <input type="radio" id="Kidneybonen" name="Bonen" value="Bonen" checked>
                        <label for="Bonen">Kidney Bonen</label>
                    </div>
                    <div>
                        <input type="radio" id="Zwartebonen" name="Bonen" value="Bonen" checked>
                        <label for="Bonen">Zwarte bonen</label>
                    </div>
                    <div>
                        <input type="radio" id="Bruinebonen" name="Bonen" value="Bonen" checked>
                        <label for="Bonen">Bruine bonen</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-4">
                    <p>Kies je rijst:</p>
                    <div>
                        <input type="radio" id="Witterijst" name="rijst" value="rijst" checked>
                        <label for="rijst">Witte rijst</label>
                    </div>
                    <div>
                        <input type="radio" id="Zwarterijst" name="rijst" value="rijst" checked>
                        <label for="rijst">Zwarte rijst</label>
                    </div>
                    <div>
                        <input type="radio" id="Bruinerijst" name="rijst" value="rijst" checked>
                        <label for="rijst">Bruine rijst</label>
                    </div>
                    </div>
                </div>
                <div class="mb-3">
                    <input class="form-control btn btn-primary" type="submit" value="verstuur">
                </div>
            </form>
        </div>
        <a href="./read.php"><button type="button" class="btn btn-primary">verstuur</button></a>
        
        <div class= "col-3"></div>
    </div>

</main>
<!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>