<?php function showForm ($name='', $phone='', $address='', $pickedDay='', $pickedTime='', $errors = []) {
    $date = getdate();
    $dayInMonth = cal_days_in_month(CAL_GREGORIAN, $date['mon'], $date['year']);
    $arDates = range(1, $dayInMonth);
    $arDates = array_filter($arDates, function ($day) {return $day >= getdate()['mday'];});
    $arTimes = ['08:00', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00'];    
    $phoneClass = isset($errors['phone']) ? 'error-input' : '';
    $nameClass = isset($errors['name']) ? 'error-input' : '';
    $addressClass = isset($errors['address']) ? 'error-input' : '';
    $timeClass = isset($errors['time']) ? 'error-input' : '';
    ?>

<form action="/" method="POST">
        <label for="name">Имя</label>
        <input type="text" name="name" id="name" value='<?= $name ?>' placeholder="Имя" class="<?= $nameClass; ?>">
        <p class="error-description"><?= $errors['name'] ?? ''; ?></p>
        <label for="phone">Телефон</label>
        <input type="tel" name="phone" id="phone" placeholder='+375291234567'value="<?= $phone ?>" class="<?= $phoneClass; ?>">
        <p class="error-description"><?= $errors['phone'] ?? ''; ?></p>
        <label for="city">Город</label>
        <select name="city" id="city">
            <option value="Минск" selected>Минск</option>
            <option value="Брест">Брест</option>
            <option value="Гродно">Гродно</option>
            <option value="Витебск">Витебск</option>
            <option value="Могилёв">Могилёв</option>
            <option value="Гомель">Гомель</option>
        </select>
        <label for="address">Адрес</label>
        <input type="text" name="address" id="address" value='<?= $address ?>' placeholder="Адрес" class="<?= $addressClass; ?>">
        <p class="error-description"><?= $errors['address'] ?? ''; ?></p>
        <fieldset>
        <legend>Дата доставки</legend>
        <?php foreach($arDates as $day) : ?>
            <input type="radio" name="date" id='day<?= $day ?>' value="<?= $day ?>" required <?= ($day == $pickedDay) ? 'checked' : '';?>>
            <label for="day<?= $day ?>"><?= "{$day}.{$date['mon']}" ?></label>
        <?php endforeach; ?>
        </fieldset>
        <fieldset class="<?= $timeClass; ?>">
        <legend>Время доставки</legend>
        <?php foreach($arTimes as $time) : ?>
            <input type="radio" name="time" id="<?= $time?>" value="<?= $time ?>" required <?= ($time == $pickedTime) ? 'checked' : '';?>>
            <label for="<?= $time?>"><?= $time?></label>
        <?php endforeach; ?>
        </fieldset>
        <p class="error-description"><?= $errors['time'] ?? ''; ?></p>
        <button>Заказать</button>
    </form>
<?php } 


function validateForm ($name, $phone, $pickedDay, $pickedTime, $address) {
    $nameRegExp = '/^[а-яА-ЯёЁ]+$/ui';
    $phoneRegExp = '/^(?:\+375)(?:33|44|29|25)\d{7}$/';
    $addressRegExp = '/^[-., а-яА-ЯёЁ0-9]+$/ui';
    $errors = [];
    $date = getdate();
    if (!preg_match($nameRegExp, $name)) {
        $errors['name'] = 'Имя должно содежать только русские буквы';
    }
    if (!preg_match($phoneRegExp, $phone)) {
        $errors['phone'] = 'Должен быть мобильный телефон белорусского оператора';
    }
    if ($pickedDay == $date['mday']) {
        $hours = (int) substr($pickedTime,0,2);
        $minutes = (int) substr($pickedTime,-2);
        if (($date['hours'] > $hours) || ($date['hours'] == $hours && $date['minutes'] > $minutes)) {
            $errors['time'] = 'Для сегодняшней даты такое время уже недоступно';
        }
    }
    if (!preg_match($addressRegExp, $address)) {
        $errors['address'] = 'Адрес может содержать только русские буквы, цифры, пробелы и дефисы';
    }
    return $errors;
}

?>