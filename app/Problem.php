<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProblemStatistics;
use GrahamCampbell\Markdown\Facades\Markdown;

use Sentinel;

class Problem extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'problems';

    protected $fillable = [
        'title',
        'description',
        'time_limit',
        'memory_limit',
        'input',
        'output',
        'sample_input',
        'sample_output',
        'hint',
        'status',
        'total_submit'
    ];


    // markdown

    public function getMdDescription(){
        return Markdown::convertToHtml($this->description);
    }
    public function getMdInput(){
        return Markdown::convertToHtml($this->input);
    }
    public function getMdOutput(){
        return Markdown::convertToHtml($this->output);
    }
    public function getMdHint(){
        return Markdown::convertToHtml($this->hint);
    }
    
    // solutions

    public function solutions() {
        return $this->hasMany('App\Solution')->where('is_hidden', 0);
    }

    public function solutionsAccept() {
        return $this->solutions()->where('result_id', \App\Result::getAcceptCode());
    }
    
    
    // statistics

    public function problemStatistics() {
        return $this->hasMany('App\ProblemStatistics');
    }
    
    public function getSubmitCount() {
        return $this->total_submit;
    }

    public function getAcceptCount() {
        return Statistics::getCountOrZero($this->problemStatistics()->where('result_id', Result::getAcceptCode())->first());
    }

    public function statistics() {
        return $this->hasMany('App\Statistics');
    }
    
    public function getRate() {
        $submitCnt = $this->getSubmitCount();
        return $submitCnt > 0 ? 100 * $this->getAcceptCount() / $submitCnt : 0;
    }

    public function isAccepted() {
        if( ! Sentinel::check() ) return false;
        return Statistics::getCountOrZero($this->statistics()
            ->where('user_id', Sentinel::getUser()->id)->where('result_id', Result::getAcceptCode())->first()) > 0;
    }

    public function isTried() {
        if( ! Sentinel::check() ) return false;
        return ($this->statistics()->where('user_id', Sentinel::getUser()->id)
            ->where('result_id', '!=', Result::getAcceptCode())->max('count')) > 0;
    }

    // thanks

    public function problemThank() {
        return $this->hasMany('App\ProblemThank', 'problem_id');
    }

    public function scopeGetProblemsCreateByUser($query, $user_id) {
        return $query->list()->join('problem_thank', function($join) {
            $join->on('problems.id', '=','problem_thank.problem_id');
        })->where('thank_id', Thank::getAuthorId())->where('user_id', $user_id);
    }

    // list

    public function scopeGetOpenProblemOrFail($query, $id) {
        return $query->where('status', true)->findOrFail($id);
    }

    public function scopeList($query) {
        return $query->select('problems.id', 'title', 'total_submit', 'status');
    }

    public function scopeGetOpenProblems($query) {
        return $query->list()->where('status', true);
    }

    public function scopeGetHiddenProblemOrFail($query, $id) {
        return $query->where('status', 0)->findOrFail($id);
    }

    public function scopeGetHiddenProblems($query) {
        return $query->list()->where('status', 0);
    }

    public function scopeGetNewestProblems($query, $takes) {
        return $query->list()->latest('created_at')->latest('id')
                    ->where('status', 1)
                    ->take($takes)->get();
    }


    // tag
    
    public function problemTag() {
        return $this->hasMany('App\ProblemTag');
    }
    
    public function getPopularTags() {
        return $this->problemTag()->orderBy('count', 'desc')->take(3);
    }

    public function scopeGetProblemsByTag($query, $tag_id) {
        return $query->join('problem_tag', function($join) {
            $join->on('problems.id', '=', 'problem_tag.problem_id');
        })->getOpenProblems()->where('tag_id', $tag_id)->orderBy('count', 'desc');
    }

    // create, update

    public static function createProblem(array $values, $user_id) {
        $thanks = new ProblemThank;
        $thanks['thank_id'] = Thank::getAuthorId();
        $thanks['user_id'] = $user_id;

        $problem = Problem::create($values);
        $problem->problemThank()->save($thanks);
        return $problem;
    }

    public function updateStatus($status) {
        return $this->update(['status'=>$status]);
    }
}
