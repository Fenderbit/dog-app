<?php

namespace App\Http\Middleware;

use App\Models\Food_purchase;
use App\Models\UserDog;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTimeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $foods = Food_purchase::where('user_id', $user->id)->where('is_consumed', false)->get();

        foreach ($foods as $food) {
            if(!is_null($food->food)){
                $expirationTime = Carbon::parse($food->purchased_at)->addMinutes($food->food->duration_hours);

                if (Carbon::now()->greaterThan($expirationTime)) {
                    $dog = UserDog::where('user_id', $user->id)->first();
                    $dog->health_level -= 1;
                    $dog->hunger_level -= 1;
                    $user->balance += $food->food->price * $food->food->income_price;
                    $user->save();
                    $dog->save();
                    $food->delete();
                }
            }
        }

        return $next($request);
    }
}
