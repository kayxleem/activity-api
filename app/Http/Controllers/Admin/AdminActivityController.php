<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class AdminActivityController extends Controller
{
    public function getAllActivities()
    {
        $activities = Activity::all();
        if ($activities->count() > 0) {
            $activities->load('user_activity');
            return view('admin.dashboard', compact('activities'));
            //return $activities->load('user_activity');
            //return response()->json($activity);
        } else {
            $activities=null;
            return view('admin.dashboard', compact('activities'));
        }
    }
    public function addActivityView(Request $request)
    {
        return view('admin.addactivity');
    }

    public function addActivity(Request $request)
    {
        //dd($request->all());
        $activittField = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'activity_date' => 'required',
            'image' => 'required',
        ]);
        //check if daily activity not exceeded
        $dayActivities = Activity::where('activity_date', 'LIKE', '%' . Carbon::parse($request->activity_date)->toDateString() . '%')
        ->where('scope', 'global')->count();

        if($dayActivities >=4){
            return redirect()->route('admin.dashboard')->with('error', 'Activity for day is already at maximum amount (4)');
        }
        if ($request->has('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $request->image->extension();
            $image->move(public_path('uploads'), $filename);

            $image = config('app.url').'/uploads/'.$filename;
        }
        $activity = Activity::create([
            'title' => $request->title,
            'description' => $request->description,
            'activity_date' => $request->activity_date,
            'image' => isset($image) ? $image : '',
        ]);

        $activity->save();
        return redirect()->route('admin.dashboard')->with('status', 'Activity added Successfully!');
    }

    public function editActivityView(Request $request, $id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return redirect()->route('admin.dashboard')->with('status', 'Activity does not exist');
        } else {
            $activity->load('user_activity');
            return view('admin.editactivity', compact('activity'));
        }
    }

    public function editActivity(Request $request, $id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return redirect()->route('admin.dashboard')->with('status', 'Activity does not exist');
        } else {
            $activity->update($request->all());
            return view('admin.editactivity', compact('activity'))->with('status', 'Activity Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return redirect()->route('admin.dashboard')->with('status', 'Activity does not exist');
        } else {
            $activity->delete();
            return redirect()->route('admin.dashboard')->with('status', 'Activity deleted');
        }

    }



    public function showActivity(Request $request, $id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'error', 'message' => 'Activity does not exist']);
        } else {
            return $activity;
            //return response()->json($activity, Response::HTTP_OK);
        }
    }

    public function update(Request $request, $id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'error', 'message' => 'activity does not exist']);
        } else {
            $activity->update($request->all());
            return response()->json($activity,201);
        }

    }

    public function editUserActivity(Request $request, $id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'error', 'message' => 'activity does not exist']);
        } else {
            $activity->update($request->all());
            return response()->json($activity,201);
        }

    }


}
