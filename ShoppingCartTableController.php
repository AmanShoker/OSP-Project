<?php

class ShoppingCartTableController {

    public function createTable($conn){
        $sql = "CREATE TABLE IF NOT EXISTS ShoppingCartTable (
            itemId INT(6) UNSIGNED,
            userId INT(6) UNSIGNED,
            itemName VARCHAR(30) NOT NULL,
            price FLOAT NOT NULL,
            madeIn VARCHAR(30) NOT NULL,
            departmentCode CHAR(1) NOT NULL,
            PRIMARY KEY(itemId, userId),
            FOREIGN KEY (itemId) REFERENCES ItemTable(itemId) ON DELETE CASCADE,
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

    public function addToCart($conn,$itemId,$userId,$itemName,$price,$madeIn,$departmentCode){
        $sql = "INSERT INTO ShoppingCartTable (itemId,userId,itemName,price,madeIn,departmentCode) 
        VALUES ($itemId,$userId,'$itemName',$price,'$madeIn','$departmentCode')";

        if ($conn->query($sql) === TRUE) {
            echo "<br>New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function removeFromCart($conn,$IID,$UID){
        $sql = "DELETE FROM ShoppingCartTable WHERE itemId = $IID AND userId = $UID";

        if ($conn->query($sql) === TRUE) {
            echo "<br>New record deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function getShoppingCartItems($conn,$UID){
        $sql = "SELECT itemId,itemName,price,madeIn,departmentCode FROM ShoppingCartTable WHERE userId = $UID";
        $result = $conn->query($sql);
        return $result;
    }

    public function getSpecificCartItem($conn,$UID,$IID){
        $sql = "SELECT * FROM ShoppingCartTable WHERE userId = $UID AND itemId = $IID";
        $result = $conn->query($sql);
        return $result;
    }


}
?>
