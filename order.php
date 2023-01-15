<?php

include('settings.php');
include('bot_lib.php');

if (!isset($_SESSION['usersname'])) {
  header("location: index.php");
}



$query = "SELECT * FROM main_ord_tbl WHERE order_status='0' ORDER by id DESC";  
$rs_result = mysqli_query ($connect, $query);   


?>


<!DOCTYPE html>
<html lang="en">
<head>
  
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>ortosavdo</title>
    
</head>
<body>  

<?php include 'partSite/nav.php'; ?>

<div class="page_name">
    <div class="container-fluid">
        <i class="fa fa-clone" aria-hidden="true"></i>
        <i class="fa fa-angle-double-right right_cus"></i>
        <span class="right_cus">Заказы</span>
    </div>    
</div>

<div class="toolbar">
        <div class="container-fluid">
           <a href="add_order.php"> <button type="button" class="btn btn-success">Добавить</button> </a>
        </div>
</div>



<div class="all_table">
    <div class="container-fluid">
        <table class="table table-hover table-bordered">
        <thead>
            <tr>
            <th scope="col">Н/З</th>
            <th scope="col">Контрагент</th>
            <th scope="col">Торговый представитель</th>
            <th scope="col">Дата заказа</th>
            <th scope="col">Тип оплаты</th>
            <th scope="col">Сумма сделки</th>
            <th scope="col">Дополнительное</th>
          
            </tr>
        </thead>
        <tbody>
            
<?php     
    $i = 0;
    while ($row = mysqli_fetch_array($rs_result)) {
    $i++;

?> 
        <tr data-toggle="collapse" data-target="#hidden_<?php echo $i;?>" aria-expanded="true" class="accordion-toggle">
            <td><?php echo $row["id"]; ?></td>
            <td><?php $user = get_contractor($connect, $row["contractor"]);?>&nbsp;<?php echo $user["surname"]; ?>&nbsp;<?php echo $user["name"]; ?>&nbsp;<?php echo $user["fathername"]; ?></td>
            <td><?php $user = get_user($connect, $row["sale_agent"]);?>&nbsp;<?php echo $user["surname"]; ?>&nbsp;<?php echo $user["name"]; ?>&nbsp;<?php echo $user["fathername"]; ?></td>
            <td><?php echo $date = date("d.m.Y", strtotime($row["ord_date"])); ?></td>
            <td><?php echo $row["payment_type"]; ?></td>
            <td><?php echo number_format($row['transaction_amount'], 0, '.', ' '); ?></td>
            <td>

            <select class="form-control" onchange="location = this.value;">
                <option value="" >выберите</option>
                <option value="view_inside_order.php?id=<?php echo $row["id"]; ?>&&payment_type=<?php echo $row["payment_type"]; ?>&&sale_agent=<?php echo $row["sale_agent"]; ?>&&contractor=<?php echo $row["contractor"]; ?>&&date=<?php echo $row["ord_date"]; ?>">Просмотр</option>
                <option value="edit_inside_order.php?id=<?php echo $row["id"]; ?>&&payment_type=<?php echo $row["payment_type"]; ?>&&sale_agent=<?php echo $row["sale_agent"]; ?>&&contractor=<?php echo $row["contractor"]; ?>&&date=<?php echo $row["ord_date"]; ?>">Редактировать</option>
                <option value="action.php?archive_id=<?=$row['id']?>&&contractor_id=<?=$row['contractor']?>&&debt=<?=$row['transaction_amount']?>&&ord_date=<?=$row['ord_date']?>&&payment_type=<?=$row['payment_type']?> " onclick="return confirm('Архивировать?')" role="button">Архивировать</option>
                <option value="action.php?delete_id=<?=$row['id']?>" onclick="return confirm('Отменить?')" role="button">Отменить</option>
                <option value="">Счет-фактура</option>
            </select>
        
<?php       
    };    
?>

        </tbody>
        </table>
    </div>
</div>




<div class="container-fluid">
    <?php include 'partSite/modal.php'; ?>
</div>


</body>
</html>