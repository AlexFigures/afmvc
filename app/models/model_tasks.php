<?php

Class Model_tasks extends Model {

    public $id;
    public $user;
    public $email;
    public $description;
    public $tuid;
    public $date_create;
    public $date_update;
    public $status;
    public $fields;


    public function fieldsTable(){
        return [
            'id' => 'id',
            'user' => 'User',
            'email' => 'email',
            'description' => 'description',
            'tuid' => 'tuid',
            'date_create' => 'date_create',
            'date_update' => 'date_update',
            'status' => 'status'
        ];
    }

    public function getTaskByUID($tuid){
        try{
            $db = $this->db;
            $stmt = $db->prepare("SELECT * from $this->table WHERE tuid = '{$tuid}'");
            $stmt->execute();
            $row = $stmt->fetch();
        }catch(PDOException $e) {
            echo $e->getMessage();
            echo '<br/>Error sql : ' . "'SELECT * from $this->table WHERE tuid = $tuid'";
            exit;
        }
        return $row;
    }

		
}