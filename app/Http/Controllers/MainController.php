<?php

namespace App\Http\Controllers;

use App\User;
use App\Competitor;
use App\Vote;
use Input;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    //

    public function competition()
    {
    	Auth::login(User::find(1));
    	$users = User::all();
    	$competitors = Competitor::all();
    	$data = ['competitors' => $competitors];
    	foreach ($competitors as $key => $competitor) {
    		# code...
    	// var_dump($competitor->getTotalVotes());
    	}

    	return View('competition.competition')->with($data);

    }

    public function postCompetition(Request $request)
    {
    	var_dump($request->getClientIp() . '<br>');
    	var_dump(Input::file('duvel'));
    	// var_dump($request->file('duvel'));
    	if( $request->file('duvel')->isValid() )
    	{
    		echo 'valid image';
    		$destinationPath = "/img/competition/";
    		$extension = $request->file('duvel')->getClientOriginalExtension();
    		$fileName = rand(11111,99999).'.'.$extension; // renameing image
    		$fullPath = $destinationPath . $fileName;	

            $request->file('duvel')->move( $destinationPath , $fileName); // uploading file to given path
            $competitor = new Competitor;

            $competitor->picture_url = $fullPath;
            $competitor->user_id = Auth::user()->id;

            $competitor->save();

            return redirect()->route('competition')->withSuccess("you've succesfully uploaded your picture. cheers!");
    	}
    }

    public function competitor($id)
    {
    	$competitor = Competitor::findOrFail($id);

    	// var_dump($competitor);
    	$data = array('competitor' => $competitor);
    	return view('competition.competitor')->with($data);
    }

    public function vote($id, Request $request)
    {
    	$competitor = Competitor::findOrFail($id);

    	if(!Vote::where('ip', '=', $request->getClientIp())->where('competitor_id', '=', $id)->exists())
    	{
    		echo 'nice';
    		$vote = new Vote;

    		$vote->ip = $request->getClientIp();
    		$vote->competitor_id = $id;

    		$vote->save();

    		return redirect()->route('competition');
    	}

    	return redirect()->back()->withErrors(['you have already voted for this competitor.']);


    }
}
