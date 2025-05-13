<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;
    
    // টেবিল নাম স্পষ্টভাবে উল্লেখ করুন
    protected $table = 'audios';
    
    protected $fillable = [
        'serial_number',
        'title',
        'description',
        'audio_file',
        'is_active',
        'play_count'
    ];
}