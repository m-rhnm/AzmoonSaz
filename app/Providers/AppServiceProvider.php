<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\repositories\Eloquent\EloquentQuizRepository;
use App\repositories\Eloquent\EloquentUserRepository;
use App\repositories\Contracts\QuizRepositoryInterface;
use App\repositories\Contracts\UserRepositoryInterface;
use App\repositories\Eloquent\EloquentCategoryRepository;
use App\repositories\Eloquent\EloquentQuestionRepository;
use App\repositories\Contracts\CategoryRepositoryInterface;
use App\repositories\Contracts\QuestionRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, EloquentCategoryRepository::class);
        $this->app->bind(QuizRepositoryInterface::class, EloquentQuizRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, EloquentQuestionRepository::class);
    }

}