<?php

namespace App\DataFixtures;

class UserDataFixtures
{
    public static function getData() {
        
        return [
            [
                'nickname' => 'user',
                'picture' => 'picture',
                'email' => 'user@bbq.bbq',
                'password' => 'bbq',
                'roles' => ['ROLE_USER'],
            ],
            [
                'nickname' => 'admin',
                'picture' => 'picture',
                'email' => 'admin@bbq.bbq',
                'password' => 'bbq',
                'roles' => ['ROLE_ADMIN'],               
            ],
            [
                'nickname' => 'darknasus',
                'picture' => 'picture',
                'email' => 'darknasus@bbq.bbq',
                'password' => 'darknasus',
                'roles' => ['ROLE_USER'],               
            ]
        ];
    }
}


// $user = new User();
// $user->setNickname('Erwann el Conquistador');
// $user->setEmail('erwann@bbq.bbq');
// $user->setPassword('$2y$13$SXn4r5iy0Ur8ih3o1exa0u98wdXUi51rEskhbdAHnAHmYcqcfN/4i');
// $user->setPicture('https://c.tenor.com/J-B26Ilt_jkAAAAM/lol-laugh.gif');
// $user->setRoles(['ROLE_ADMIN']);
// $user->setCreatedAt(new \DateTimeImmutable());
// $user->setArea(mt_rand(1, 101));


// $user = new User();
// $user->setNickname('Jennifer la Gardienne');
// $user->setEmail('jennifer@bbq.bbq');
// $user->setPassword('$2y$13$SXn4r5iy0Ur8ih3o1exa0u98wdXUi51rEskhbdAHnAHmYcqcfN/4i');
// $user->setPicture('https://c.tenor.com/J-B26Ilt_jkAAAAM/lol-laugh.gif');
// $user->setRoles(['ROLE_ADMIN']);
// $user->setCreatedAt(new \DateTimeImmutable());
// $user->setArea(mt_rand(1, 101));


// $user = new User();
// $user->setNickname('Cedric Le Juste');
// $user->setEmail('cedric@bbq.bbq');
// $user->setPassword('$2y$13$SXn4r5iy0Ur8ih3o1exa0u98wdXUi51rEskhbdAHnAHmYcqcfN/4i');
// $user->setPicture('https://c.tenor.com/J-B26Ilt_jkAAAAM/lol-laugh.gif');
// $user->setRoles(['ROLE_ADMIN']);
// $user->setCreatedAt(new \DateTimeImmutable());
// $user->setArea(mt_rand(1, 101));

// $user = new User();
// $user->setNickname('Khaled da Best');
// $user->setEmail('khaled@bbq.bbq');
// $user->setPassword('$2y$13$SXn4r5iy0Ur8ih3o1exa0u98wdXUi51rEskhbdAHnAHmYcqcfN/4i');
// $user->setPicture('https://c.tenor.com/J-B26Ilt_jkAAAAM/lol-laugh.gif');
// $user->setRoles(['ROLE_ADMIN']);
// $user->setCreatedAt(new \DateTimeImmutable());
// $user->setArea(mt_rand(1, 101));


// $user = new User();
// $user->setNickname('Brice la malice');
// $user->setEmail('brice@bbq.bbq');
// $user->setPassword('$2y$13$SXn4r5iy0Ur8ih3o1exa0u98wdXUi51rEskhbdAHnAHmYcqcfN/4i');
// $user->setPicture('https://c.tenor.com/J-B26Ilt_jkAAAAM/lol-laugh.gif');
// $user->setRoles(['ROLE_ADMIN']);
// $user->setCreatedAt(new \DateTimeImmutable());
// $user->setArea(mt_rand(1, 101));