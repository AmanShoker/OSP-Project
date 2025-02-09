<?php

class UserTableController {

    public function createTable($conn){
        $sql = "CREATE TABLE IF NOT EXISTS UserTable (
            userId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            fullName VARCHAR(30) NOT NULL,
            telNo VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL,
            homeAddress VARCHAR(50) NOT NULL,
            cityCode CHAR(6) NOT NULL,
            username VARCHAR(30) NOT NULL,
            userPassword VARCHAR(30) NOT NULL,
            balance FLOAT
            )";

        if ($conn->query($sql) === TRUE) {
            echo "<br>User Table created successfully";
        }
        else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    }

    public function deleteTable($conn){
        $sql = "DROP TABLE UserTable";

        if ($conn->query($sql) === TRUE) {
            echo "<br>User Table deleted successfully";
        }
        else {
            echo "Error deleting table: " . mysqli_error($conn);
        }
    }

    public function insertRecord($conn,$fullName,$telNo,$email,$address,$cityCode,$username,$password,$balance){
        $sql = "INSERT INTO OrderTable (fullName,telNo,email,homeAddress,cityCode,username,userPassword,balance) 
        VALUES ($fullName,$telNo,$email,$address,$cityCode,$username,$password,$balance)";

        $sql2 = "SELECT * FROM UserTable WHERE username = $username OR userPassword = $password";
        $result = $conn->query($sql2);
        if (mysqli_num_rows($result) >= 1){
            return FALSE;
        }        
        if ($conn->query($sql) === TRUE) {
            echo "<br>New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function validLogin($conn,$usernameInput,$passwordInput){
        $sql = "SELECT * FROM UserTable WHERE username = $usernameInput AND userPassword = $passwordInput";
        $result = $conn->query($sql);
        if (mysqli_num_rows($result) == 1){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

}
?>
