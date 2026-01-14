<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;


class CacheController extends Controller
{
<<<<<<< HEAD
    public function clear()
=======
    public function clear(): RedirectResponse
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
    {
      Artisan::call('cache:clear');
      Artisan::call('config:clear');
      Artisan::call('route:clear');
      Artisan::call('view:clear');

<<<<<<< HEAD
      return "Clear";
=======
      return back();
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
    }


}
