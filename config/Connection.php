<?php 
require_once 'Config.php';
class Connection extends Config{
  protected $link;
  protected $pdo;
  public function __construct() {

  }

  protected function getConnection (){
			
			try {
				
				$this->pdo = new PDO('mysql:host='.parent::SERVER.';dbname='.parent::DBNAME, parent::USER, parent::PASS);
        // echo 'CONEXION ESTABLECIDA <br>';
        $this->link = $this->pdo;
			} catch (PDOException $e) {
				
				print("Error en la conexion: " . $e->getMessage());
				die();
			}
    }
  protected function clearConnection() {
    $this->pdo = null;
    $this->link = null;
  }
}