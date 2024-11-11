<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommentCreatedNotification extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Yangi izoh qo\'shildi.',
            'post_id' => $this->comment->post_id,
            'post_title' => $this->comment->post ? $this->comment->post->title : 'Post not found', // Tekshiruv qo'shildi
        ];
    }
    
}
