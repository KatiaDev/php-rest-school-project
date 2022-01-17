<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
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

  // Delete post
  if($profesor->delete()) {
    echo json_encode(
      array('message' => 'Profesor Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Profesor Not Deleted')
    );
  }