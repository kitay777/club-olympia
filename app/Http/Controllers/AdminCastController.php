<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCastController extends Controller
{
    //
    public function updateStars(Request $request, Cast $cast)
    {
        $request->validate([
            'stars' => 'required|integer|min:0|max:5',
        ]);

        $cast->update([
            'stars' => $request->stars,
        ]);

        return back()->with('success', 'スターを更新しました');
    }
}
