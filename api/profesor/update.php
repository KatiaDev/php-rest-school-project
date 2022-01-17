<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Profesor.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Profesor object
  $profesor = new Profesor($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $profesor->profesor_id = $data->profesor_id;

  $profesor->nume = $data->nume;
  $profesor->prenume = $data->prenume;
  

  // Update Profesor
  if($profesor->update()) {
    echo json_encode(
      array('message' => 'Profesor Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Profesor Not Updated')
    );
  }