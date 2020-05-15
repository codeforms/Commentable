<?php 
namespace CodeForms\Repositories\Comment;

use Exception;
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
     * @var array
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

            if($comment->parent_id)
                return self::hasParent($comment->parent_id);
        });

        static::deleting(function (self $comment) {
            return self::deleteChilds($comment);
        });
    }

    /**
     * @param object $comment
     * 
     * @return boolean
     */
    private static function deleteChilds($comment): bool
    {
        return $comment->childComments()->delete();
    }

    /**
     * @param $parent_id
     * 
     * @return mixed
     */
    private static function hasParent($parent_id)
    {
        $comment = self::find($parent_id);

        if(is_null($comment->parent_id))
            return true;
        
        throw new Exception('The maximum nesting depth is restricted to 1.');
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