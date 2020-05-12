<?php
namespace CodeForms\Repositories\Comment;

use Illuminate\Database\Eloquent\Builder;
/**
 * @package CodeForms\Repositories\Comment\Commentable
 */
trait Commentable
{
	/**
     * @return Illuminate\Database\Eloquent\Model
     */
    public static function bootCommentable()
    {
        static::deleted(function (self $model) {
            $model->deleteComments();
        });
    }

	/**
	 * @param string 	$title
	 * @param string	body
	 * @param int 		$parent_id
	 * 
	 * @return bool
	 */
	public function newComment($title, $body, $parent_id = null)
	{
		return $this->comments()->create([
			'title'     => $title,
			'body'      => $body,
			'parent_id' => $parent_id
		]);
	}

	/**
	 * @param int 		$comment_id
	 * @param string 	$title
	 * @param string 	$body
	 * 
	 * @return bool
	 */
	public function updateComment($comment_id, $title, $body)
	{
		return $this->comments()->where('id', $comment_id)->update([
			'title' => $title,
			'body'  => $body
		]);
	}

	/**
	 * @param $comment_id
	 * 
	 * @return bool
	 */
	public function deleteComment($comment_id)
	{
		$this->comments()->where('id', $comment_id)->delete();

		return Comment::where('parent_id', $comment_id)->update(['parent_id' => null]);
	}

	/**
	 * @return bool
	 */
	public function deleteComments()
	{
		return $this->comments()->delete();
	}

	/**
	 * @return bool
	 */
	public function hasComments(): bool
	{
		return (bool)self::countComments();
	}

	/**
	 * @return int
	 */
	public function countComments(): int
	{
		return $this->comments()->count();
	}

	/**
	 * @return Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}