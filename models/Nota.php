<?php 
  class Nota {
    // DB stuff
    private $conn;
    private $table = 'nota';

    // Nota Properties
    public $nota_id;
    public $nota;
    public $data;
    public $elev_id;
    public $tema_id;
    public $prof_disciplina_id;
   

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Note
    public function read() {
      // Create query
      $query = 'SELECT e.nume as nume, e.prenume as prenume,t.denumire as tema,d.denumire as disciplina, p.nume as prof_nume, p.prenume as prof_prenume,
                  n.nota_id, n.nota, n.data
                 FROM ' . $this->table . ' n
                 LEFT JOIN elev e ON n.elev_id = e.elev_id
                 LEFT JOIN tema t ON n.tema_id = t.tema_id
                 LEFT JOIN prof_disciplina pd ON n.prof_disciplina_id = pd.prof_disciplina_id
                 LEFT JOIN disciplina d ON pd.disciplina_id = d.disciplina_id
                 LEFT JOIN profesor p ON pd.profesor_id = p.profesor_id
                   ORDER BY
                    n.data DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Nota
    public function read_single() {
          // Create query
    $query = 'SELECT e.nume as nume, e.prenume as prenume,t.denumire as tema,d.denumire as disciplina, p.nume as prof_nume, p.prenume as prof_prenume,
                 n.nota_id, n.nota, n.data
                  FROM ' . $this->table . ' n
                  LEFT JOIN elev e ON n.elev_id = e.elev_id
                  LEFT JOIN tema t ON n.tema_id = t.tema_id
                  LEFT JOIN prof_disciplina pd ON n.prof_disciplina_id = pd.prof_disciplina_id
                  LEFT JOIN disciplina d ON pd.disciplina_id = d.disciplina_id
                  LEFT JOIN profesor p ON pd.profesor_id = p.profesor_id
                       WHERE
                          n.nota_id = ?
                        LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->nota_id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->nota_id = $row['nota_id'];
          $this->nota = $row['nota'];
          $this->data = $row['data'];
          $this->nume = $row['nume'];
          $this->prenume = $row['prenume'];
          $this->tema = $row['tema'];
          $this->disciplina = $row['disciplina'];
          $this->prof_nume = $row['prof_nume'];
          $this->prof_prenume = $row['prof_prenume'];
    
          
    }

    // Create Nota
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET nota = :nota, data = :data, prof_disciplina_id = :prof_disciplina_id, 
                            elev_id = :elev_id, tema_id = :tema_id ';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->nota = htmlspecialchars(strip_tags($this->nota));
          $this->data = htmlspecialchars(strip_tags($this->data));
          $this->elev_id = htmlspecialchars(strip_tags($this->elev_id));
          $this->tema_id = htmlspecialchars(strip_tags($this->tema_id));
          $this->prof_disciplina_id = htmlspecialchars(strip_tags($this->prof_disciplina_id));


          // Bind data
          $stmt->bindParam(':nota', $this->nota);
          $stmt->bindParam(':data', $this->data);
          $stmt->bindParam(':elev_id', $this->elev_id);
          $stmt->bindParam(':tema_id', $this->tema_id);
          $stmt->bindParam(':prof_disciplina_id', $this->prof_disciplina_id);


          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Nota
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . ' SET nota = :nota, data = :data, prof_disciplina_id = :prof_disciplina_id, 
                        elev_id = :elev_id, tema_id = :tema_id
                                WHERE nota_id = :nota_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data 
          $this->nota_id = htmlspecialchars(strip_tags($this->nota_id));
          $this->nota = htmlspecialchars(strip_tags($this->nota));
          $this->data = htmlspecialchars(strip_tags($this->data));
          $this->elev_id = htmlspecialchars(strip_tags($this->elev_id));
          $this->tema_id = htmlspecialchars(strip_tags($this->tema_id));
          $this->prof_disciplina_id = htmlspecialchars(strip_tags($this->prof_disciplina_id));

          // Bind data
          $stmt->bindParam(':nota_id', $this->nota_id);
          $stmt->bindParam(':nota', $this->nota);
          $stmt->bindParam(':data', $this->data);
          $stmt->bindParam(':elev_id', $this->elev_id);
          $stmt->bindParam(':tema_id', $this->tema_id);
          $stmt->bindParam(':prof_disciplina_id', $this->prof_disciplina_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Nota
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE nota_id = :nota_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->nota_id = htmlspecialchars(strip_tags($this->nota_id));

          // Bind data
          $stmt->bindParam(':nota_id', $this->nota_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }