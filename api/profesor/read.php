<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Profesor.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Profesor object
  $profesor = new Profesor($db);

  // Blog post query
  $result = $profesor->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any Profesori exist
  if($num > 0) {
    // Profesori array
    $profesor_arr = array();
    

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $profesor_item = array(
        'id' => $profesor_id,
        'nume' => $nume,
        'prenume' => $prenume
      );

      // Push to "data"
      array_push($profesor_arr, $profesor_item);
     
    }

    // Turn to JSON & output
    echo json_encode($profesor_arr);

  } else {
    // No Profesors
    echo json_encode(
      array('message' => 'Nu exista Profesori de afisat.')
    );
  }