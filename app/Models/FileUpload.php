<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;
    protected $table = 'file_uploads';
    protected $guarded = [];

    public function isImage()
    {
        return in_array(strtolower(pathinfo($this->path, PATHINFO_EXTENSION)), ['jpeg', 'jpg', 'png', 'gif', 'svg']);
    }

    public function isPdf()
    {
        return strtolower(pathinfo($this->path, PATHINFO_EXTENSION)) === 'pdf';
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class,'file_id','id');
    }

    public function FileCategory()
    {
        return $this->hasMany(FileUploadCategory::class,'file_upload_id','id');
    }

    public function categories()
    {
        return $this->belongsToMany(FileCategory::class)->withTimestamps();
    }

    public function fileCategories()
    {
        return $this->belongsToMany(FileCategory::class, 'file_category_file_upload')
                    ->withPivot('file_path', 'amount')
                    ->withTimestamps();
    }

    public function isPaidForUser($userId)
    {
        return $this->purchases()->where('user_id', $userId)->exists();
    }




}
