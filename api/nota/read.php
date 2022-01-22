<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Nota.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Nota object
  $nota = new Nota($db);

  // Nota query
  $result = $nota->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any Note exist
  if($num > 0) {
    // Note array
    $note_arr = array();
    

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $nota_item = array(
        'id' => $nota_id,
        'nota' => $nota,
        'data' => $data,
        'nume' => $nume,
        'prenume' => $prenume,
        'tema' => $tema,
        'disciplina' => $disciplina,
        'prof_nume' => $prof_nume,
        'prof_prenume' => $prof_prenume
        
      );

      // Push to "data"
      array_push($note_arr, $nota_item);
     
    }

    // Turn to JSON & output
    echo json_encode($note_arr);

  } else {
    // No Note
    echo json_encode(
      array('message' => 'Nu exista Note de afisat.')
    );
  }