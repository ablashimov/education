<?php

namespace App\Events;

use App\Models\Group;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewGroupAvailable extends Notification implements ShouldBroadcast
{
    use Dispatchable;

    public function __construct(protected Group $group, protected int $userId)
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Доступна нова група навчання',
            'message' => "Група навчання '{$this->group->name}' тепер доступна для реєстрації учасників.",
            'entity_type' => 'group',
            'entity_id' => $this->group->id,
            'link' => "/admin/groups/{$this->group->id}",
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
        return 'group.available';
    }
}
