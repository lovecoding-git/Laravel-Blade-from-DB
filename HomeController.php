<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Blade;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class HomeController extends Controller
{
	public function index()
    {

        $blade = 'Hello, {{$plant}}'; // saved blade data from db.
        $php = Blade::compileString($blade);

        $__data['plant'] = 'World!';
        $__data['__env'] = app(\Illuminate\View\Factory::class);
		
        $component =  $this->render($php, $__data); //html data-> Hello, World!

        return view('home', compact('component')); // We can pass this component and use.
    }
	function render($__php, $__data)
    {
        $obLevel = ob_get_level();
        ob_start();
        extract($__data, EXTR_SKIP);
        try {
            eval('?' . '>' . $__php);
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw $e;
        } catch (Throwable $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw new FatalThrowableError($e);
        }
        return ob_get_clean();
    }
}
	