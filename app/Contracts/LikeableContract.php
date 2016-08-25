<?php

namespace App\Contracts;

use App\User;

interface LikeableContract
{
    public function likes();

    /**
     * @return User
     */
    public function getAuthor();
}