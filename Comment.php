<?php 
namespace CodeForms\Repositories\Comment;

use Illuminate\Database\Eloquent\{Model};
/**
 * @package CodeForms\Repositories\Comment\Comment
 */
class Comment extends Model 
{
	/**
     * @var string
     */
	protected $table = 'comments';

    /**
     * 
     */
    protected $fillable = ['title', 'body', 'user_id', 'parent_id'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($comment) {
            $comment->user_id = auth()->user()->id;
        });
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentComment()
    {
    	return $this->belongsTo(self::class, 'parent_id');
    }

    /**
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function childComments()
	{
		return $this->hasMany(self::class, 'parent_id', 'id');
	}

    /**
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}