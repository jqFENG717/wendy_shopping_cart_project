<?php
  //print("Hello, world!");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  header('Content-Type: application/json');

  # Connect to database
  $servername = "127.0.0.1";
  $username = "root";
  $password = "........";
  $database = "shopping_cart";

  $conn = mysqli_connect($servername, $username, $password, $database);

  if (!$conn) {
      http_response_code(500);
      echo json_encode(array("error" => "Connection failed: " . mysqli_connect_error()));
      exit();
  }

  # Select database
  mysqli_select_db($conn, 'shopping_cart') or die(json_encode(array("error" => mysqli_error($conn))));

  # Construct your SQL query here, selects all entries from the stockList table.
  $query = 'SELECT DISTINCT itemCategory FROM catalog ORDER BY itemCategory';

  # Execute SQL query
  $result = mysqli_query($conn, $query);

  if (!$result) {
      http_response_code(500);
      echo json_encode(array("error" => mysqli_error($conn)));
      exit();
  }

  //create an array, add data to it from datatbase, with no duplication
  $my_obj = array();

  while($row = mysqli_fetch_array($result)){

    if (!in_array($row['itemCategory'], $my_obj) ){
      array_push($my_obj, $row['itemCategory']);
    }

  }

  //print_r($my_obj);

  $my_JSON = json_encode($my_obj);
  //print $my_JSON;
  echo $my_JSON;
?>

