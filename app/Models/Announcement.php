<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'type',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'info' => 'blue',
            'warning' => 'yellow',
            'success' => 'green',
            'important' => 'red',
            default => 'blue',
        };
    }

    public function hasFile()
    {
        return !empty($this->file_path);
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function getFileSizeFormattedAttribute()
    {
        if (!$this->file_size) return null;

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileIconAttribute()
    {
        if (!$this->file_type) return 'document';

        return match(true) {
            str_contains($this->file_type, 'pdf') => 'document-text',
            str_contains($this->file_type, 'image') => 'photograph',
            str_contains($this->file_type, 'video') => 'video-camera',
            str_contains($this->file_type, 'audio') => 'volume-up',
            str_contains($this->file_type, 'zip') || str_contains($this->file_type, 'archive') => 'archive',
            str_contains($this->file_type, 'word') || str_contains($this->file_type, 'document') => 'document',
            str_contains($this->file_type, 'spreadsheet') || str_contains($this->file_type, 'excel') => 'table',
            str_contains($this->file_type, 'presentation') || str_contains($this->file_type, 'powerpoint') => 'presentation-chart-bar',
            default => 'document',
        };
    }
}
