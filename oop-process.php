<?php 
include('oop-function.php');
$dbcon = new DBcon();

if(isset($_POST['search'])){
    $dbcon->search = $_POST['search_key'];
    $sql = $dbcon->search();
    if($sql->num_rows > 0){
        while($rows = $sql->fetch_array()){
            echo '<tr>';
            echo '<td>'.$rows['fname'].'</td>';
            echo '<td>'.$rows['lname'].'</td>';
            echo '<td>'.$rows['tel'].'</td>';
            echo '<td>'.$rows['date'].'</td>';
            echo '<td><button class="btn btn-warning edit">Edit</button></td>';
            echo '<td><button class="btn btn-danger edit">Delete</button></td>';
            echo '</tr>';
        }
    }else{
        echo '<td colspan="6" align="center">ไม่มีข้อมูลที่ท่านค้นหา</td>';
    }
}

if(isset($_POST['insert'])){
    for($i=0; $i<count($_POST['fname']); $i++){
        $dbcon->fname = $_POST['fname'][$i];
        $dbcon->lname = $_POST['lname'][$i];
        $dbcon->tel = $_POST['tel'][$i];
        $dbcon->date = $_POST['date'][$i];
        $dbcon->insert();
    }
}

if(isset($_POST['edit'])){
    $dbcon->id = $_POST['id'];
    $dbcon->fname = $_POST['fname'];
    $dbcon->lname = $_POST['lname'];
    $dbcon->tel = $_POST['tel'];
    $dbcon->date = $_POST['date'];
    $dbcon->edit();
}

if(isset($_POST['delete'])){
    $dbcon->id = $_POST['id'];
    $dbcon->delete();
}
?>