<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read User $commenter
 * @property-read Post $post
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'id',
      'text',
      'post_id',
      'commenter_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      'post_id' => 'string',
      'commenter_id' => 'string'
    ];

    /**
     * post
     *
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
      return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * author
     *
     * @return BelongsTo
     */
    public function commenter(): BelongsTo
    {
      return $this->belongsTo(User::class, 'commenter_id');
    }
}
