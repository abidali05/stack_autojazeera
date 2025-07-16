<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirebaseChatAttachments extends Model
{
    use HasFactory;
    protected $table = 'firebase_chat_attachments';
    protected $guarded = [];
}
