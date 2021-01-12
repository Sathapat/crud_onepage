<?php include('oop-function.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
</head>
<body>
<?php 
    $dbcon = new DBcon();
?>
<div class="container">
    <div class="row p-3">
        <div class="col-9">
            <button class="btn btn-primary" id="insert-add">ADD</button>
            <button class="btn btn-danger" id="clear">CLEAR</button>
        </div>
        <div class="col-3">
            <input class="form-control w-100" id="search-txt" type="text" placeholder="search">
        </div>
    </div>
    <div class="row">
        <table id="crud_table" class="table table-bordered text-center">
            <thead>
                <th>FIRST NAME</th>
                <th>LAST NAME</th>
                <th>TEL</th>
                <th>DATE</th>
                <th>EDIT</th>
                <th>DELETE</th>
            </thead>
            <?php 
                $sql = $dbcon->show();
                while($rows = $sql->fetch_array()){?>
            <tbody class="show">
                <tr>
                    <td><?php echo $rows['fname']; ?></td>
                    <td><?php echo $rows['lname']; ?></td>
                    <td><?php echo $rows['tel']; ?></td>
                    <td><?php echo $rows['date']; ?></td>
                    <td><button class="btn btn-warning edit_btn" data-id="<?php echo $rows['id'] ?>" data-fname="<?php echo $rows['fname'] ?>" data-lname="<?php echo $rows['fname'] ?>" data-tel="<?php echo $rows['tel'] ?>" data-date="<?php echo $rows['date'] ?>">Edit</button></td>
                    <td><button class="btn btn-danger delete_btn" data-id="<?php echo $rows['id']; ?>">Delete</button></td>
                </tr>
            </tbody>
            <tbody id="result">

            </tbody>
            <?php } ?>
            <tbody id="insert_add">
            
            </tbody>
            <tr>
                <td colspan="6"><button class="btn btn-success" id="insert_btn" style="display:">INSERT</button></td>
            </tr>
            <tr>
                <td class="test">
                
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
<script>
    $(document).ready(function(){
        $('#search-txt').keyup(function(e){
            e.preventDefault();
            let search_key = $('#search-txt').val();
            if(search_key != ''){
                $.ajax({
                    url: 'oop-process.php',
                    method: 'post',
                    data:{
                        'search': 1,
                        'search_key': search_key
                    },
                    success:function(response){
                        $('.show').hide();
                        $('#result').empty().html(response);
                    }
                });
            }else{
                $('.show').show();
                $('#result').empty();
            }
        });

        $('#insert-add').click(function(e){
            e.preventDefault();
            let textbox_add = '<tr>';
            textbox_add += '<td><input class="form-control add" type="text" name="fname"></td>'; 
            textbox_add += '<td><input class="form-control add" type="text" name="lname"></td>'; 
            textbox_add += '<td><input class="form-control add" type="text" name="tel"></td>'; 
            textbox_add += '<td><input class="form-control add" type="date" name="date"></td>'; 
            textbox_add += '<td></td>'; 
            textbox_add += '<td></td>'; 
            textbox_add += '</tr>';
            $('#insert_add').append(textbox_add);

            $('#insert_btn').click(function(){
                let fname = $('input[name="fname"]').map(function(){
                    return $(this).val();
                }).get();
                let lname = $('input[name="lname"]').map(function(){
                    return $(this).val();
                }).get();
                let tel = $('input[name="tel"]').map(function(){
                    return $(this).val();
                }).get();
                let date = $('input[name="date"]').map(function(){
                    return $(this).val();
                }).get();

                $.ajax({
                    url: 'oop-process.php',
                    method: 'post',
                    data: {
                        'insert': 1,
                        'fname': fname,
                        'lname': lname,
                        'tel': tel,
                        'date': date
                    },
                    success:function(response){
                        window.location.href='oop-index.php';
                    }
                });
            });
        });

        $('#clear').click(function(e){
            e.preventDefault();
            $('#insert_add').empty();
        });

        let i = 0;
        $('.edit_btn').click(function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let fname = $(this).data('fname');
            let lname = $(this).data('lname');
            let tel = $(this).data('tel');
            let date = $(this).data('date');
            let textbox_add = '<tr>';
            textbox_add += '<td><input class="form-control fname" type="text" name="fname" value="'+fname+'"></td>'; 
            textbox_add += '<td><input class="form-control lname" type="text" name="lname" value="'+lname+'"></td>'; 
            textbox_add += '<td><input class="form-control tel" type="text" name="tel" value="'+tel+'"></td>'; 
            textbox_add += '<td><input class="form-control date" type="date" name="date" value="'+date+'"></td>'; ; 
            textbox_add += '<td><button class="btn btn-warning edit_btn">Edit</button></td>'; 
            textbox_add += '<td><button class="btn btn-success edit_confirm" data-id="'+id+'">Confirm</button></td>'; 
            textbox_add += '</tr>';
            let this_row = $(this).parent().parent();
            if(i == 0){
                this_row.replaceWith(textbox_add);
                i++;
            }else{
                i--;
                window.location.href='oop-index.php';
            }

            $('.edit_confirm').click(function(e){
                e.preventDefault();
                let id = $(this).data('id');
                let fname = $('.fname').val();
                let lname = $('.lname').val();
                let tel = $('.tel').val();
                let date = $('.date').val();
                $.ajax({
                    url: 'oop-process.php',
                    method: 'post',
                    data: {
                        'edit': 1,
                        'id': id,
                        'fname': fname,
                        'lname': lname,
                        'tel': tel,
                        'date': date
                    },
                    success:function(response){
                        window.location.href='oop-index.php';
                    }
                });
            });
        });

        $('.delete_btn').click(function(e){
            e.preventDefault();
            let id = $(this).data('id');
            if(confirm('Confirm') == true){
                $.ajax({
                    url: 'oop-process.php',
                    method: 'post',
                    data: {
                        'delete': 1,
                        'id': id
                    },
                    success:function(response){
                        window.location.href='oop-index.php';
                    }
                });
            }
        });
    });
</script>