<?php
require __DIR__ . '/src/FormBuilder.php';
use FormLib\FormBuilder;

$formType = $_GET['form'] ?? 'register';
$form = new FormBuilder("submit.php", "POST");

if ($formType === 'register') {
    $form->addInput("text","username","Имя пользователя");
    $form->addInput("email","email","Email");
    $form->addInput("password","password","Пароль");
    $form->addSubmit("Зарегистрироваться");
} elseif ($formType === 'feedback') {
    $form->addInput("text","name","Ваше имя");
    $form->addInput("email","email","Email");
    $form->addTextarea("message","Сообщение");
    $form->addSubmit("Отправить");
}

echo $form->render();
