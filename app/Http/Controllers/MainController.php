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
    	// Auth::login(User::find(1));
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
    		$destinationPath = "img/competition/";
    		$extension = $request->file('duvel')->getClientOriginalExtension();
    		$fileName = rand(11111,99999).'.'.$extension; // renameing image
    		$fullPath = $destinationPath . $fileName;	

            $pic = $request->file('duvel');


            $picSize = getimagesize($pic);
            $width = $picSize[0];
            $height = $picSize[1];
            $newHeight = 100;
            $newWidth = $newHeight * ($width/$height);
            $image = imagecreatefromjpeg($pic);
            $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
            // var_dump($picSize);
            $heightFraction = $picSize[1]/$picSize[0];
            // echo $heightFraction;
            $newImage = imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            var_dump($thumbnail);
            $thumbnailPath = $destinationPath . '/thumbnail/' . $fileName;
            imagejpeg($thumbnail, $thumbnailPath);

            $pic->move($destinationPath , $fileName); // uploading file to given path
            $competitor = new Competitor;

            $competitor->picture_url = '/' . $fullPath;
            $competitor->thumbnail = '/' . $thumbnailPath;
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

    		return redirect()->route('otherCompetitors');
    	}

    	return redirect()->back()->withErrors(['you have already voted for this competitor.']);


    }

    public function otherCompetitors()
    {
        $competitors = Competitor::all();

        $data = ['competitors' => $competitors];

        return View('competition.otherCompetitors')->with($data);
    }

    public function test()
    {
        $users = User::all();
        $data = ['users' => $users];
        return View('test')->with($data);
    }

    public function postTest(Request $request)
    {
        $pic = Input::file('duvel');
        $picSize = getimagesize($pic);
        $width = $picSize[0];
        $height = $picSize[1];
        $newHeight = 100;
        $newWidth = $newHeight * ($width/$height);
        $image = imagecreatefromjpeg($pic);
        $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
        // var_dump($picSize);
        $heightFraction = $picSize[1]/$picSize[0];
        // echo $heightFraction;
        $newImage = imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        var_dump($thumbnail);

        imagejpeg($thumbnail, 'img/thumbnail/test.jpg');
        // imagecopyresampled(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    }

    public function testajax()
    {
        $user = Competitor::all();
        $vote = new Vote;

        $vote->ip = "lolz nope";
        $vote->competitor_id = $user->first()->id;

        $vote->save();

        return json_encode($user);
    }

    public function managment()
    {
        $competitors = Competitor::all();

        $data = ['competitors' => $competitors];

        return View('managment')->with($data);
    }
}

