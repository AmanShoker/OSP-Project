<?php

class ShoppingCartTableController {

    public function createTable($conn){
        $sql = "CREATE TABLE IF NOT EXISTS ShoppingCartTable (
            cartItemId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            itemId INT(6) UNSIGNED,
            userId INT(6) UNSIGNED,
            price INT(6) NOT NULL,
            madeIn VARCHAR(30) NOT NULL,
            departmentCode INT(6) NOT NULL,
            FOREIGN KEY (itemID) REFERENCES ItemTable(itemID) ON DELETE CASCADE,
            FOREIGN KEY (userId) REFERENCES UserTable(userId) ON DELETE CASCADE
            )";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Shopping Cart Table created successfully";
        }
        else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    }

    public function deleteTable($conn){
        $sql = "DROP TABLE ShoppingCartTable";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Shopping Cart Table deleted successfully";
        }
        else {
            echo "Error deleting table: " . mysqli_error($conn);
        }
    }

    public function insertRecord($conn,$itemId,$userId,$price,$madeIn,$departmentCode){
        $sql = "INSERT INTO ShoppingCartTable (itemId,userId,price,madeIn,departmentCode) 
        VALUES ($itemId,$userId,$price,'$madeIn',$departmentCode)";

        if ($conn->query($sql) === TRUE) {
            echo "<br>New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function showShoppingCartItems($conn,$IID){
        $sql = "SELECT * FROM ShoppingCartTable WHERE userId = $UID";
        $result = $conn->query($sql);
        return $result;
    }

}
?>
