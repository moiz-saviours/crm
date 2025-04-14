<?php

namespace App\Providers;

use App\Services\GlobalService;
use App\Services\Restrict\PaymentGatewayService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Invoice;
use App\Policies\InvoicePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GlobalService::class, function ($app) {
            return new GlobalService();
        });
        $this->app->singleton(PaymentGatewayService::class, function ($app) {
            return new PaymentGatewayService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Invoice::class, InvoicePolicy::class);

//        RateLimiter::for('global', function (Request $request) {
//            return Limit::perMinute(1)->by(optional($request->user())->id ?: $request->ip());
//        });
        $quotes = [
            [
                'quote' => 'Act only according to that maxim whereby you can, at the same time, will that it should become a universal law.',
                'author' => 'Immanuel Kant',
            ],
            [
                'quote' => 'An unexamined life is not worth living.',
                'author' => 'Socrates',
            ],
            [
                'quote' => 'Be present above all else.',
                'author' => 'Naval Ravikant',
            ],
            [
                'quote' => 'Do what you can, with what you have, where you are.',
                'author' => 'Theodore Roosevelt',
            ],
            [
                'quote' => 'Happiness is not something readymade. It comes from your own actions.',
                'author' => 'Dalai Lama',
            ],
            [
                'quote' => 'He who is contented is rich.',
                'author' => 'Laozi',
            ],
            [
                'quote' => 'I begin to speak only when I am certain what I will say is not better left unsaid.',
                'author' => 'Cato the Younger',
            ],
            [
                'quote' => 'I have not failed. I\'ve just found 10,000 ways that won\'t work.',
                'author' => 'Thomas Edison',
            ],
            [
                'quote' => 'If you do not have a consistent goal in life, you can not live it in a consistent way.',
                'author' => 'Marcus Aurelius',
            ],
            [
                'quote' => 'It is never too late to be what you might have been.',
                'author' => 'George Eliot',
            ],
            [
                'quote' => 'It is not the man who has too little, but the man who craves more, that is poor.',
                'author' => 'Seneca',
            ],
            [
                'quote' => 'It is quality rather than quantity that matters.',
                'author' => 'Lucius Annaeus Seneca',
            ],
            [
                'quote' => 'Knowing is not enough; we must apply. Being willing is not enough; we must do.',
                'author' => 'Leonardo da Vinci',
            ],
            [
                'quote' => 'Let all your things have their places; let each part of your business have its time.',
                'author' => 'Benjamin Franklin',
            ],
            [
                'quote' => 'No surplus words or unnecessary actions.',
                'author' => 'Marcus Aurelius',
            ],
            [
                'quote' => 'Nothing worth having comes easy.',
                'author' => 'Theodore Roosevelt',
            ],
            [
                'quote' => 'Order your soul. Reduce your wants.',
                'author' => 'Augustine',
            ],
            [
                'quote' => 'People find pleasure in different ways. I find it in keeping my mind clear.',
                'author' => 'Marcus Aurelius',
            ],
            [
                'quote' => 'Simplicity is an acquired taste.',
                'author' => 'Katharine Gerould',
            ],
            [
                'quote' => 'Simplicity is the consequence of refined emotions.',
                'author' => 'Jean D\'Alembert',
            ],
            [
                'quote' => 'Simplicity is the essence of happiness.',
                'author' => 'Cedric Bledsoe',
            ],
            [
                'quote' => 'Simplicity is the ultimate sophistication.',
                'author' => 'Leonardo da Vinci',
            ],
            [
                'quote' => 'Smile, breathe, and go slowly.',
                'author' => 'Thich Nhat Hanh',
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs',
            ],
            [
                'quote' => 'The whole future lies in uncertainty: live immediately.',
                'author' => 'Seneca',
            ],
            [
                'quote' => 'Very little is needed to make a happy life.',
                'author' => 'Marcus Aurelius',
            ],
            [
                'quote' => 'Waste no more time arguing what a good man should be, be one.',
                'author' => 'Marcus Aurelius',
            ],
            [
                'quote' => 'Well begun is half done.',
                'author' => 'Aristotle',
            ],
            [
                'quote' => 'When there is no desire, all things are at peace.',
                'author' => 'Laozi',
            ],
            [
                'quote' => 'Walk as if you are kissing the Earth with your feet.',
                'author' => 'Thich Nhat Hanh',
            ],
            [
                'quote' => 'Because you are alive, everything is possible.',
                'author' => 'Thich Nhat Hanh',
            ],
            [
                'quote' => 'Breathing in, I calm body and mind. Breathing out, I smile.',
                'author' => 'Thich Nhat Hanh',
            ],
            [
                'quote' => 'Life is available only in the present moment.',
                'author' => 'Thich Nhat Hanh',
            ],
            [
                'quote' => 'The best way to take care of the future is to take care of the present moment.',
                'author' => 'Thich Nhat Hanh',
            ],
            [
                'quote' => 'Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less.',
                'author' => 'Marie Curie',
            ],
            [
                'quote' => 'The biggest battle is the war against ignorance.',
                'author' => 'Mustafa Kemal Atatürk',
            ],
            [
                'quote' => 'Always remember that you are absolutely unique. Just like everyone else.',
                'author' => 'Margaret Mead',
            ],
        ];
        $randomQuote = $quotes[array_rand($quotes)];
        View::share('inspire_quote', $randomQuote['quote']);
        View::share('inspire_author', $randomQuote['author']);
        View::composer('*', function ($view) use ($quotes) {
            $randomQuote = $quotes[array_rand($quotes)];
            $view->with('inspire_quote', $randomQuote['quote'])
                ->with('inspire_author', $randomQuote['author']);
        });
    }
}
