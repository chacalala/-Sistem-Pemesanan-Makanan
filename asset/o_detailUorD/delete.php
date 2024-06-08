<?php
// delete.php

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    include("../connection.php");

    $sql = "DELETE FROM `order` WHERE id = '$id'"; 

    if (mysqli_query($conn, $sql)) {
        header("Location: ../order_detail.php?");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "ID pesanan tidak valid.";
}

?>
