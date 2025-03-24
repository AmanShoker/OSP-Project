<?php

class ReviewTableController {

    public function createTable($conn){
        $sql = "CREATE TABLE IF NOT EXISTS ReviewTable (
            reviewId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userId INT(6) UNSIGNED,
            review VARCHAR(150) NOT NULL,
            RN INT(6) UNSIGNED NOT NULL,
            FOREIGN KEY (userId) REFERENCES UserTable(userId) ON DELETE CASCADE
            )";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Review Table created successfully";
        }
        else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    }

    public function deleteTable($conn){
        $sql = "DROP TABLE ReviewTable";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Review Table deleted successfully";
        }
        else {
            echo "Error deleting table: " . mysqli_error($conn);
        }
    }

    public function createReview($conn,$UID,$review,$RN){
        $sql = "INSERT INTO ReviewTable (userId,review,RN) 
        VALUES ($UID,'$review',$RN)";
        $conn->query($sql);
    }

    public function getAllReviews($conn){
        $sql = "SELECT review,RN FROM ReviewTable";
        $result = $conn->query($sql);
        return $result;
    }

}
?>
