<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
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

  $profesor->nume = $data->nume;
  $profesor->prenume = $data->prenume;
  

  // Create new Profesor
  if($profesor->create()) {
    echo json_encode(
      array('message' => 'Profesor Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Profesor Not Created')
    );
  }