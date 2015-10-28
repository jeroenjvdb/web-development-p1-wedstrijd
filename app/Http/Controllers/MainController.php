<?php

namespace App\Http\Controllers;

use App\User;
use App\Competitor;
use App\Vote;
use App\Winner;
use Input;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;

class MainController extends Controller
{
    public function home()
    {
        $winners = Winner::all();

        // var_dump(empty($winners));
        if($winners->first())
        {
            echo 'test';
        } else
        {
            echo 'leeg';
        }
        foreach($winners as $winner)
        {
            // var_dump($winner);
        }

        // var_dump($winners);

        $data = array('winners' => $winners);


        return View('welcome')->with($data);
    }

    public function competition()
    {
    	$users = User::all();
    	$competitors = Competitor::all();
    	$data = ['competitors' => $competitors];
    	
    	return View('competition.competition')->with($data);

    }

    public function postCompetition(Request $request)
    {
    	//check if image is valid
    	if( $request->file('duvel')->isValid() )
    	{

    		$destinationPath = "img/competition/";
    		$extension = $request->file('duvel')->getClientOriginalExtension();
    		$fileName = rand(11111,99999).'.'.$extension; // renameing image
            //fullpath = path to picture + filename + extension
    		$fullPath = $destinationPath . $fileName;	

            $pic = $request->file('duvel');

            //make a thumbnail for the same pic
            $picSize = getimagesize($pic);
            $width = $picSize[0];
            $height = $picSize[1];
            $newHeight = 100;
            //change the width depending on the height of the pic
            $newWidth = $newHeight * ($width/$height);
            $image = imagecreatefromjpeg($pic);
            $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
            //make the pic ($image) smaller and move it to $thumbnail
            $newImage = imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            var_dump($thumbnail);
            //the path where to put the thumbnail
            $thumbnailPath = $destinationPath . 'thumbnail/' . $fileName;
            imagejpeg($thumbnail, $thumbnailPath);
            // uploading file to given path
            $pic->move($destinationPath , $fileName); 
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
        //check if there is no vote for this particular competitor on current ip adress
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

    public function unVote($id, Request $request)
    {
        $votes = Competitor::findOrFail($id)->votes;
        foreach($votes as $vote)
        {
            if($vote->ip == $request->getClientIp())
            {
                $vote->delete();
            }
        }
    }

    public function otherCompetitors(Request $request)
    {
        $competitors = Competitor::all();
        foreach ($competitors as $competitor) {
            $competitor->voted = false;
            foreach ($competitor->votes as $vote) {
                //check if you already have voted for this competitor
                if($vote->ip == $request->getClientIp())
                {
                    $competitor->voted = true;
                }
            }
        }

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

    public function exportAll()
    {
        $table = Competitor::all();
        $user = User::first();
        $makeKeys = $table;
        $output= "";
        $keyArray = [];
        foreach ($makeKeys->first()->toArray() as $key => $value) {
            // var_dump( $key );
                array_push($keyArray, $key);
            
        }
        // var_dump($table->first()->user->toArray());
        foreach ($user->toArray() as $key => $value) {
            if($key !== 'id')
            {
                array_push($keyArray, $key);
            }
        }
        // var_dump($table . '</br>');
        // var_dump($makeKeys);
        // var_dump( $keyArray );
        $output .= implode(",", $keyArray) ."\n";
        foreach ($table as $row) {
            // var_dump($row);echo'</br>';
            $output.=  implode(",",$row->toArray()); 
            $output.= implode(",",$row->user->toArray()) . "\n";
        }
        // echo $output;
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="ExportFileName.csv"',
        );

        return Response::make(rtrim($output, "\n"), 200, $headers);
    }
}

