<?php

namespace App\Http\Controllers\API;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Contracts\Database\Query\Builder;
//use Illuminate\Contracts\Database\Eloquent\Builder;

class UserActivityController extends Controller
{
    public function __invoke(Request $request){
        $activities = QueryBuilder::for(Activity::class)

            ->whereHas('user_activity', function (Builder $query) {
                $query->where('user_id', '=', auth()->user()->id);
            })->orWhere('scope', 'global')
            ->with([
                    'user_activity' => function (Builder $query) {
                        $query->where('user_id', '=', auth()->user()->id);
                    }
                ])->allowedFilters([
                    AllowedFilter::scope('from'),AllowedFilter::scope('to')
                ])
                ->get();



        if ($activities->count() > 0) {
            $userActivities= [];
            foreach($activities as $activity){
                if($activity->user_activity->count() > 0){
                    $activity->title = $activity->user_activity[0]->title;
                    $activity->image = $activity->user_activity[0]->image;
                    $activity->description = $activity->user_activity[0]->description;
                    $activity->user_activity = [];
                    //dd($activity->title);
                }
                array_push($userActivities,$activity);
            }

            return response()->json($userActivities);
        } else {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'success', 'message' => 'No Activity found']);
        }
    }
}
