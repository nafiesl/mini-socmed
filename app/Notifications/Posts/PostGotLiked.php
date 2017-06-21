<?php

namespace App\Notifications\Posts;

use App\Post;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostGotLiked extends Notification
{
    use Queueable;

    public $post;
    public $liker;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $liker)
    {
        $this->post = $post;
        $this->liker = $liker;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'name'             => $this->liker->name,
            'message'          => ' likes your ',
            'notifier_user_id' => $this->liker->id,
            'post_id'          => $this->post->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'message' => $this->liker->name.' likes your post.',
        ];
    }
}
