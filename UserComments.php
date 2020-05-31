<?php
namespace CodeForms\Repositories\Comment;

use Illuminate\Database\Eloquent\Builder;
/**
 * @package CodeForms\Repositories\Comment\UserComment
 */
trait UserComments
{
	/**
	 * 
	 */
	public function comments()
	{
		return $this->hasMany(Comment::class, 'user_id', 'id');
	}
}