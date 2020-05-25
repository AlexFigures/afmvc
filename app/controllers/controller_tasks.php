<?php

Class Controller_tasks extends Controller
{

	function __construct()
	{
        $select = [
            'order' => 'id'
        ];

	    $this->view = new View();
	    $this->model = new Model_tasks($select);
	}

	function action_index() {
	    $model = $this->model;
    	$this->view->vars('model', $model);
		$this->view->gen('tasks_view', 'main_view');
	}

	function action_addTask(){
	    if((isset($_POST['mode'])) == 'add_task') {
            $username = trim(strip_tags(($_POST['username'])));
            $email = trim(strip_tags(($_POST['email'])));
            $description = trim(strip_tags(($_POST['desc'])));
            $tuid = md5(uniqid (rand (),false));

            $fields = [
            'user' => $username,
            'email' => $email,
            'description' => $description,
            'tuid' => $tuid
            ];
            header('Content-type: application/json');
            if($this->model->saveInTable($fields)) {
                $task = $this->model->getTaskByUID($tuid);
                echo json_encode($task);
            } else {
                echo json_encode(['addCheck' => false]);
            } ;
        }
    }

    function action_editTask(){
        if(Auth::isAuth()) {
            if (($_POST['mode']) == 'edit_task') {
                $description = trim(strip_tags(($_POST['desc'])));
                $tuid = trim(strip_tags(($_POST['tuid'])));
                $task = $this->model->getTaskByUID($tuid);
                $id = $task['id'];
                $date_update = date('Y-m-d H:i:s');
                if (!empty($task)) {
                    if ($task['description'] !== $description) {
                        $fields = [
                            'description' => $description,
                            'edited' => '1',
                            'date_update' => $date_update
                        ];
                        $this->model->updateTable($fields, $id);
                    }
                }
            }
        }
    }

    function action_doneTask(){
        if(Auth::isAuth()) {
            if (($_POST['mode']) == 'done_task') {
                $tuid = trim(strip_tags(($_POST['tuid'])));
                $task = $this->model->getTaskByUID($tuid);
                $id = $task['id'];
                $date_update = date('Y-m-d H:i:s');
                if (!empty($task)) {
                    $fields = [
                        'status' => '1',
                        'date_update' => $date_update
                    ];
                    $this->model->updateTable($fields, $id);
                }
            }
        }
	}

	function action_test(){
        $tuid = md5(uniqid (rand (),false));
        $fields = [
            'user' => '1266666666663',
            'email' => '123@test.ru',
            'description' => '12345',
            'tuid' => $tuid
        ];
        header('Content-type: application/json');
        if($this->model->saveInTable($fields)) {
            $task = $this->model->getTaskByUID($tuid);
            $task[] = ["addCheck" => true];
            echo json_encode($task);
        } else {
            echo json_encode(["addCheck" => false]);
        } ;
    }
}