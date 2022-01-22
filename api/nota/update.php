<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Nota.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Nota object
  $nota = new Nota($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $nota->nota_id = $data->nota_id;

  $nota->nota = $data->nota;
  $nota->data = $data->data;
  $nota->elev_id = $data->elev_id;
  $nota->prof_disciplina_id = $data->prof_disciplina_id;
  $nota->tema_id = $data->tema_id;
  

  // Update Nota
  if($nota->update()) {
    echo json_encode(
      array('message' => 'Nota successfully Updated.')
    );
  } else {
    echo json_encode(
      array('message' => 'Nota Not Updated')
    );
  }