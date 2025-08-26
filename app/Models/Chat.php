<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['teacher_id','student_id'];

    public function messages(){
        return $this->hasMany(Message::class);
     }
    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id');
     }
    public function student(){
        return $this->belongsTo(User::class,'student_id');
     }

    public function isParticipant(int $userId): bool
    {
        return in_array($userId, [$this->teacher_id, $this->student_id], true);
    }
}
