<?php

namespace Pterodactyl\Http\Controllers\Base;

use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Contracts\Repository\ServerRepositoryInterface;
use Pterodactyl\Models\Billing\BillingSettings;
use Illuminate\Support\Facades\Auth;


class IndexController extends Controller
{
    /**
     * @var \Pterodactyl\Contracts\Repository\ServerRepositoryInterface
     */
    protected $repository;

    /**
     * IndexController constructor.
     */
    public function __construct(ServerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns listing of user's servers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::guest()){
                    if (config('billing.portal') == "true") {
                        return redirect('/portal');
                    } else {
                     return redirect('/auth/login');   
                    }
          
        }
        return view('templates/base.core', ['settings' => BillingSettings::getAll()]);
    }
}
