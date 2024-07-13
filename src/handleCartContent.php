<?php

// retrieve all the categories that the items in the database table belong to. Then it sends the list of categories (no duplication) back to the client in JSON.
    session_start();
    //Connect to database
    $servername = "127.0.0.1"; // or the server's IP address
    $username = "root";
    $password = "........";
    $database = "shopping_cart"; // specify the new database name here

    $conn = mysqli_connect($servername, $username, $password, $database);
    
    #$message = "Hello, World!";
    #echo "<script>console.log('$message');</script>";

    if (!$conn) {
        die("Connection failed: " . mysqli_error($conn));
    }

    //echo "Connected successfully to the database $database";    
    //Select database
    #mysqli_select_db($conn, 'shopping_cart') or die('Error! '. mysqli_error($conn));
    $my_obj = new stdClass();
    $my_obj -> itemId = array();
    $my_obj -> itemQuantity = array();
    $my_obj -> itemImage = array();
    $my_obj -> itemName = array();
    $my_obj -> itemPrice = array();
    $my_obj -> itemDescription = array();
    $my_obj -> total_number_of_items_in_shopping_cart = 0;
    $my_obj -> total_price_of_items_in_shopping_cart = 0;
    $x = 0;
    if (!isset($_SESSION["shopping_cart"])){
      // ChromePhp::log('$_SESSION["shopping_cart"] is not set!');
    }
    
    if(isset($_SESSION["shopping_cart"])){

      foreach($_SESSION["shopping_cart"] as $key => $value){

         $my_obj -> itemId[$x] = $key;
         $my_obj -> itemQuantity[$x] = $value;
         $my_obj -> total_number_of_items_in_shopping_cart += $value;
         //Construct your SQL query here, selects the item which matches the id.
         $query = "SELECT * FROM catalog WHERE itemID='".$key."'";
       	//Execute SQL query
         $result = mysqli_query($conn, $query) or die('Error! '. mysqli_error($conn));
         $row = mysqli_fetch_array($result);

         $my_obj -> itemImage[$x] = $row['itemImage'];
         $my_obj -> itemName[$x] = $row['itemName'];
         $my_obj -> itemPrice[$x] = $row['itemPrice'];
         $my_obj -> total_price_of_items_in_shopping_cart += $row['itemPrice']*$value;
         $my_obj -> itemDescription[$x] = $row['itemDescription'];
         $x += 1;
      }
    }

    $my_JSON = json_encode($my_obj);
    print $my_JSON;
?>
