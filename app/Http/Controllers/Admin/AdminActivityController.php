<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminActivityController extends Controller
{
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

        if ($request->has('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $request->image->extension();
            $image->move(public_path('uploads'), $filename);

            $image = $filename;
        }
        $expense = Activity::create([
            'title' => $request->title,
            'description' => $request->description,
            'activity_date' => $request->activity_date,
            'image' => isset($image) ? $image : '',
        ]);

        $expense->save();
        return redirect()->route('admin.dashboard')->with('status', 'Activity added Successfully!');
    }

    public function editActivityView(Request $request)
    {
        return view('admin.editactivity');
    }

    public function editActivity(Request $request)
    {
        dd($request->all());
        $activity = Activity::create($request->all());
        return $activity;
        //return response()->json($activity, Response::HTTP_CREATED);
    }

    public function getAllActivities()
    {
        $activities = Activity::all();
        if ($activities->count() > 0) {
            $activities->load('user_activity');
            return view('admin.dashboard', compact('activities'));
            //return $activities->load('user_activity');
            //return response()->json($activity);
        } else {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'success', 'message' => 'No Activity found']);
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

    public function destroy($id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'error', 'message' => 'activity does not exist']);
        } else {
            $activity->delete();
            return response()->json(['status_code' => Response::HTTP_NO_CONTENT, 'status' => 'success', 'message' => 'activity deleted']);
        }

    }


}
