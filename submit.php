<?php
require __DIR__ . '/src/FormBuilder.php';
use FormLib\FormBuilder;

$form = new FormBuilder();
$form->setData($_POST);

foreach ($_POST as $key => $value) $form->required($key);
if (isset($_POST['email'])) $form->email('email');
if (isset($_POST['password'])) $form->minLength('password',6);

if ($form->fails()) {
    echo "<div class='error'>";
    foreach ($form->errors() as $field => $errs) {
        foreach ($errs as $err) echo $err . "<br>";
    }
    echo "</div>";
} else {
    echo "<p>Данные успешно отправлены!</p>";
}
