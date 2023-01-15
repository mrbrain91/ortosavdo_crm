<?php
include('settings.php');
include('bot_lib.php');

if (!isset($_SESSION['usersname'])) {
  header("location: index.php");
}



$query = "SELECT * FROM debts WHERE main_prepayment!='0' ORDER BY id DESC";
$rs_result = mysqli_query ($connect, $query);   




?>


<!DOCTYPE html>
<html lang="ru">
<head>
  
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
        <span class="right_cus">Оплаты от контрагентов</span>
    </div>    
</div>

<div class="toolbar">
        <div class="container-fluid">
           <a href="prepayment_add.php"> <button type="button" class="btn btn-success">Добавить</button> </a>
        </div>
</div>

<div class="all_table">
    <div class="container-fluid">
        <table class="table table-striped table-bordered">
        <thead>
            <tr>
            <th scope="col">Контрагент</th>
            <!-- <th scope="col">Торговый представитель</th> -->
            <th scope="col">Дата оплата</th>
            <th scope="col">Тип оплаты</th>
            <th scope="col">Сумма оплата</th>
            <th scope="col">Просмотр</th>
            <th scope="col">Редактировать</th>
            

            </tr>
        </thead>
        <tbody>

        <?php     
            $i = 0;
            while ($row = mysqli_fetch_array($rs_result)) {
            $i++;
        ?> 
            <tr>
            <td><?php $user = get_contractor($connect, $row["id_counterpartie"]); echo $user["name"];?></td>
            <td><?php echo $date = date("d.m.Y", strtotime($row["order_date"])); ?></td>

            <td><?php echo $row['payment_type']; ?></td>
            <td><?php echo number_format($row['main_prepayment'], 0, ',', ' '); ?></td>
            <td><a href="#">Просмотр</a></td>
            <td><a href="#">Редактировать</a></td>

            </tr>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>