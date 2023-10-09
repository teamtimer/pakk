<?php

namespace App\Entities;

use TeamTimer\Pakk\Base\Entity;

/**
 * Cycle ORM entity schema class for `wp_users` table.
 * @method static \App\Repositories\UserRepository getRepository()
 */
class User extends Entity
{
    public $id;

    public $user_login;

    public $user_pass;

    public $user_nicename;

    public $user_email;

    public $user_url;

    public $user_registered;
    public $user_activation_key;
    public $user_status;

    public $display_name;

    public static function tableName(): string
    {
        return 'wp_users';
    }

    public static function fields(): array
    {
        return [
            'id' => 'primary',
            'user_login' => 'string(60)',
            'user_pass' => 'string(255)',
            'user_nicename' => 'string(50)',
            'user_email' => 'string(100)',
            'user_url' => 'string(100)',
            'user_registered' => 'datetime',
            'user_activation_key' => 'string(255)',
            'user_status' => 'integer',
            'display_name' => 'string(250)'
        ];
    }
}