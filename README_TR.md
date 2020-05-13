# Commentable
Laravel tabanlı model kaynaklarına, basit ve kullanışlı yorum özelliği kazandıran trait yapısı.

[![GitHub license](https://img.shields.io/github/license/codeforms/Commentable)](https://github.com/codeforms/Commentable/blob/master/LICENSE)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/codeforms/Commentable)
[![stable](http://badges.github.io/stability-badges/dist/stable.svg)](https://github.com/codeforms/Commentable/releases)

## Kurulum
* Migration dosyasını kullanarak veri tabanı için gerekli tabloları oluşturun;
``` php artisan migrate```
* Commentable trait dosyasını, kullanmak istediğiniz model dosyalarına ekleyiniz;
```php
namespace App\Post;

use CodeForms\Repositories\Comment\Commentable;
use Illuminate\Database\Eloquent\Model;
/**
 * 
 */
class Post extends Model 
{
	use Commentable;
}
```

## Kullanım
```php
$post = Post::find(1);

# bir $post için yeni yorum ekleme
$post->newComment('Merhaba!', 'Bu post için yorumum');
# $post'a daha önce yapılmış olan bir yorum için yeni bir cevap yorumu eklenecekse
$post->newComment('Selam!', 'Üstteki Yoruma cevabım.', $comment_id); 

# mevcut bir $post'a yapılan spesifik bir yorumun güncellenmesi
$post->updateComment($comment_id, 'Merhaba Tekrar', 'Yorumu güncelliyorum');

# mevcut bir $post'a yapılan spesifik bir yorumu ($comment_id) siler
$post->deleteComment($comment_id);

# mevcut bir $post'a ait tüm yorumları siler
$post->deleteComments();

# mevcut bir $post'a ait yorumların sorgulanması
$post->hasComments();

# mevcut bir $post'a yapılan tüm yorumların toplam sayısı
$post->countComments();

/************
 * Yorum işlemleri
 */
$comment = Comment::find(1);

# bir yorum için yapılmış tüm alt cevapları/yorumları alır
$comment->childComments; // veya
$comment->childComments()->get();

# bir alt cevap yorumunun ait olduğu üst yorum bilgisini alır
$comment->parentComment; // veya
$comment->parentComment()->first();
``` 
