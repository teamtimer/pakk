<?php

namespace App\Controllers;

use App\Entities\User;
use TeamTimer\Pakk\Base\Controller;

class PakkController extends Controller
{
    public static function definitions(){
        return [
            'Pakk' => [
                'icon' => 'dashicons-admin-site',
                'items' =>[
                    [
                        'title' => 'Readme',
                        'slug' => 'pakk/readme',
                        'action' => 'readme',
                    ],
                ]
            ]
        ];
    }
    public function readme(){
        $numberOfUsers = User::query()->count();

        return $this->render('readme', [
            'numberOfUsers' => $numberOfUsers,
        ]);
    }
}