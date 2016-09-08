<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use KodiCMS\Assets\Contracts\MetaInterface;
use Meta;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var MetaInterface
     */
    public $meta;

    public function __construct(MetaInterface $meta)
    {
        $this->meta = $meta;

        $this->meta->clear();

        $this->meta
            ->addJs('settings', url('api/settings.js'), [], true)
            ->addJs('app', elixir('js/app.js'), ['settings'], true)
            ->addCss('app', elixir('css/app.css'));
    }
}
