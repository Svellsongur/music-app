<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActivityLog extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable, Dispatchable, InteractsWithSockets, SerializesModels;
    protected $user_id;
    protected $fileCount;
    protected $fileName;
    protected $controllerType;
    protected $notificationType;

    /**
     * Create a new notification instance.
     */
    public function __construct($user_id, $fileCount, $fileName,  $controllerType, $notificationType)
    {
        //controllerType = 1 for song, 2 for playlist
        //notificationType = 1 for upload, 2 for delete
        $this->user_id = $user_id;
        $this->fileCount = $fileCount;
        $this->fileName = $fileName;
        $this->controllerType = $controllerType;
        $this->notificationType = $notificationType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        switch ($this->controllerType){
            case '1':
                switch ($this->notificationType){
                    case '1':
                        return [
                            //
                            'message' => 'You uploaded '.$this->fileCount.' files.',
                            'data' => $this->fileName
                        ];
                        break;
                    case '2':
                        return [
                            //
                            'message' => 'You deleted '.$this->fileCount.' files.',
                            'data' => $this->fileName
                        ];
                        break;
                }
            case '2':
                switch ($this->notificationType){
                    case '1':
                        return [
                            //
                            'message' => 'You created a new playlist',
                            'data' => $this->fileName
                        ];
                        break;
                    case '2':
                        return [
                            //
                            'message' => 'You deleted a playlist',
                            'data' => $this->fileName
                        ];
                        break;
                }
        }

    }

    public function broadcastOn()
    {
        return new PrivateChannel('music-app-lavender'.$this->user_id);
    }

    // broadcast as a custom event
    // public function broadcastAs(){

    // }
}
