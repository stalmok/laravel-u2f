<?php namespace Certly\U2f\Http\Middleware;

use Closure;
use Certly\U2f\U2f as LaravelU2f;
use Certly\U2f\Models\U2fKey;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Config\Repository as Config;

/**
 * Class U2f
 *
 *
 *
 * @package Certly\U2f\Http\Middleware
 * @author  LAHAXE Arnaud
 */
class U2f
{

    /**
     * @var LaravelU2f
     */
    protected $u2f;

    /**
     * @var Config
     */
    protected  $config;

    public function __construct(LaravelU2f $u2f, Config $config)
    {
        $this->u2f = $u2f;
        $this->config = $config;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->config->get('u2f.enable')) {
            return $next($request);
        }

        if (!$this->u2f->check()) {
            if(!\Auth::guest()){
                if(
                    U2fKey::where('user_id', '=', \Auth::user()->id)->count()  === 0
                    && $this->config->get('u2f.byPassUserWithoutKey')
                ) {
                    return $next($request);
                } else {
                    return redirect()->guest('u2f/auth');
                }

            } else {
                throw new HttpException(401, 'You need to log in before an u2f authentication');
            }
        }

        return $next($request);
    }
}
