<?php 
  class Profesor {
    // DB stuff
    private $conn;
    private $table = 'profesor';

    // Profesor Properties
    public $profesor_id;
    public $nume;
    public $prenume;
   

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Profesori
    public function read() {
      // Create query
      $query = 'SELECT  p.profesor_id, p.nume, p.prenume
                                FROM ' . $this->table . ' p';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Profesor
    public function read_single() {
          // Create query
          $query = 'SELECT  p.profesor_id, p.nume, p.prenume
                                    FROM ' . $this->table . ' p
                                    WHERE
                                      p.profesor_id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->profesor_id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->profesor_id = $row['profesor_id'];
          $this->nume = $row['nume'];
          $this->prenume = $row['prenume'];
          
    }

    // Create Profesor
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET nume = :nume, prenume = :prenume';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->nume = htmlspecialchars(strip_tags($this->nume));
          $this->prenume = htmlspecialchars(strip_tags($this->prenume));

          // Bind data
          $stmt->bindParam(':nume', $this->nume);
          $stmt->bindParam(':prenume', $this->prenume);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Profesor
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET nume = :nume, prenume = :prenume
                                WHERE profesor_id = :profesor_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data 
          $this->nume = htmlspecialchars(strip_tags($this->nume));
          $this->prenume = htmlspecialchars(strip_tags($this->prenume));
          $this->profesor_id = htmlspecialchars(strip_tags($this->profesor_id));

          // Bind data
          $stmt->bindParam(':nume', $this->nume);
          $stmt->bindParam(':prenume', $this->prenume);
          $stmt->bindParam(':profesor_id', $this->profesor_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Profesor
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE profesor_id = :profesor_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->profesor_id = htmlspecialchars(strip_tags($this->profesor_id));

          // Bind data
          $stmt->bindParam(':profesor_id', $this->profesor_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }