<?php

namespace App\Http\Controllers\API;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UserActivityController extends Controller
{
    public function __invoke(Request $request){
        $activity = QueryBuilder::for(Activity::class)

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



        if ($activity->count() > 0) {
            return response()->json($activity);
        } else {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'success', 'message' => 'No Activity found']);
        }
    }
}
