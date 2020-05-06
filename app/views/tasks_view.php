<div id="content" class="container-fluid bg-light">
    <div class="card-header bg-light">
    <div class="row">
        <div class="col"></div>
        <div class="col text-center"><span>Tasks </span><button onclick="showModalBoxNewTask();" class="btn btn-success">New</button></div>
        <div class="col"></div>
    </div>
    </div>
    <div class="card-body bg-light">
    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User</th>
            <th scope="col">Email</th>
            <th scope="col">Description</th>
            <th scope="col">Date create</th>
            <th scope="col">Status</th>
            <th hidden scope="col">tuid</th>
        </tr>
        </thead>
        <tbody>
  <?php
  $tasks = $model->getAllRows();
  foreach ($tasks as $task) {
      $arr = [$task['id'],$task['user'],$task['email'],$task['description'],$task['date_create'],$task['date_update'],$task['status'],$task['tuid'],$task['edited']];
      $str = addslashes(implode("~",$arr));
          ?>
            <tr>
                <th scope="row"><? echo $task['id']; ?></th>
                <td><a href="#" onclick="showModalWinTask('<?php echo $str; ?>'); return false;"><? echo $task['user']; ?></a></td>
                <td><a href="#" onclick="showModalWinTask('<?php echo $str; ?>'); return false;"><? echo $task['email']; ?></a></td>
                <td><a href="#" onclick="showModalWinTask('<?php echo $str; ?>'); return false;"><? echo $task['description']; ?></a></td>
                <td><a href="#" onclick="showModalWinTask('<?php echo $str; ?>'); return false;"><? echo $task['date_create']; ?></a></td>
                <?php
                if($task['edited'] == 1) {
                    $ed = "+ <i class='fas fa-user-edit'></i> Edited by admin";
                } else {
                    $ed = "";
                }
               if($task['status'] == 0) {
                   echo "<td><i class='far fa-clock'></i> Waiting {$ed}</td>";
               } elseif ($task['status'] == 1){
                    echo "<td><i class='far fa-check-circle'></i> Done {$ed}</td>";
                }  ?>
                <td hidden><? echo $task['tuid']; ?></td>
            </tr>
  <?php } ?>
        </tbody>
    </table>
    </div>
<script>
 $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            "lengthMenu": [[3, 6, 24, -1], [3, 6, 24, "All"]]
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>
</div>
<div id="myModalBoxNewTask"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" >New Task</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="username" class="col-md-2 col-form-label">Username:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Your name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your email" required>
                        </div>
                    </div>
                    <label for="description" class="col-md-2 col-form-label row">Description: </label>
                    <div class="form-group col-md-12">
                            <textarea class="form-control " id="description" placeholder="Describe the task" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="newTask" class="btn btn-primary">Create</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal" id="close">Close</button>

            </div>

        </div>
    </div>
</div>
<div id="myModalBoxTask"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" >Task #<span id="mtid"></span></h4>
            </div>
            <div class="modal-body">
                <form>
                    <b>User:</b> <span id="musr" ></span><br>
                    <b>Email:</b> <span id="meml"></span><br>
                    <b>Date Create:</b> <span id="mdc"></span><br>
                    <b>Date Update:</b> <span id="mdu"></span><br>
                    <b>Status:</b> <span id="mst"></span><br>
                    <b>Description:</b><? if(Auth::isAuth()){ ?><button  id="editDesc" class="btn"><i class="far fa-edit" onclick="editDesc(); return false;"></i></button><? } ?>
                    <textarea class="form-control" disabled id="mdesc"></textarea><br>
                    <input type="hidden" id="mtuid" value="">
                </form>
            </div>
            <div class="modal-footer">
                <? if(Auth::isAuth()){ ?>
                <button type="button" id="doneTask" class="btn btn-primary">Done</button>
                <button type="button" id="editTask" class="btn btn-primary" >Edit</button>
                <? } ?>
                <button type="button" class="btn btn-dark" data-dismiss="modal" id="taskClose">Close</button>
            </div>
        </div>
    </div>
</div>