<?php

namespace App\Providers;

use App\Activity;
use App\Comment;
use App\Http\Api\Transformers\LikeTransformer;
use App\Http\Api\Transformers\NotificationTransformer;
use App\Http\Api\Transformers\UserTransformer;
use App\Like;
use App\Notification;
use App\Post;
use App\User;
use Dingo\Api\Transformer\Factory as TransformerFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory as ValidationFactory;
use KodiCMS\Assets\Contracts\PackageManagerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(ValidationFactory $factory, TransformerFactory $transformerFactory, PackageManagerInterface $packageManager)
    {
        $this->registerMorphMap();
        $this->registerTransformers($transformerFactory);
        $this->registerCustomValidationRules($factory);

        $packageManager->add('jquery')
            ->js(null, asset('js/jquery.js'))
            ->css(null, asset('css/jquery.css'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function registerMorphMap()
    {
        Relation::morphMap([
            'posts' => Post::class,
            'comments' => Comment::class,
            'users' => User::class,
            'activities' => Activity::class,
        ]);
    }

    /**
     * @param Factory $factory
     */
    private function registerCustomValidationRules(ValidationFactory $factory)
    {
        $factory->extend('morph_exist', function ($attribute, $value) {
            return ! is_null(get_class_by_type($value));
        });
    }

    /**
     * @param TransformerFactory $factory
     *
     * @internal param TransformerFactory $transformerFactory
     */
    private function registerTransformers(TransformerFactory $factory)
    {
        $factory->register(User::class, UserTransformer::class);
        $factory->register(Like::class, LikeTransformer::class);
        $factory->register(Notification::class, NotificationTransformer::class);
    }
}
