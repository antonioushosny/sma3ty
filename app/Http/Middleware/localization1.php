<?php
namespace App\Http\Middleware;
use Closure, Session, Auth;
class localization1
{

  protected $languages = ['en','ar'];
  /**
  * Handle an incoming request.
  *
  * @param \Illuminate\Http\Request $request
  * @param \Closure $next
  * @return mixed
  */

  public function handle($request, Closure $next)
  {
    if (!empty(session('lang'))) {
      $lang = session('lang');
      app()->setLocale($lang);
    }
    return $next($request);
  }

  public function __construct () {
    $lang = Session::get('lang');
    if ($lang != null) \App::setLocale($lang);
}
}
