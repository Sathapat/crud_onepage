<?php 
    class DBcon{
        public $conn;
        public $sql;
        public $id;
        public $fname;
        public $lname;
        public $tel;
        public $date;
        public $search;

        function __construct(){
            $this->conn = new mysqli('localhost', 'root', '1234', 'test');
            if ($this->conn->connect_errno) {
                echo "Failed to connect to MySQL: " . $this->conn->connect_error;
            }
        }
        
        public function show(){
            $this->sql = "SELECT * FROM test";
            return $this->conn->query($this->sql);
        }

        public function search(){
            $this->sql = "SELECT * FROM test WHERE fname LIKE '%".$this->search."%'";
            return $this->conn->query($this->sql);
        }

        public function insert(){
            $this->sql = "INSERT INTO test (fname, lname, tel, date) VALUES('$this->fname', '$this->lname', '$this->tel', '$this->date')";
            return $this->conn->query($this->sql);
        }

        public function edit(){
            $this->sql = "UPDATE test SET fname = '$this->fname', lname = '$this->lname', tel = '$this->tel', date = '$this->date' WHERE id = '$this->id'";
            return $this->conn->query($this->sql);
        }

        public function delete(){
            $this->sql = "DELETE FROM test WHERE id = '$this->id'";
            return $this->conn->query($this->sql);
        }

    }
?>