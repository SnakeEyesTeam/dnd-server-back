<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'user'],
            ['name' => 'admin'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }

        $users = [
            [
                'name' => 'Zxccursed',
                'email' => 'zxczxc52@gmail.com',
                'password' => Hash::make('zxczxc123'),
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@mail.ru',
                'password' => Hash::make('adminadmin777'),
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }

        $departaments = [
            ['name' => 'D&d', 'img' => 'D&D.webp', 'fixed_post' => 1],
            ['name' => 'Web', 'img' => 'it.jpg', 'fixed_post' => 2],
            ['name' => 'Прочее', 'img' => 'forum.png', 'fixed_post' => 3],
        ];

        foreach ($departaments as $departament) {
            DB::table('departaments')->insert($departament);
        }

        $posts = [
            [
                'title' => 'Что такое D&D?',
                'description' => 'В этом году 40-летие отмечает популярная настольная игра Dungeons & Dragons. Появившись в 1974 году как инициатива двух фанатов настолок, D&D быстро снискала популярность среди игроков. А саму игру можно найти на полках любого магазина настолок и в игровых клубах. Рассказываем про настольную игру ДНД — что это такое и как в нее играть, разбираемся в причинах ее популярности и объясняем базовые принципы игры.',
                'content' => 'Это содержимое первого поста.',
                'tags' => 'тег1, тег2',
                'user_id' => 2,
                'departament_id' => 1,
            ],
            [
                'title' => 'О чем этот раздел?',
                'description' => 'Данный раздел мы посвятили развитию нашей платформы. Тут вы смотжете оставлять статьи, которые мы рассмотрим, и, возможно, реализуем ваши идеи!',
                'content' => 'Это содержимое второго поста.',
                'tags' => 'тег3',
                'user_id' => 2,
                'departament_id' => 2,
            ],
            [
                'title' => 'Как мы к этому пришли?',
                'description' => 'Очень интересная история, как мы пришли к реализации нашей платформы. Все началось месяцев 6 назад. Сыграв партию, без какого либо графического сопровождения, мы поняли, что это не то. Мы отправились на поиски достойного графического сопровождения, но ничего не нашли) так и было принято решения об основании платформы.',
                'content' => 'Это содержимое второго поста.',
                'tags' => 'тег3',
                'user_id' => 2,
                'departament_id' => 3,
            ],
        ];
        foreach ($posts as $post) {
            DB::table('posts')->insert($post);
        }

        $sources = [
            [
                'name' => 'Кастомный',
            ],
            [
                'name' => 'Карты'
            ],
            [
                'name' => 'Люди',
            ],
            [
                'name' => 'Звери',
            ],
            [
                'name' => 'Фентези существа',
            ],
            [
                'name' => 'Сооружения'
            ]
        ];

        foreach ($sources as $source) {
            DB::table('sources')->insert($source);
        }
        ;

        $bestiary = [
            [
                'name' => 'Эдгар Клин',
                'path' => '0bfef835368b0d2722a8a717fd16a4b2.jpg',
                'initiative' => 30,
                'description' => 'Эдгар Клин бандит',
                'idInBestiary' => 1,
                'source_id' => 3
            ],
            [
                'name' => 'Гигантский бабуин',
                'path' => '2ad9d1ef95c26ed0371980273824e4b3.jpg',
                'initiative' => 77,
                'description' => 'Гигантский бабуин',
                'idInBestiary' => 2,
                'source_id' => 3
            ],
            [
                'name' => 'Кроваво-белый медведь',
                'path' => '2e55e6ccb6770429e9d2a05e1cd016ea.jpg',
                'initiative' => 27,
                'description' => 'Кроваво-белый медведь',
                'idInBestiary' => 3,
                'source_id' => 4
            ],
            [
                'name' => 'Крестьяни',
                'path' => '3c7d0a1dfa4bef35a0bc3765e406c168.jpg',
                'initiative' => 27,
                'description' => 'Мирный жители',
                'idInBestiary' => 76,
                'source_id' => 3
            ],
            [
                'name' => 'Смерть',
                'path' => '3ca7c69aab8e4849617490cc8f45d2c0.jpg',
                'initiative' => 1,
                'description' => 'Смерть',
                'idInBestiary' => 4,
                'source_id' => 5
            ],
            [
                'name' => 'Демон козел',
                'path' => '6c46fa7e318ccf2c6c170e79c04b3f8c.jpg',
                'initiative' => 27,
                'description' => 'Демон козел',
                'idInBestiary' => 5,
                'source_id' => 5
            ],
            [
                'name' => 'Гриф',
                'path' => '8b46059aeb423a5d9f5a4bb69317b51e.jpg',
                'initiative' => 57,
                'description' => 'Гриф-пожиратель',
                'idInBestiary' => 6,
                'source_id' => 4
            ],
            [
                'name' => 'Белый грог',
                'path' => '8f6ec809c410cde00ee0864a0591cf4d.jpg',
                'initiative' => 99,
                'description' => 'Грог',
                'idInBestiary' => 7,
                'source_id' => 5
            ],
            [
                'name' => 'Гризли',
                'path' => '9f71f35f4bfd9382ab76247b86807933.jpg',
                'initiative' => 27,
                'description' => 'Кого там грызли',
                'idInBestiary' => 8,
                'source_id' => 4
            ],
            [
                'name' => 'Олень',
                'path' => '60c5ae4a8e9837e84709d7c2f5723ece.jpg',
                'initiative' => 7,
                'description' => 'Deer',
                'idInBestiary' => 9,
                'source_id' => 4
            ],
            [
                'name' => 'Хранитель',
                'path' => '82b3d87493da0188415982b0537b3357.jpg',
                'initiative' => 27,
                'description' => 'Хранитель знаний',
                'idInBestiary' => 10,
                'source_id' => 5
            ],
            [
                'name' => 'Лорд Грерор',
                'path' => '709b94f8feafc08652ba3d2c5c96bb3e.jpg',
                'initiative' => 66,
                'description' => 'Местный лорд',
                'idInBestiary' => 11,
                'source_id' => 3
            ],
            [
                'name' => 'Всадник',
                'path' => 'a34712b7fbd1bd92f6acd2537190d20c.jpg',
                'initiative' => 27,
                'description' => 'Всадник',
                'idInBestiary' => 12,
                'source_id' => 3
            ],
            [
                'name' => 'Голем',
                'path' => 'b4b6800b8306de5f56a9d15d75f80b41.jpg',
                'initiative' => 27,
                'description' => 'Как голем',
                'idInBestiary' => 13,
                'source_id' => 5
            ],
            [
                'name' => 'Гигантский краб',
                'path' => 'b6fb6b0a8c70bc0cc3282ece0a544d70.jpg',
                'initiative' => 27,
                'description' => 'Крабзила',
                'idInBestiary' => 14,
                'source_id' => 5
            ],
            [
                'name' => 'Дракон гнида',
                'path' => 'c33fe190665d556e123a6c95581e1323.jpg',
                'initiative' => 27,
                'description' => 'Дракон гнида',
                'idInBestiary' => 15,
                'source_id' => 5
            ],
            [
                'name' => 'Всадник на драконе',
                'path' => 'd8e3103234a92cf332483db38a2deb5a.jpg',
                'initiative' => 27,
                'description' => 'Всадник на драконе',
                'idInBestiary' => 16,
                'source_id' => 3
            ],
            [
                'name' => 'Гриффон',
                'path' => 'e1caf1b3921a0e955b1c75a01399ed58.jpg',
                'initiative' => 27,
                'description' => 'Гриффон из Гарри Потера',
                'idInBestiary' => 17,
                'source_id' => 5
            ],
            [
                'name' => 'Гоблин',
                'path' => 'fdfd341549acc29958ec1f7cf2aee0c4.jpg',
                'initiative' => 27,
                'description' => 'Гоблин в прайме',
                'idInBestiary' => 18,
                'source_id' => 5
            ],
        ];

        $maps = [
            [
                'name' => 'Пристань',
                'path' => '0b47579f77760c65e29e8de00bb7628e.jpg',
                'source_id' => '2'
            ],
            [
                'name' => 'Лесной склон',
                'path' => '4cbUc4BMJnMiNbXfC1oo1MJYGOrhXME-TQt69SjXFbr-8KDdS7KlwtVRc1dhP75zFaoLS6z7vqkNS7ayS18ulX7V.jpg',
                'source_id' => '2'
            ],
            [
                'name' => 'Таверна',
                'path' => '6ba6ed48ea7eddbb120c6618fa398408.jpg',
                'source_id' => '2'
            ],
            [
                'name' => 'Площадь',
                'path' => '8GmMCfKK1fOdSifW9IdoltAwyTJRc9ua1WDSwuAtAJxKN8G4sK4tf_47gHNLJ_NCa5GIVXBvMks-4-gHWcTJBKVA.jpg',
                'source_id' => '2'
            ],
            [
                'name' => 'Горный склон',
                'path' => '1609163716170691326.webp',
                'source_id' => '2'
            ],
            [
                'name' => 'Городские ворота',
                'path' => 'GlBLZ2Hs_fifPwGI7mcp3ZIFwO6FE7hQaXBK-qZP22ysqbj6TuWxgNjHAi-oPii9JExolPAwivQ0RT0pA0qtHjPt.jpg',
                'source_id' => '2'
            ],
            [
                'name' => 'Побережье',
                'path' => 'GLVhtFidyecg9G0h4RGkhKPpN1CvObKKvnrLSn_1rSslBfl9TNwOOfi-RfKblhImSZdmuIS-X54FxDT5N2aqQez2.jpg',
                'source_id' => '2'
            ],
            [
                'name' => 'Лесная чаща',
                'path' => 'LwoUGUa8JOi2Pq4tylar5nb_YJluOCXSuOm6EjTlxC42oWlUS8rLcy-icm5qWU9C-xo0qmuDkLVUz6f5MriSHgB1.jpg',
                'source_id' => '2'
            ],
            [
                'name' => 'Побережье с кораблем',
                'path' => 'vA9hIVogWpiZeR3QyS0hQmboUjLvtHZVBt0Di0hREpmvpcuA0uFLPc2XcbXux71ERjWzeGyrn0u9w6VhRqtXwX8i.jpg',
                'source_id' => '2'
            ],
        ];
        $objects = [
            [
                'name' => 'Коробка с гоблинами',
                'path' => 'object1.png',
                'source_id' => '6'
            ]
        ];


        foreach ($objects as $object) {
            DB::table('objects')->insert($object);
        }
        ;
        foreach ($bestiary as $entity) {
            DB::table('entities')->insert($entity);
        }
        ;
        foreach ($maps as $map) {
            DB::table('maps')->insert($map);
        }
        ;
    }
}