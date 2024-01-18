<?php

require '../php/UserValidate.php';
require '../php/DbConnection.php';

$db = new DbConnection();
$userValidate = new UserValidate('123', 'pass', 'name', 'email', 'passRepeat', $test);

var_dump($userValidate);
echo '<br> Name length:';

var_dump($userValidate->validateNameLength());
echo '<br> Name alnum:';

var_dump($userValidate->validateNameAlNum());
echo '<br> Name taken:';

var_dump($userValidate->validateNameIsTaken($db));
echo '<br> Email pattern:';

var_dump($userValidate->validateEmailPattern());
echo '<br> Email taken:';

var_dump($userValidate->validateEmailIsTaken($db));
echo '<br> Password lenght:';

var_dump($userValidate->validatePasswordLength());
echo '<br> Password match:';

var_dump($userValidate->validatePasswordMatch());
echo '<br> Tos check:';

var_dump($userValidate->validateTOSCheck());
echo '<br> All';

var_dump($userValidate->validateAll($db));