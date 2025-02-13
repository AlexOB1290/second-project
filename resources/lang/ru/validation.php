<?php

return [
    'required' => 'Поле :attribute обязательно для заполнения.',
    'email' => 'Поле :attribute должно быть действительным email адресом.',
    'unique' => 'Такой :attribute уже зарегистрирован.',
    'min' => [
        'string' => 'Поле :attribute должно быть не менее :min символов.',
    ],
    'confirmed' => 'Пароли не совпадают.',
    'max' => [
        'string' => 'Поле :attribute не может быть более :max символов.',
    ],

    'attributes' => [
        'name' => 'Имя',
        'email' => 'Email',
        'password' => 'Пароль',
        'phone' => 'Телефон',
    ],
];
