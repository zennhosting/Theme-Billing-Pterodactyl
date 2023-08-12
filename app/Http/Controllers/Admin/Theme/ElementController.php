<?php

namespace Pterodactyl\Http\Controllers\Admin\Theme;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;

class ElementController extends Controller
{
    /**
     * @var \Prologue\Alerts\AlertsMessageBag
     */
    private $alert;

    public function __construct(
        AlertsMessageBag $alert
    ) {
        $this->alert = $alert;
    }

    public function index()
    {
        $theme = DB::table('theme')->first();

        return view('admin.theme.element', ['theme' => $theme]);
    }

    public function update(Request $request)
    {
        $existing = DB::table('theme')->first();
        DB::table('theme')->where('id', $existing->id)->update([
            'subnavigation' => $request->subnavigation,
            'graphcard' => $request->graphcard,
            'sidegraph' => $request->sidegraph,
            'infoelement' => $request->infoelement,
            'newserverlist' => $request->newserverlist,
            'updated_at' => \Carbon::now(),
        ]);

        $this->alert->success('Theme settings have been updated successfully.')->flash();
        return redirect()->back();
    }
}
