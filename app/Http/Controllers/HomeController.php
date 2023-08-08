<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Osiset\ShopifyApp\Traits\HomeController as HomeControllerTrait;
use App\Models\User;

class HomeController extends Controller
{
    use HomeControllerTrait;

    /**
     * Index route which displays the home page of the app.
     *
     * @param Request $request The request object.
     *
     * @return @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
      $user = User::where('name', $request->shop)->first();
      return View::make(
          'shopify-app::home.index',
          [
              'path' => $request->path(),
              'query' => $request->query(),
              'host' => $request->host,
              'shop' => $request->shop,
              'user' => $user,
          ],
      );
    }
}
