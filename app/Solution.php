<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Result;
use App\Language;

class Solution extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'solutions';

    protected $fillable = [
        'id',
        'result_id',
        'lang_id',
        'problem_id',
        'user_id',
        'time',
        'memory',
        'size',
        'is_hidden',
        'created_at',
    ];

    protected $guarded = [];

    public function problem() {
        return $this->belongsTo('App\Problem')->where('status', 1);
    }

    public function problemAll() {
        return $this->belongsTo('App\Problem');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function language() {
        return $this->belongsTo('App\Language', 'lang_id' /* 이것과 연결 */);
    }

    public function result() {
        return $this->belongsTo('App\Result', 'result_id');
    }

    public function publishedResult() {
        return $this->result()->where('published', '!=', 0);
    }

    public function accepted() {
        return $this->result()->where('id', \App\Result::getAcceptCode())->first();
    }

    public function resultToHtml() {
        $result = Result::find($this->result_id);

        return "<span class=\"solution {$result->class_name}\">{$result->description}</span>";
    }

}
