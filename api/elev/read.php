<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Elev.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Elev object
  $elev = new Elev($db);

  // Elev query
  $result = $elev->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any Elevi exist
  if($num > 0) {
    // Elevi array
    $elevi_arr = array();
    

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $elev_item = array(
        'id' => $elev_id,
        'nume' => $nume,
        'prenume' => $prenume,
        'email' => $email,
        'clasa_id' => $clasa_id
      );

      // Push to "data"
      array_push($elevi_arr,  $elev_item);
     
    }

    // Turn to JSON & output
    echo json_encode($elevi_arr);

  } else {
    // No Elevi
    echo json_encode(
      array('message' => 'Nu exista Elevi de afisat.')
    );
  }