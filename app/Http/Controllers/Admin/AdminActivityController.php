<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminActivityController extends Controller
{
    public function createActivityView(Request $request)
    {
        return view('admin.addactivity');
    }

    public function createActivity(Request $request)
    {
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
