<?php

namespace Ogrre\ChatGPT;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/chat.php', 'chat'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->app->singleton(ChatRegistrar::class, function (){
            return new ChatRegistrar();
        });

        $this->publishes([
            __DIR__.'/../config/chat.php' => config_path('chat.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/create_chat_gpt_tables.php.stub' => $this->getMigrationFileName('create_chat_gpt_tables.php'),
        ], 'migrations');
    }

    /**
     * @param $migrationFileName
     * @return string
     * @throws BindingResolutionException
     */
    protected function getMigrationFileName($migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR .'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                return $filesystem->glob($path.'*_'.$migrationFileName);
            })
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
