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

  // Get ID
  $elev->elev_id = isset($_GET['elev_id']) ? $_GET['elev_id'] : die();

  // Get Elev
  $elev->read_single();

  // Create array
  $elev_arr = array(
    'id' => $elev->elev_id,
    'nume' => $elev->nume,
    'prenume' => $elev->prenume,
    'email' => $elev->email,
    'clasa_id' => $elev->clasa_id

  );

  // Make JSON
  print_r(json_encode($elev_arr));
 