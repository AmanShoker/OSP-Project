<?php

class ShoppingTableController {

    public function createTable($conn){
        $sql = "CREATE TABLE IF NOT EXISTS ShoppingTable (
            receiptId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            storeCode INT(6) NOT NULL,
            totalPrice INT(6) NOT NULL
            )";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Shopping Table created successfully";
        }
        else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    }

    public function deleteTable($conn){
        $sql = "DROP TABLE ShoppingTable";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Shopping Table deleted successfully";
        }
        else {
            echo "Error deleting table: " . mysqli_error($conn);
        }
    }

    public function insertRecord($conn,$storeCode,$totalPrice){
        $sql = "INSERT INTO ShoppingTable (storeCode,totalPrice) 
        VALUES ($storeCode,$totalPrice)";

        if ($conn->query($sql) === TRUE) {
            echo "<br>New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

}
?>
