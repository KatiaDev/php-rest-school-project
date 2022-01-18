<?php 
  class Elev {
    // DB stuff
    private $conn;
    private $table = 'elev';

    // Elev Properties
    public $elev_id;
    public $nume;
    public $prenume;
    public $email;
    public $clasa_id;
   

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Elevi
    public function read() {
      // Create query
      $query = 'SELECT  e.elev_id, e.nume, e.prenume, e.email, e.clasa_id
                                FROM ' . $this->table . ' e
                                LEFT JOIN clasa c ON e.clasa_id = c.clasa_id
                                ';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Elev
    public function read_single() {
          // Create query
          $query = 'SELECT e.elev_id, e.nume, e.prenume, e.email, e.clasa_id
                                FROM ' . $this->table . ' e
                                LEFT JOIN clasa c ON e.clasa_id = c.clasa_id
                                WHERE e.elev_id = ? 
                                LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->elev_id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->elev_id = $row['elev_id'];
          $this->nume = $row['nume'];
          $this->prenume = $row['prenume'];
          $this->email = $row['email'];
          $this->clasa_id = $row['clasa_id'];


          
    }

    // Create Elev
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET nume = :nume, prenume = :prenume email = :email clasa_id = :clasa_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->nume = htmlspecialchars(strip_tags($this->nume));
          $this->prenume = htmlspecialchars(strip_tags($this->prenume));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->clasa_id = htmlspecialchars(strip_tags($this->clasa_id));

          // Bind data
          $stmt->bindParam(':nume', $this->nume);
          $stmt->bindParam(':prenume', $this->prenume);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':clasa_id', $this->clasa_id);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Elev
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET nume = :nume, prenume = :prenume email = :email clasa_id = :clasa_id
                                WHERE elev_id = :elev_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data 
          $this->nume = htmlspecialchars(strip_tags($this->nume));
          $this->prenume = htmlspecialchars(strip_tags($this->prenume));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->clasa_id = htmlspecialchars(strip_tags($this->clasa_id));
          $this->elev_id = htmlspecialchars(strip_tags($this->elev_id));

          // Bind data
          $stmt->bindParam(':nume', $this->nume);
          $stmt->bindParam(':prenume', $this->prenume);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':clasa_id', $this->clasa_id);
          $stmt->bindParam(':elev_id', $this->elev_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Elev
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE elev_id = :elev_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->elev_id = htmlspecialchars(strip_tags($this->elev_id));

          // Bind data
          $stmt->bindParam(':elev_id', $this->elev_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }