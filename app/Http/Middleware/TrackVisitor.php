<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('/')) {
            $ipAddress = $request->ip();
            $currentDate = date('Y-m-d');

            // Check if a record exists for the same IP and date
            $existingVisitor = Visitor::where('ip_address', $ipAddress)
                ->where('visited_date', $currentDate)
                ->first();
            
            $ip = $request->ip();
            
            if (!$existingVisitor) {
                $visitor = new Visitor();
                $visitor->ip_address = $ip;
                $visitor->browser = $request->header('User-Agent');
                $visitor->is_visited = 1;
                $visitor->visited_date = today();
                $visitor->month = date('M');
                $visitor->year = date('Y');

                $visitor->save();
                
            }

           
        }

        return $next($request);
    }
}
