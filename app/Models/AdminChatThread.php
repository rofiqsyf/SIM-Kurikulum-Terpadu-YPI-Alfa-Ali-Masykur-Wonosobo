<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdminChatThread extends Model
{
    use HasFactory;

    protected $table = 'admin_chat_threads';

    protected $guarded = ['id'];

    protected $casts = [
        'last_message_at' => 'datetime',
        'unread_for_user' => 'integer',
        'unread_for_admin' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(AdminChatMessage::class, 'thread_id');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(AdminChatMessage::class, 'thread_id')->latestOfMany();
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function markAsReadForUser(): void
    {
        $this->update(['unread_for_user' => 0]);
        $this->messages()
            ->where('sender_id', '!=', $this->user_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function markAsReadForAdmin(): void
    {
        $this->update(['unread_for_admin' => 0]);
        $this->messages()
            ->where('sender_id', $this->user_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}
