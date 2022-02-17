<?php

return [
    'default_user'=>[
    'password'=>env('DEFAULT_USER_PASSWORD','1234567'),
    'name'=>env('DEFAULT_USER_NAME','Pepito'),
    'email'=>env('DEFAULT_USER_EMAIL','Pepito@iesebre.com')
    ],

    'default_user_profe'=>[
    'password'=>env('DEFAULT_USER_PROFE_PASSWORD','1234567'),
    'name'=>env('DEFAULT_USER_PROFE_NAME','sergi'),
    'email'=>env('DEFAULT_USER_PROFE_EMAIL','sergi@iesebre.com')
],
    'admins'=>[
        'dpont@iesebre.com',
        'sergiturbadenas@gmail.com'
    ]
];
