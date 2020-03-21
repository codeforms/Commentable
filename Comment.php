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