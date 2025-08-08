<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUploadCategory extends Model
{
    use HasFactory;
    protected $table = 'file_category_file_upload';
    protected $guarded = [];

    public function Category()
    {
        return $this->HasOne(Category::class,'id','file_category_id');
    }


}
