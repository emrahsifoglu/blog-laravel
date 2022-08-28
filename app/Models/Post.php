<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read User $author
 * @property-read Comment[] $comments
 */
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

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
      'title',
      'description',
      'author_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      'author_id' => 'string'
    ];

    /**
     * author
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
      return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * comments
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
      return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
