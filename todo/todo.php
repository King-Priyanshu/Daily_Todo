<?php
session_start();
include 'connection.php';
$msg = '';
$check = false;

if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];



$result = mysqli_query($conn, "SELECT * FROM tasks where email = '$email'");




if(isset($_POST['addbtn'])){
    $task = $_POST['task'];
    $sql =("INSERT INTO tasks (task , email ) VALUES ('$task', '$email')");
    mysqli_query($conn, $sql);
    $msg = "Task added successfully";
    $check = true;
    header("Location: todo.php");
    exit();
  
}

// else{
//     $msg = "Task not added";
//     $check =  true;
// }

if ($check) {
    echo "<script>alert('$msg');</script>";
}



if (isset($_POST['deletebtn'])){
    $task_id = $_POST['task_id'];
    $sql= "DELETE FROM tasks WHERE id = $task_id and email = '$email'";
    mysqli_query($conn,$sql);
    header("Location: todo.php");
    exit();
    
}


if (isset($_POST['editbtn'])){
    $task_id = $_POST['task_id'];
    $task = $_POST['task'];
    $date = $_POST['due_date'];
    $sql = "UPDATE tasks SET task = '$task', date = '$date' WHERE id = $task_id and email = '$email'";
    mysqli_query($conn,$sql);
    header("Location: todo.php");
    exit();
}

if(isset($_POST['logoutbtn'])){
    session_destroy();
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="refresh" content="1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="todo.css">

    <title>Document</title>
</head>

<body>

    <div class="main_div">
        <div class="header">
            <h1>Welcome to the Todo List Application <br>
                <p>Manage your tasks efficiently and stay organized.</p>
            </h1>

        </div>

        <div class="aside">
            <div class="side">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" width="150" height="200"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 64" enable-background="new 0 0 64 64"
                    xml:space="preserve" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <line fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="16" y1="24"
                            x2="38" y2="24"></line>
                        <line fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="16" y1="34"
                            x2="38" y2="34"></line>
                        <line fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="16" y1="44"
                            x2="38" y2="44"></line>
                        <line fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="16" y1="54"
                            x2="38" y2="54"></line>
                        <line fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="12" y1="24"
                            x2="8" y2="24"></line>
                        <line fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="12" y1="34"
                            x2="8" y2="34"></line>
                        <line fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="12" y1="44"
                            x2="8" y2="44"></line>
                        <line fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="12" y1="54"
                            x2="8" y2="54"></line>
                        <polyline fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10"
                            points="14,8 1,8 1,63 45,63 45,8 32,8 "></polyline>
                        <polygon fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10"
                            points="27,5 27,1 19,1 19,5 15,5 13,13 33,13 31,5 ">
                        </polygon>
                        <polygon fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10"
                            points="63,3 63,53 59,61 55,53 55,3 "></polygon>
                        <polyline fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10"
                            points="55,7 51,7 51,17 "></polyline>
                    </g>
                </svg>
            </div>
            <div class="side" style="    margin-left: 60px; font-size: -webkit-xxx-large;" >Todo</div>
            <div class="side">
                <form action="todo.php" method="post">
                    <button style="    margin: 0;  width: 153px;  height: 61px;  font-size: xx-large; background-color: transparent;" type="submit" name="logoutbtn">Logout</button>
                </form>
            </div>
        </div>

        <div class="content">
            <form action="todo.php" method="post">
                <input type="text" placeholder="Enter task" name="task" class="task-input">
                <button type="submit" name='addbtn'>Add Task</button>
            </form>
            <div style="padding: 10px;">
                <table class="todo-table">
                    <tr>
                        <th>Done</th>
                        <th>Task</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php
                while($row = mysqli_fetch_array($result)){
                echo '
                    
                    <tr>
                        <td><input onclick = "checkBox('.$row[0].')" style="width:30px; height:30px;" type="checkbox" ' . ($row[1] == "Complete" ? "checked" : "").' ></td>
                        

                        <td>'.$row[3].'</td>
                        <td>'.$row[2].'</td>
                        <td>'.$row[1].'</td>
                        <td>  <div onclick = "handelUpdatemodal('.$row[0].')">

                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40" viewBox="0 0 100 100">
                            <path fill="#78a0cf" d="M13 27A2 2 0 1 0 13 31A2 2 0 1 0 13 27Z"></path><path fill="#f1bc19" d="M77 12A1 1 0 1 0 77 14A1 1 0 1 0 77 12Z"></path><path fill="#cee1f4" d="M50 13A37 37 0 1 0 50 87A37 37 0 1 0 50 13Z"></path><path fill="#f1bc19" d="M83 11A4 4 0 1 0 83 19A4 4 0 1 0 83 11Z"></path><path fill="#78a0cf" d="M87 22A2 2 0 1 0 87 26A2 2 0 1 0 87 22Z"></path><path fill="#fbcd59" d="M81 74A2 2 0 1 0 81 78 2 2 0 1 0 81 74zM15 59A4 4 0 1 0 15 67 4 4 0 1 0 15 59z"></path><path fill="#78a0cf" d="M25 85A2 2 0 1 0 25 89A2 2 0 1 0 25 85Z"></path><path fill="#fff" d="M18.5 51A2.5 2.5 0 1 0 18.5 56A2.5 2.5 0 1 0 18.5 51Z"></path><path fill="#f1bc19" d="M21 66A1 1 0 1 0 21 68A1 1 0 1 0 21 66Z"></path><path fill="#fff" d="M80 33A1 1 0 1 0 80 35A1 1 0 1 0 80 33Z"></path><g><path fill="#f1bc19" d="M65,28c3.86,0,7,3.14,7,7v30c0,3.86-3.14,7-7,7H35c-3.86,0-7-3.14-7-7V35c0-3.86,3.14-7,7-7H65"></path><path fill="#472b29" d="M65,28.4c3.639,0,6.6,2.961,6.6,6.6v30c0,3.639-2.961,6.6-6.6,6.6H35c-3.639,0-6.6-2.961-6.6-6.6V35 c0-3.639,2.961-6.6,6.6-6.6H65 M65,27H35c-4.418,0-8,3.582-8,8v30c0,4.418,3.582,8,8,8h30c4.418,0,8-3.582,8-8V35 C73,30.582,69.418,27,65,27L65,27z"></path><path fill="#fdfcee" d="M63,69H37c-3.309,0-6-2.691-6-6V37c0-3.309,2.691-6,6-6h26c3.309,0,6,2.691,6,6v26 C69,66.309,66.309,69,63,69z"></path><path fill="#472b29" d="M63 69H37c-3.309 0-6-2.691-6-6V37c0-3.309 2.691-6 6-6h24.625C61.832 31 62 31.168 62 31.375s-.168.375-.375.375H37c-2.895 0-5.25 2.355-5.25 5.25v26c0 2.895 2.355 5.25 5.25 5.25h26c2.895 0 5.25-2.355 5.25-5.25V48.375c0-.207.168-.375.375-.375S69 48.168 69 48.375V63C69 66.309 66.309 69 63 69zM68.625 42c-.207 0-.375-.168-.375-.375v-1.278c0-.207.168-.375.375-.375S69 40.14 69 40.347v1.278C69 41.832 68.832 42 68.625 42z"></path><path fill="#472b29" d="M68.625,47c-0.207,0-0.375-0.168-0.375-0.375v-3.25c0-0.207,0.168-0.375,0.375-0.375 S69,43.168,69,43.375v3.25C69,46.832,68.832,47,68.625,47z"></path></g><g><path fill="#f1bc19" d="M57.687,39.376c-0.401,0-0.75,0.119-1,0.368L42.311,54.132c-0.463,0.465-1.438,3.042-2.149,4.922 c-0.322,0.851-0.597,1.574-0.757,1.933c-0.056,0.125-0.03,0.261,0.066,0.358l0.155,0.155c0.122,0.123,0.305,0.159,0.468,0.086 c0.417-0.188,1.188-0.481,2.083-0.82c1.907-0.724,4.256-1.615,4.702-2.061l14.377-14.39c0.743-0.744,0.323-2.376-0.936-3.637 C59.483,39.842,58.482,39.376,57.687,39.376z"></path><path fill="#fdfcee" d="M42.311,54.132c-0.463,0.465-1.438,3.042-2.149,4.922c-0.322,0.851-0.597,1.574-0.757,1.933 c-0.056,0.125-0.03,0.261,0.066,0.358l0.155,0.155c0.122,0.123,0.305,0.159,0.468,0.086c0.417-0.188,1.188-0.481,2.083-0.82 c1.907-0.724,4.256-1.615,4.702-2.061l0.003-0.003L42.311,54.132z"></path><path fill="#4a5397" d="M40.181,59.003c-0.006,0.017-0.013,0.035-0.02,0.052c-0.322,0.851-0.597,1.574-0.757,1.933 c-0.056,0.125-0.03,0.261,0.066,0.358l0.155,0.155c0.122,0.123,0.305,0.159,0.468,0.086c0.39-0.176,1.095-0.445,1.916-0.756 L40.181,59.003z"></path><path fill="#7782ac" d="M55.385 41.048H58.193V47.5H55.385z" transform="rotate(-45.001 56.788 44.275)"></path><path fill="#fcb9b9" d="M60.036,45.536l1.219-1.22c0.743-0.744,0.323-2.376-0.936-3.637 c-0.836-0.837-1.837-1.303-2.632-1.303c-0.401,0-0.75,0.119-1,0.368l-1.221,1.222L60.036,45.536z"></path></g><g><path fill="#472b29" d="M57.69,39.75L57.69,39.75c0.722,0,1.628,0.458,2.364,1.194c1.208,1.21,1.459,2.583,0.936,3.107 L46.612,58.441c-0.389,0.389-2.893,1.339-4.55,1.968l-0.075,0.028c-0.875,0.332-1.63,0.619-2.097,0.798l-0.129-0.129 c0.173-0.394,0.454-1.136,0.751-1.92c0.62-1.639,1.658-4.382,2.064-4.789L56.952,40.01C57.125,39.837,57.373,39.75,57.69,39.75 M57.69,39c-0.501,0-0.944,0.155-1.268,0.479L42.046,53.867c-0.481,0.482-1.264,2.486-2.235,5.054 c-0.319,0.842-0.59,1.558-0.749,1.913c-0.119,0.265-0.063,0.569,0.142,0.775l0.156,0.156C39.513,61.919,39.715,62,39.921,62 c0.11,0,0.222-0.024,0.327-0.071c0.408-0.185,1.183-0.478,2.08-0.819c2.525-0.958,4.35-1.673,4.815-2.139l14.378-14.389 c0.905-0.906,0.494-2.736-0.936-4.167C59.668,39.497,58.586,39,57.69,39L57.69,39z"></path><path fill="#472b29" d="M44.346 53.186H44.846V59.65H44.346z" transform="rotate(-45.001 44.59 56.416)"></path><path fill="#472b29" d="M40.839 58.497H41.339V61.325H40.839z" transform="rotate(-45.001 41.088 59.912)"></path><path fill="#472b29" d="M55.546 42.04H56.046V48.492H55.546z" transform="rotate(-45.001 55.796 45.267)"></path><path fill="#472b29" d="M57.531 40.055H58.031V46.507H57.531z" transform="rotate(-45.001 57.781 43.282)"></path><path fill="#472b29" d="M54.615 44.049L54.385 43.951 55.51 41.326 55.74 41.424zM55.49 44.799L55.26 44.701 56.385 42.076 56.615 42.174zM56.365 45.549L56.135 45.451 57.26 42.826 57.49 42.924zM57.144 46.522L56.915 46.424 58.135 43.576 58.365 43.674zM57.981 47.361L57.751 47.263 59.01 44.326 59.24 44.424z"></path></g>
                            </svg>
                        </div></td>
                    <td>
                    <div onclick = "handelDeletemodal('.$row[0].')">

                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40" viewBox="0 0 100 100">
                        <path fill="#f37e98" d="M25,30l3.645,47.383C28.845,79.988,31.017,82,33.63,82h32.74c2.613,0,4.785-2.012,4.985-4.617L75,30"></path><path fill="#f15b6c" d="M65 38v35c0 1.65-1.35 3-3 3s-3-1.35-3-3V38c0-1.65 1.35-3 3-3S65 36.35 65 38zM53 38v35c0 1.65-1.35 3-3 3s-3-1.35-3-3V38c0-1.65 1.35-3 3-3S53 36.35 53 38zM41 38v35c0 1.65-1.35 3-3 3s-3-1.35-3-3V38c0-1.65 1.35-3 3-3S41 36.35 41 38zM77 24h-4l-1.835-3.058C70.442 19.737 69.14 19 67.735 19h-35.47c-1.405 0-2.707.737-3.43 1.942L27 24h-4c-1.657 0-3 1.343-3 3s1.343 3 3 3h54c1.657 0 3-1.343 3-3S78.657 24 77 24z"></path><path fill="#1f212b" d="M66.37 83H33.63c-3.116 0-5.744-2.434-5.982-5.54l-3.645-47.383 1.994-.154 3.645 47.384C29.801 79.378 31.553 81 33.63 81H66.37c2.077 0 3.829-1.622 3.988-3.692l3.645-47.385 1.994.154-3.645 47.384C72.113 80.566 69.485 83 66.37 83zM56 20c-.552 0-1-.447-1-1v-3c0-.552-.449-1-1-1h-8c-.551 0-1 .448-1 1v3c0 .553-.448 1-1 1s-1-.447-1-1v-3c0-1.654 1.346-3 3-3h8c1.654 0 3 1.346 3 3v3C57 19.553 56.552 20 56 20z"></path><path fill="#1f212b" d="M77,31H23c-2.206,0-4-1.794-4-4s1.794-4,4-4h3.434l1.543-2.572C28.875,18.931,30.518,18,32.265,18h35.471c1.747,0,3.389,0.931,4.287,2.428L73.566,23H77c2.206,0,4,1.794,4,4S79.206,31,77,31z M23,25c-1.103,0-2,0.897-2,2s0.897,2,2,2h54c1.103,0,2-0.897,2-2s-0.897-2-2-2h-4c-0.351,0-0.677-0.185-0.857-0.485l-1.835-3.058C69.769,20.559,68.783,20,67.735,20H32.265c-1.048,0-2.033,0.559-2.572,1.457l-1.835,3.058C27.677,24.815,27.351,25,27,25H23z"></path><path fill="#1f212b" d="M61.5 25h-36c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h36c.276 0 .5.224.5.5S61.776 25 61.5 25zM73.5 25h-5c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h5c.276 0 .5.224.5.5S73.776 25 73.5 25zM66.5 25h-2c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h2c.276 0 .5.224.5.5S66.776 25 66.5 25zM50 76c-1.654 0-3-1.346-3-3V38c0-1.654 1.346-3 3-3s3 1.346 3 3v25.5c0 .276-.224.5-.5.5S52 63.776 52 63.5V38c0-1.103-.897-2-2-2s-2 .897-2 2v35c0 1.103.897 2 2 2s2-.897 2-2v-3.5c0-.276.224-.5.5-.5s.5.224.5.5V73C53 74.654 51.654 76 50 76zM62 76c-1.654 0-3-1.346-3-3V47.5c0-.276.224-.5.5-.5s.5.224.5.5V73c0 1.103.897 2 2 2s2-.897 2-2V38c0-1.103-.897-2-2-2s-2 .897-2 2v1.5c0 .276-.224.5-.5.5S59 39.776 59 39.5V38c0-1.654 1.346-3 3-3s3 1.346 3 3v35C65 74.654 63.654 76 62 76z"></path><path fill="#1f212b" d="M59.5 45c-.276 0-.5-.224-.5-.5v-2c0-.276.224-.5.5-.5s.5.224.5.5v2C60 44.776 59.776 45 59.5 45zM38 76c-1.654 0-3-1.346-3-3V38c0-1.654 1.346-3 3-3s3 1.346 3 3v35C41 74.654 39.654 76 38 76zM38 36c-1.103 0-2 .897-2 2v35c0 1.103.897 2 2 2s2-.897 2-2V38C40 36.897 39.103 36 38 36z"></path>
                        </svg>
                    </div>
                    </td>
                    </tr>
                ';}

                ?>
                </table>
            </div>


            <div>

                <div class="Modal" id="Modal">
                    <div>
                        <h1>Press Confirm to delete</h1>
                    </div>
                    <div style="display: flex; ">
                        <form action="todo.php" method="post">
                            <input type="hidden" name="task_id" id="task_id" value="<?php  ?>">
                            <button style="margin-top: 30px; margin-right : 50px; width:100px" type="submit"
                                name="deletebtn">Confirm</button>
                        </form>

                        <button
                            style="margin-top: 30px;  background-color:red; margin-right : px; width:100px ;height:40px;"
                            onclick="closeDeletemodale()">cancel</button>
                    </div>
                </div>

                <div>
                    <div style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);"
                        id="editModal">
                        <h1>Edit Task</h1>
                        <form action="todo.php" method="post">
                            <input type="hidden" name="task_id" id="edit_task_id">
                            <input type="text" name="task" id="edit_task" placeholder="Enter task" class="task-input">
                            <input type="datetime-local" name="due_date" id="edit_due_date"
                                value="<?php echo date('Y-m-d\TH:i'); ?>">
                            <button type="submit" name="editbtn">Save Changes</button>
                        </form>
                        <button onclick="closeEditModal()">Cancel</button>
                    </div>
                </div>


            </div>

        </div>

        <div class="footer">
            footer

        </div>
    </div>




    <script>
    const modal = document.getElementById('Modal')
    const modal2 = document.getElementById('editModal')


    const currentDateTime = new Date().toISOString();
    console.log(currentDateTime);
    document.getElementById('edit_due_date').value = currentDateTime;

    function closeDeletemodale() {
        modal.style.display = 'none';
        document.body.style.backgroundColor = '#ffffff9e';

    }

    function handelDeletemodal(id) {

        modal.style.display = 'flex';
        console.log(id);
        document.getElementById('task_id').value = id;


    }


    function handelUpdatemodal(id) {
        modal2.style.display = 'flex';
        console.log(id);
        document.getElementById('edit_task_id').value = id;
    }


    function closeEditModal() {
        modal2.style.display = 'none';
    }


    async function checkBox(id) {
        const response = await fetch('check.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                todoID: id,
                done: true
            })
        });

        const data = await response.json();
        console.log(data);
        // This will print the response from the server
    }
    </script>
</body>

</html>