<?php

class ItemTableController {

    public function createTable($conn){
        $sql = "CREATE TABLE IF NOT EXISTS ItemTable (
            itemId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            imageLoc VARCHAR(50) NOT NULL,
            itemName VARCHAR(30) NOT NULL,
            price FLOAT NOT NULL,
            madeIn VARCHAR(30) NOT NULL,
            departmentCode CHAR(1) NOT NULL
            )";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Item Table created successfully";
        }
        else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    }

    public function deleteTable($conn){
        $sql = "DROP TABLE ItemTable";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Item Table deleted successfully";
        }
        else {
            echo "Error deleting table: " . mysqli_error($conn);
        }
    }

    public function insertRecord($conn,$imageLoc,$itemName,$price,$madeIn,$departmentCode){
        $sql = "INSERT INTO ItemTable (imageLoc,itemName,price,madeIn,departmentCode) 
        VALUES ('$imageLoc','$itemName',$price,'$madeIn','$departmentCode')";
        if ($conn->query($sql) === TRUE) {
            echo "<br>New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    public function getSpecificItem($conn,$IID){
        $sql = "SELECT itemName,price,madeIn,departmentCode FROM ItemTable WHERE itemId = $IID";
        $result = $conn->query($sql);
        return $result;
    }

    public function getAllItems($conn){
        $sql = "SELECT * FROM ItemTable";
        $result = $conn->query($sql);
        return $result;
    }

}
?>
