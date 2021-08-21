
# Робокасса

Пакет позволяет производить оплату через сервис [Робокасса](https://docs.robokassa.ru/) в фреймворке Laravel.


## Установка

````
$ composer require unetway/laravel-robokassa
````


## Конфигурация

Установите параметры для подключения к Робокасса в файле ```config/robokassa.php```

**Параметры:**
- login - логин
- password1 - пароль 1
- password1 - пароль 2
- test_password1 - тествый пароль 1
- test_password2 - тествый пароль 2
- is_test - true|false
- hashType - md5|ripemd160|sha1|sha256|sha384|sha512


## Использование


````
<?php

use Unetway\LaravelRobokassa\Robokassa;

$robokassa = new Robokassa();

````



### Генерация ссылки на оплату

````

$link = $robokassa->generateLink([
'OutSum' => 123.45,
'Description' => 'Описание',
'InvId' => 7,
]);

echo $link;
````

````

$link = $robokassa->generateLink([
'OutSum' => 123.45,
'Description' => 'Описание',
'IncCurrLabel' => '',
'InvId' => 7,
'Culture' => 'ru',
'Encoding' => 'UTF-8',
'Email' => '',
'ExpirationDate' => 'YYYY-MM-DDThh:mm:ss.fffffffZZZZZ',
'OutSumCurrency' => 'USD',
'UserIp' => '',
]);

echo $link;
````
В пакете возможно использовать [обязательные](https://docs.robokassa.ru/#1186) и [необязательные](https://docs.robokassa.ru/#1192) параметры.

Параметры MerchantLogin и SignatureValue указывать не нужно.

### Отправка SMS

````
$phone = 'номер телефона';
$message = 'Сообщение не больше 128 символов';

return $robokassa->sendSms($phone, $message);

````

### Периодические платежи (рекуррентные)

Список используемых параметров представлен в официальной документации [переодических платежей](https://docs.robokassa.ru/#1216).

````
$outSum = 7.5;
$invoiceID = 8; 
$previousInvoiceID = 5;
$paramsOther = []; //другие дополнительные параметры

return $robokassa->recurrent($outSum, $invoiceID, $previousInvoiceID, $paramsOther);

````


### Список валют

Используется для указания значений параметра IncCurrLabel также используется для отображения доступных вариантов оплаты непосредственно на Вашем сайте если Вы желаете дать больше информации своим клиентам.

````
$lang = 'ru';
return $robokassa->getCurrencies($lang);
````

### Список способов оплаты

Возвращает список способов оплаты, доступных для оплаты заказов указанного магазина/сайта.

````
$lang = 'ru';
return $robokassa->getPaymentMethods($lang);
````


### Расчёта суммы к оплате с учётом комиссии сервиса

Позволяет рассчитать сумму, которую должен будет заплатить покупатель, с учётом комиссий ROBOKASSA (согласно тарифам) и тех систем, через которые покупатель решил совершать оплату заказа.

````
$outSum = 7.5;
$lang = 'ru';
$incCurrLabel = null;
return $robokassa->getRates($outSum, $language, $incCurrLabel);
````


### Расчёт суммы к получению магазином

Интерфейс расчёта суммы к получению магазином
Позволяет рассчитать сумму к получению, исходя из текущих курсов ROBOKASSA, по сумме, которую заплатит пользователь.
Только для физических лиц.

````
return $robokassa->calcOutSumm($incSum, $incCurrLabel);
````

### Статус оплаты

Получение состояния оплаты счета
Возвращает детальную информацию о текущем состоянии и реквизитах оплаты.
Необходимо помнить, что операция инициируется не в момент ухода пользователя на оплату, а позже – после подтверждения его платежных реквизитов, т.е. Вы вполне можете не находить операцию, которая по Вашему мнению уже должна начаться.

````
return $robokassa->opState($invoiceID);
````

### Проверка платежа на ResultURL

````
$params['OutSum'] = $_POST['OutSum'];
$params['InvId'] = $_POST['InvId'];

if ($robokassa->checkResult($params)) {
    echo 'Успешно!';
};
````

### Проверка платежа на SuccessURL

````
$params['OutSum'] = $_POST['OutSum'];
$params['InvId'] = $_POST['InvId'];

if ($robokassa->checkSuccess($params)) {
    echo 'Успешно!';
};
````


