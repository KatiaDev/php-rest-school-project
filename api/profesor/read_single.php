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

  // Get ID
  $profesor->profesor_id = isset($_GET['profesor_id']) ? $_GET['profesor_id'] : die();

  // Get Profesor
  $profesor->read_single();

  // Create array
  $profesor_arr = array(
    'profesor_id' => $profesor->profesor_id,
    'nume' => $profesor->nume,
    'prenume' => $profesor->prenume
  );

  // Make JSON
  print_r(json_encode($profesor_arr));
 