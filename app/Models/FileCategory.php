<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileCategory extends Model
{
    use HasFactory;
    protected $table = 'file_category';
    protected $guarded = [];

    public function fileUploads()
    {
        return $this->belongsToMany(FileUpload::class, 'file_category_file_upload')
                    ->withPivot('file_path', 'amount')
                    ->withTimestamps();
    }

    public function files()
    {
        return $this->belongsToMany(FileUpload::class)->withTimestamps();
    }

	public function FileUploadCategory(){
		return $this->HasMany(FileUploadCategory::class,'file_category_id');
	}
}
