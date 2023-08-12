<?php

namespace Pterodactyl\Http\Controllers\Admin\Theme;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;

class ColorController extends Controller
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

        return view('admin.theme.color', ['theme' => $theme]);
    }

    public function update(Request $request)
    {
        $existing = DB::table('theme')->first();
        DB::table('theme')->where('id', $existing->id)->update([
            'highlightcolor' => $request->highlightcolor,
            'lightcolor' => $request->lightcolor,
            'color' => $request->color,
            'subcolor' => $request->subcolor,
            'color4' => $request->color4,
            'color5' => $request->color5,
            'color6' => $request->color6,
            'dark' => $request->dark,
            'primary' => $request->primary,
            'primaryhover' => $request->primaryhover,
            'secondary' => $request->secondary,
            'secondaryhover' => $request->secondaryhover,
            'background' => $request->background,
            'lhighlightcolor' => $request->lhighlightcolor,
            'llightcolor' => $request->llightcolor,
            'lcolor' => $request->lcolor,
            'lsubcolor' => $request->lsubcolor,
            'lcolor4' => $request->lcolor4,
            'lcolor5' => $request->lcolor5,
            'lcolor6' => $request->lcolor6,
            'ldark' => $request->ldark,
            'lprimary' => $request->lprimary,
            'lprimaryhover' => $request->lprimaryhover,
            'lsecondary' => $request->lsecondary,
            'lsecondaryhover' => $request->lsecondaryhover,
            'lbackground' => $request->lbackground,
            'updated_at' => \Carbon::now(),
        ]);

        $this->alert->success('Theme settings have been updated successfully.')->flash();
        return redirect()->back();
    }
}
