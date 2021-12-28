<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $fillable = [
        'title',
        'title_signal',
        'tag_post_id',
        'title_image',
        'top_image',
        'status'
    ];

    protected $table = 'post';
    public $searchable = ['name', 'status'];

    protected $hidden = ['status', 'created_at', 'updated_at'];

    public function postImages() {
        return $this->hasMany(PostImage::class);
    }
}