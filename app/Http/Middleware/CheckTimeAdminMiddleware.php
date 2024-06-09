<?php

namespace App\Http\Middleware;

use App\Models\Food_purchase;
use App\Models\User;
use App\Models\UserDog;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTimeAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $foods = Food_purchase::where('is_consumed', false)->get();

        foreach ($foods as $food) {
            if (!is_null($food->food)) {
                $expirationTime = Carbon::parse($food->purchased_at)->addMinutes($food->food->duration_hours * 60);

                if (Carbon::now()->greaterThan($expirationTime)) {
                    $user = User::find($food->user_id);
                    if ($user) {
                        $dog = UserDog::where('user_id', $user->id)->first();
                        if ($dog) {
                            $dog->health_level -= 1;
                            $dog->hunger_level -= 1;
                            $dog->save();
                        }

                        $user->balance += $food->food->price * $food->food->income_price;
                        $user->save();
                    }
                    $food->delete();
                }
            }
        }

        return $next($request);
    }
}
