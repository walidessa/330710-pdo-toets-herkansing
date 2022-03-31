<?php 

Class pdo_handler{

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "pdo_toets_herkansingen";
    public $conn;
    public $logs = [];

    public function __construct()
    {
        try{
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username,$this->password);
        
            // set the PDO error mode to exception
        
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            array_push($this->logs, "connected succesfully");
        }
        catch(PDOException $e){
            array_push($this->logs,"connection failed: " . $e->getMessage());
            header("Location: ./index.php?err=con-failed");
        }

        
    }

    public function create($burritoformaat,$saus,$bonen,$rijst){
        try{
            $sql = $this->conn->prepare("INSERT INTO burrito (burritoformaat, saus, bonen, rijst)
            VALUES (:burritoformaat, :saus, :bonen, :rijst)");

            $sql->bindParam(':burritoformaat', $burritoformaat);
            $sql->bindParam(':saus', $saus);
            $sql->bindParam(':bonen', $bonen);
            $sql->bindParam(':rijst', $rijst);
            $sql->execute();

            header("location: ./read.php");
        }catch(PDOException $e){
            array_push($this->logs,"inserting failed" . $e->getMessage());
            header("Location: ./index.php?err=create-failed");
        }
        
    }

    public function read(){
        try{
            $sql = $this->conn->prepare("SELECT * FROM burrito");
            $sql->execute();

            $result = $sql->setFetchMode(PDO::FETCH_ASSOC);

            $records = "";
            while($record = $sql->fetch()){
                $records .= "<tr>
                <th scope='row'>" . $record["id"] . "</th>
                <td> " . $record["burritoformaat"] . "</td>
                <td> " . $record["saus"] . "</td>
                <td> " . $record["bonen"] . "</td>
                <td> " . $record["rijst"] . "</td>
                <td>
                    <a href='./update.php?id=" . $record['id'] . "'>
                    update
                    </a>
                </td>
                <td>
                    <a href='./delete.php?id=" . $record['id'] . "'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x' viewBox='0 0 16 16'>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                        </svg>
                    </a>
                </td>   
                </tr>";
            }
            return $records;

        }catch(PDOException $e){
            array_push($this->logs,"reading failed" . $e->getMessage());
        }
    }

    public function getInfoById($id){
        try{
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $sql = $this->conn->prepare("SELECT * FROM burrito WHERE id = $id");
        $sql->execute();

        $result = $sql->setFetchMode(PDO::FETCH_ASSOC);

        return $sql->fetch();

        }
        catch(PDOException $e){
            array_push($this->logs, "getting info failed" . $e->getMessage());
            header("Location: ./index.php?err=update-failed");
        }


    }

    public function update(){
        try{
            $burritoformaat = $this->sanitize($_POST["burritoformaat"]);
            $saus = $this->sanitize($_POST["saus"]);

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


            $id = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);


            $sql = $this->conn->prepare("UPDATE `burrito` SET `burritoformaat`=:burritoformaat,`saus`=:saus,`bonen`=:bonen,`rijst`=:rijst WHERE `burrito`.`id`= $id;");

            $sql->bindParam(':burritoformaat', $burritoformaat);
            $sql->bindParam(':saus', $saus);
            $sql->bindParam(':bonen', $bonen);
            $sql->bindParam(':rijst', $rijst);

            $sql->execute();

            header("Location: ./index.php?err=update-success");

        }catch(PDOException $e){
            echo $e->getMessage();
            exit();
            array_push($this->logs, "updating failed" . $e->getMessage());
            header("Location: ./index.php?err=update-failed");
        }
    }


    public function delete(){
        try{
            $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);

            $sql = $this->conn->prepare("DELETE FROM burrito WHERE id = :id");

            $sql->bindParam(":id", $id);

            $sql->execute();

            header("Location: ./index.php?err=deleting-success");
        }
        catch(PDOException $e){
            array_push($this->logs, "deleting failed" . $e->getMessage());
            header("Location: ./index.php?err=deleting-failed");
        }
    }

    public function sanitize($raw_data) {
        $data = filter_var($raw_data, FILTER_SANITIZE_STRING);
        $data = trim($data);
        return $data;
      }

}