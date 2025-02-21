<?php

class TripTableController {

    public function createTable($conn){
        $sql = "CREATE TABLE IF NOT EXISTS TripTable (
            tripId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            sourceCode VARCHAR(30) NOT NULL,
            destinationCode VARCHAR(30) NOT NULL,
            distance FLOAT NOT NULL,
            truckId INT(6) UNSIGNED,
            price FLOAT NOT NULL,
            FOREIGN KEY (truckId) REFERENCES TruckTable(truckId) ON DELETE CASCADE
            )";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Trip Table created successfully";
        }
        else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    }

    public function deleteTable($conn){
        $sql = "DROP TABLE TripTable";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Trip Table deleted successfully";
        }
        else {
            echo "Error deleting table: " . mysqli_error($conn);
        }
    }

    public function insertRecord($conn,$sourceCode,$destinationCode,$distance,$truckId,$price){
        $sql = "INSERT INTO TripTable (sourceCode,destinationCode,distance,truckId,price) 
        VALUES ('$sourceCode','$destinationCode',$distance,$truckId,$price)";

        if ($conn->query($sql) === TRUE) {
            echo "<br>New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

}
?>
