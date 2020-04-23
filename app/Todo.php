<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;

    //
    protected $fillable = [
        'title',
        'user_id'  // 追記
];
    public function getByUserId($id)
    {
        return $this->where('user_id', $id)->get();
    }
    
    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];
}

//この作成したfileを Controller 側で使用できるようにします。モデルのファイル