<?php

namespace App\Http\Forms;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

abstract class Form
{
    use ValidatesRequests;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Form constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function save()
    {
        if($this->isValid()) {
            $this->persist();

            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function fields()
    {
        return $this->request->all();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return array
     */
    public function labels()
    {
        return [];
    }

    /**
     * @return Request
     */
    public function request()
    {
        return $this->request;
    }

    abstract public function persist();

    /**
     * @return bool
     */
    public function isValid()
    {
        $this->validate($this->request, $this->rules(), $this->labels());

        return true;
    }

    public function __get($name)
    {
        return $this->request->input($name);
    }
}