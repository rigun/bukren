<?php

return [
    'role_structure' => [
        'superadmin' => [

            'profile' => 'r,u'
        ],
        'admin' => [
   
            'profile' => 'r,u'
        ],
        'pengguna' => [
            'profile' => 'r,u'
        ],
    ],
    'permission_structure' => [

    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
