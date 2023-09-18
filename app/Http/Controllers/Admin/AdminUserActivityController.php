<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
//use Illuminate\Database\Query\Builder;
use App\Http\Controllers\Controller;
//use Illuminate\Contracts\Database\Query\Builder;
use Spatie\QueryBuilder\QueryBuilder;
//use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;


class AdminUserActivityController extends Controller
{
    protected $user_id;

    public function getUserActivity(Request $request, $user_id)
    {
        $this->user_id = $user_id;
        $user = User::find($this->user_id);
        $activities = QueryBuilder::for(Activity::class)
            ->whereHas('user_activity', function (Builder $query) {
                $query->where('user_id', '=', $this->user_id);
            })->orWhere('scope', 'global')
            ->with([
                'user_activity' => function (Builder $query) {
                    $query->where('user_id', '=', $this->user_id);
                }
            ])->allowedFilters([
                    AllowedFilter::scope('from'),
                    AllowedFilter::scope('to')
                ])
            ->get();

            if ($activities->count() > 0) {
                $activities->load('user_activity');
                return view('admin.useractivity', compact('activities', 'user'));
                //return $activities->load('user_activity');
                //return response()->json($activity);
            } else {
                $activities=null;
                return view('admin.useractivity', compact('activities', 'user'));
            }
    }

    public function addUserActivityView(Request $request)
    {
        $users = User::all();
        return view('admin.adduseractivity', compact('users'));
    }

    public function addUserActivity(Request $request)
    {

        //check if daily activity not exceeded
        $dayActivities = Activity::where('activity_date', 'LIKE', '%' . Carbon::parse($request->activity_date)->toDateString() . '%')
            ->where('scope', 'global')->count();

        if ($dayActivities >= 4) {
            return redirect()->route('admin.dashboard')->with('error', 'Activity for day is already at maximum amount (4)');
        }
        if ($request->has('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $request->image->extension();
            $image->move(public_path('uploads'), $filename);

            $image = config('app.url') . '/uploads/' . $filename;
        }
        $activity = Activity::create([
            'title' => $request->title,
            'description' => $request->description,
            'activity_date' => $request->activity_date,
            'image' => isset($image) ? $image : '',
            'scope' => 'local',
        ]);
        $activity->save();

        $userActivity = UserActivity::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'activity_id' => $activity->id,
            'description' => $request->description,
            'image' => isset($image) ? $image : '',
        ]);

        $userActivity->save();
        return redirect()->route('admin.dashboard')->with('status', 'User Activity added Successfully!');
    }

    public function editUserActivityView(Request $request)
    {

        if(isset($request->user_activity_id)){
            $userActivity = UserActivity::find($request->user_activity_id);
        }
        if(isset($request->activity_id)){
            $activity = Activity::find($request->activity_id);
            $user = User::find($request->user_id);
            return view('admin.edituseractivity', compact('user','activity'));
        }else{
            return redirect()->route('admin.dashboard')->with('error', 'Invalid Activity');
        }
    }

    public function editUserActivity(Request $request)
    {
        $userActivity = UserActivity::where('activity_id',$request->activity_id)
        ->where('user_id',$request->user_id)->first();
        if ($request->has('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $request->image->extension();
            $image->move(public_path('uploads'), $filename);

            $image = config('app.url') . '/uploads/' . $filename;
        }
        if (!$userActivity->id) {
            $activity = Activity::find($request->activity_id);
            $userActivity = UserActivity::create([
                'user_id' => $request->user_id,
                'activity_id' => $request->activity_id,
                'title' => $request->title?? $activity->title,
                'description' => $request->description ?? $activity->description,
                'image' => $image ?? $activity->image
            ]);
            $userActivity->save();

        } else {
            $userActivity->update([
                'title' => $request->title ?? $userActivity->title,
                'description' => $request->description ?? $userActivity->description,
                'image' => $image ?? $userActivity->image,
            ]);

            $userActivity->save();

        }

        return redirect()->route('admin.dashboard')->with('status', 'User Activity Edited Successfully!');
    }
}
