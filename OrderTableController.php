<?php

class OrderTableController {

    public function createTable($conn){
        $sql = "CREATE TABLE IF NOT EXISTS OrderTable (
            orderId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            dateIssued VARCHAR(30) NOT NULL,
            dateReceived VARCHAR(30) NOT NULL,
            totalPrice FLOAT NOT NULL,
            paymentCode INT(6) NOT NULL,
            userId INT(6) UNSIGNED,
            tripId INT(6) UNSIGNED,
            receiptId INT(6) UNSIGNED,
            FOREIGN KEY (userId) REFERENCES UserTable(userId) ON DELETE CASCADE,
            FOREIGN KEY (tripId) REFERENCES TripTable(tripId) ON DELETE CASCADE,
            FOREIGN KEY (receiptId) REFERENCES ShoppingTable(receiptId) ON DELETE CASCADE
        )";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Order Table created successfully";
        }
        else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    }

    public function deleteTable($conn){
        $sql = "DROP TABLE OrderTable";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Order Table deleted successfully";
        }
        else {
            echo "Error deleting table: " . mysqli_error($conn);
        }
    }

    public function insertRecord($conn,$dateIssued,$dateReceived,$totalPrice,$paymentCode,$userId,$tripId,$receiptId){
        $sql = "INSERT INTO OrderTable (dateIssued,dateReceived,totalPrice,paymentCode,userId,tripId,receiptId) 
        VALUES ($dateIssued,$dateReceived,$totalPrice,$paymentCode,$userId,$tripId,$receiptId)";

        if ($conn->query($sql) === TRUE) {
            echo "<br>New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function showOrderHistory($conn,$UID){
        $sql = "SELECT * FROM OrderTable WHERE userId = $UID";
        $result = $conn->query($sql);
        return $result;
    }

}
?>
