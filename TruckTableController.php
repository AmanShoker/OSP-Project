<?php

class TruckTableController {

    public function createTable($conn){
        $sql = "CREATE TABLE IF NOT EXISTS TruckTable (
            truckId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            truckCode VARCHAR(6) NOT NULL,
            availabilityCode INT(6) NOT NULL
            )";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Truck Table created successfully";
        }
        else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    }

    public function getTableInfo($conn){
        $sql = "DESCRIBE TruckTable";
        $result = $conn->query($sql);
        return $result;
    }

    public function getForeignKeys($conn){
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE CONSTRAINT_NAME IN (SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE CONSTRAINT_TYPE = 'FOREIGN KEY' AND TABLE_NAME = 'TruckTable');";
        $result = $conn->query($sql);
        return $result;
    }

    public function deleteTable($conn){
        $sql = "DROP TABLE TruckTable";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Truck Table deleted successfully";
        }
        else {
            echo "Error deleting table: " . mysqli_error($conn);
        }
    }

    public function insertRecord($conn,$truckCode,$availabilityCode){
        $sql = "INSERT INTO TruckTable (truckCode,availabilityCode) 
        VALUES ('$truckCode',$availabilityCode)";

        if ($conn->query($sql) === TRUE) {
            echo "<br>New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function getTruckID($conn, $truckCode) {
        $sql = "SELECT truckId FROM TruckTable WHERE truckCode = '$truckCode'";
        $result = $conn->query($sql);
        return $result;
    }
}
?>
