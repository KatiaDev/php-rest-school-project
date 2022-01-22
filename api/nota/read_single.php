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

  // Get ID
  $nota->nota_id = isset($_GET['nota_id']) ? $_GET['nota_id'] : die();

  // Get Nota
  $nota->read_single();

  // Create array
  $note_arr = array(
    'nota_id' => $nota->nota_id,
    'nota' => $nota->nota,
    'data' => $nota->data,
    'nume' => $nota->nume,
    'prenume' => $nota->prenume,
    'tema' => $nota->tema,
    'disciplina' => $nota->disciplina,
    'prof_nume' => $nota->prof_nume,
    'prof_prenume' => $nota->prof_prenume

  );

  // Make JSON
  print_r(json_encode($note_arr));
 