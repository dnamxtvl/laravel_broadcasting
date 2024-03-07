<?php

namespace App\Providers;

use App\Repository\Implement\ConversationRepository;
use App\Repository\Implement\MessageRepository;
use App\Repository\Implement\UserRepository;
use App\Repository\Interface\ConversationRepositoryInterface;
use App\Repository\Interface\MessageRepositoryInterface;
use App\Repository\Interface\UserRepositoryInterface;
use App\Services\Implement\ChatService;
use App\Services\Interface\ChatServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;
use SebastianBergmann\Invoker\TimeoutException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(ChatServiceInterface::class, ChatService::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(ConversationRepositoryInterface::class, ConversationRepository::class);
        $this->app->singleton(MessageRepositoryInterface::class, MessageRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        DB::whenQueryingForLongerThan(config('app.max_query_timeout'), function (Connection $connection,  QueryExecuted $event) {
            Log::error(message: $event->sql . ' timeout ' . $event->time . ' in database ' . $event->connectionName);
            throw new TimeoutException('Database mất quá nhiều thời gian phản hồi.');
        });
    }
}
