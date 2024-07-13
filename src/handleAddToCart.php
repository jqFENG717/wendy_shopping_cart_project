<?php
//print("test1_AddToCart");
session_start();
//print("test2_AddToCart");
$total_number = 0;
$item_id = isset($_GET["itemID"]) ? intval($_GET["itemID"]) : 0;
$update_number = isset($_GET["updateNumber"]) ? intval($_GET["updateNumber"]) : 0;

if (!isset($_SESSION["shopping_cart"])) {
    $_SESSION["shopping_cart"] = array();
}

try {
    if ($item_id == 0) {
        foreach ($_SESSION["shopping_cart"] as $number) {
            $total_number += $number;
        }
        echo $total_number;
    } elseif ($item_id == -1) {
        session_unset();
        echo 0;
    } else {
        if (!array_key_exists($item_id, $_SESSION["shopping_cart"])) {
            $_SESSION["shopping_cart"][$item_id] = $update_number;
        } else {
            $_SESSION["shopping_cart"][$item_id] += $update_number;
        }

        if ($_SESSION["shopping_cart"][$item_id] <= 0) {
            unset($_SESSION["shopping_cart"][$item_id]);
        }

        foreach ($_SESSION["shopping_cart"] as $value) {
            $total_number += $value;
        }

        echo $total_number;
    }
} catch (Exception $e) {
    error_log("Error in handleAddToCart.php: " . $e -> getMessage());
    echo "Error!";
}

?>