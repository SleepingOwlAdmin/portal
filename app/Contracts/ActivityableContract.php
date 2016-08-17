<?php

namespace App\Contracts;

interface ActivityableContract
{
    /**
     * @return void
     */
    public function recordActivity();

    /**
     * @return int
     */
    public function authorId();

    /**
     * @return string
     */
    public function getViewForActivity();
}