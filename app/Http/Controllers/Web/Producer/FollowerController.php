<?php

namespace App\Http\Controllers\Web\Producer;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\User;

class FollowerController extends Controller
{

    /**
     * Follow user store
     * @param $followed User id
     * @return view
     */
    public function FollowUser($follow_id)
    {
        $exist = Follower::where('follower_id', auth()->user()->id)->where('user_id', $follow_id)->first();

        if ($exist) {
            $exist->delete();
            return response()->json([
                'success' => false,
                'message' => 'Unfollowed Producer.',
            ]);
        }

        $follower = new Follower();
        $follower->user_id = $follow_id;
        $follower->follower_id = auth()->user()->id;
        $follower->save();

        return response()->json([
            'success' => true,
            'message' => 'Followed Producer successfully.',
        ]);
    }

    /**
     * Unfollow User
     * @param $id
     * @return Response
     */
    public function UnFollowUser($id)
    {

        $exist = Follower::where('follower_id', auth()->user()->id)->where('user_id', $id)->first();
        if ($exist) {
            $exist->delete();
            return response()->json([
                'success' => true,
                'message' => 'User unfollowed successfully.',
            ]);
        } else {
            $follower = new Follower();
            $follower->user_id = $id;
            $follower->follower_id = auth()->user()->id;
            $follower->save();

            return response()->json([
                'success' => true,
                'message' => 'Followed Producer successfully.',
            ]);
        }

    }
}
