<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use App\Models\Subscription;
use Illuminate\Console\Command;
use App\Mail\NewPostNotification;
use Illuminate\Support\Facades\Mail;

class SendNewPostNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications to subscribers for new posts';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $posts = Post::where('sent', false)->get();

        foreach ($posts as $post) {
            $subscriptions = Subscription::where('website_id', $post->website_id)->get();

            foreach ($subscriptions as $subscription) {
                $user = User::find($subscription->user_id);
                $website = Website::find($post->website_id);
                Mail::to($user->email)->send(new NewPostNotification(['name' => $website->name, 'title' => $post->title, 'description' => $post->description]));

                $post->sent = true;
                $post->save();
            }
        }

        $this->info('Emails sent successfully!');
    }
}
