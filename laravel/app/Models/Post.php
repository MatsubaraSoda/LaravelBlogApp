<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parsedown;

class Post extends Model
{
    use HasFactory;

    /**
     * 主键字段名
     */
    protected $primaryKey = 'post_id';

    /**
     * 路由键名（用于路由模型绑定）
     */
    public function getRouteKeyName()
    {
        return 'post_id';
    }

    /**
     * 可批量赋值的属性
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'status',
        'published_at',
        'subtitle',
        'content_markdown',
    ];

    /**
     * 属性类型转换
     */
    protected $casts = [
        'published_at' => 'date',
    ];

    /**
     * 获取格式化的发布日期
     */
    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->format('Y年m月d日') : '未发布';
    }

    /**
     * 与User模型的关系
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * 将Markdown内容转换为HTML
     */
    public function getContentHtmlAttribute()
    {
        if (empty($this->content_markdown)) {
            return '';
        }
        
        return Parsedown::instance()->text($this->content_markdown);
    }
}
