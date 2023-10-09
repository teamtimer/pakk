<?php

namespace App\Repositories;

class UserRepository extends \Cycle\ORM\Select\Repository
{
    public function findByUsername($username)
    {
        return $this->select()->where('user_login', $username)->fetchOne();
    }
}