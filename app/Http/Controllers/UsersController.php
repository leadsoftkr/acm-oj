<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Sentinel;

class UsersController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'show'
            ]
        ]);

        //$this->middleware('log', ['only' => ['fooAction', 'barAction']]);
    }
  
    public function show($username)
    {
        $user = User::findByNameOrFail($username);
        $userTriedProblemCount  = $user->getTriedProblems()->count();
        $userAcceptProblemCount = $user->getAcceptProblems()->count();
        $userTotalProblemCount = $userTriedProblemCount + $userAcceptProblemCount;
        $userTriedProblemRate = $userTotalProblemCount > 0 ? ($userTriedProblemCount / $userTotalProblemCount) * 100 : 0;
        
        
        $testImage = "http://people.imbc.com/images/thumbnail/A1105009727.jpg";
        if( $user->name == 'yukariko' )
          $testImage = "https://files.slack.com/files-pri/T0EJZPLJ2-F0G7GV2UW/pasted_image_at_2015_12_09_05_26_pm.png";
        elseif( rand()%2 == 1 )
          $testImage = "https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfp1/v/t1.0-1/p40x40/11889666_933856966670876_899689170782757543_n.jpg?oh=e9c1b7ce8df50bacc32bda54c477893d&oe=56E92B1D&__gda__=1456929032_be7569ff3468ce54d95ed4e4b3d9f6a5";
        
        return view('users.show', compact('user', 'userTriedProblemRate', 'testImage'));
    }
    
    public function settings()
    {
        $userId = Sentinel::getUser()->id;
        $user = User::find($userId);
        
        return view('users.settings', compact('user'));
    }
}
