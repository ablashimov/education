<?php

namespace App\Events;

use App\Models\Exam;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewExamAvailable extends Notification implements ShouldBroadcast
{
    use Dispatchable;

    public function __construct(protected Exam $exam, protected int $userId)
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Новий екзамен доступен',
            'message' => "Екзамен '{$this->exam->title}' вже доступний для проходження.",
            'entity_type' => 'exam',
            'entity_id' => $this->exam->id,
            'link' => "/exams/{$this->exam->id}",
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastAs(): string
    {
        return 'exam.available';
    }
}
