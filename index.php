<?php
$date = getdate();
require './php/functions.php';
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$pickedTime = $_POST['time'] ?? '';
$pickedDay = $_POST['date'] ?? '';
$address = trim($_POST['address'] ?? '');
$city = $_POST['city'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<div class="element">
    <h2 class="title">Оформление заявки</h2>
    <div class="field">
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                showForm();
            } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $errors = validateForm ($name, $phone, $pickedDay, $pickedTime, $address);
                if (empty($errors)) :
                    $pickedDay = str_pad($pickedDay,2,'0',STR_PAD_LEFT);
                    $pickedMonth = str_pad($date['mon'], 2, '0', STR_PAD_LEFT);?> 

                    <div class="thanks">
                        <h3>Спасибо за заявку!</h3>
                        <p>
                            Оформлен заказ на имя <?= $name; ?>, по адресу: г.<?= "$city, $address"; ?>. <br />Время и дата доставки: <?= "{$pickedDay}.{$pickedMonth} в $pickedTime"; ?>. <br />Контактный телефон: <?= $phone; ?>.
                        </p>
                        <a class="like_a_button" href="./index.php">Вернуться на страницу заявки</a>
                    </div> 

                <?php else :
                $name = isset($errors['name']) ? '' : $name;
                $phone = isset($errors['phone']) ? '' : $phone;
                $address = isset($errors['address']) ? '' : $address;
                $pickedTime = isset($errors['time']) ? '' : $pickedTime;
                showForm ($name, $phone, $address, $pickedDay, $pickedTime, $errors);
                endif;
            }
        ?>
    </div>
</div>
<script src="js/script.js"></script>
</body>
</html>