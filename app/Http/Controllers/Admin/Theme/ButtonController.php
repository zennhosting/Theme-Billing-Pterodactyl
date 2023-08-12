<?php

namespace Pterodactyl\Http\Controllers\Admin\Theme;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;

class ButtonController extends Controller
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

        return view('admin.theme.button', ['theme' => $theme]);
    }

    public function update(Request $request)
    {
        $existing = DB::table('theme')->first();
        DB::table('theme')->where('id', $existing->id)->update([
            'textbutton' => $request->textbutton,
            'textbuttonhover' => $request->textbuttonhover,
            'dangerbutton' => $request->dangerbutton,
            'dangerbuttonhover' => $request->dangerbuttonhover,
            'ltextbutton' => $request->ltextbutton,
            'ltextbuttonhover' => $request->ltextbuttonhover,
            'ldangerbutton' => $request->ldangerbutton,
            'ldangerbuttonhover' => $request->ldangerbuttonhover,
            'primary' => $request->primary,
            'primaryhover' => $request->primaryhover,
            'lprimary' => $request->lprimary,
            'lprimaryhover' => $request->lprimaryhover,
            'borderradius' => $request->borderradius,
            'input' => $request->input,
            'linput' => $request->linput,
            'updated_at' => \Carbon::now(),
        ]);

        $this->alert->success('Theme settings have been updated successfully.')->flash();
        return redirect()->back();
    }
}
