<?php
include_once(SITE_PATH . 'inc' . DS . 'db.php');
Class Model {
	protected $db;
	protected $table;
    private $result;
	
	public function __construct($select = false){
		global $dbConnection;
		$this->db = $dbConnection;
		
		$modelName = get_class($this);
		$exp = explode('_', $modelName);
		$tableName = strtolower($exp[1]);
		$this->table = $tableName;


        $sql = $this->getConditions($select);
        if($sql) $this->getResult("SELECT * FROM $this->table" . $sql);


		
	}
	
	public function getTableName() {
		return $this->table;
	}

    private function getConditions($select) {
        if(is_array($select)){
            $cond = array_keys($select);
            foreach($cond as $key => $val){
                $cond[$key] = strtoupper($val);
            }

            $query = "";
            if(in_array("WHERE", $cond)){
                foreach($select as $key => $val){
                    if(strtoupper($key) == "WHERE"){
                        $query .= " WHERE " . $val;
                    }
                }
            }

            if(in_array("GROUP", $cond)){
                foreach($select as $key => $val){
                    if(strtoupper($key) == "GROUP"){
                        $query .= " GROUP BY " . $val;
                    }
                }
            }

            if(in_array("ORDER", $cond)){
                foreach($select as $key => $val){
                    if(strtoupper($key) == "ORDER"){
                        $query .= " ORDER BY " . $val;

                    }
                }
            }

            if(in_array("LIMIT", $cond)){
                foreach($select as $key => $val){
                    if(strtoupper($key) == "LIMIT"){
                        $query .= " LIMIT " . $val;
                    }
                }
            }

            return $query;
        }
        return false;
    }

    private function getResult($sql){
        try{
            $db = $this->db;
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $this->result = $rows;
        }catch(PDOException $e) {
            echo $e->getMessage();
            exit;
        }

        return $rows;
    }

    function getAllRows(){
        if(!isset($this->result) OR empty($this->result)) return false;
        return $this->result;
    }

    function getRowByID($id){
        try{
            $db = $this->db;
            $stmt = $db->prepare("SELECT * from $this->table WHERE id = $id");

            $row = $stmt->execute();
        }catch(PDOException $e) {
            echo $e->getMessage();
            exit;
        }
        return $row;
    }

    public function saveInTable($fields) {
          if(!empty($fields)){
            $fieldArr = array_keys($fields);
            $field = implode(', ', $fieldArr);
            $data = "'" . implode("','", $fields) . "'";

                try {
                    $db = $this->db;
                    $stmt = $db->prepare("INSERT INTO $this->table ($field) values ($data)");
                    $stmt->execute();
                    return true;
                }catch(PDOException $e){
                    echo 'Error : '.$e->getMessage();
                    echo '<br/>Error sql : ' . "'INSERT INTO $this->table ($field) values ($data)'";
                    return false;
                    exit();
                }
          }
    }

    function updateTable($fields, $id){
        $arrayForSet = array();
        foreach($fields as $field => $data){
             $arrayForSet[] = $field . ' = "' . $data . '"';
        }

        $strForSet = implode(', ', $arrayForSet);

        try {
            $db = $this->db;
            $stmt = $db->prepare("UPDATE $this->table SET $strForSet WHERE `id` = $id");
            $stmt->execute();
            }catch(PDOException $e){
                echo 'Error : '.$e->getMessage();
                echo '<br/>Error sql : ' . "'UPDATE $this->table SET ($field) value ($data) WHERE id = $id'";
                exit();
            }
    }
}