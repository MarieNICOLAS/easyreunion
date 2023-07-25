<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Models\SpaceAction;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function addElement(Request $request, Space $space)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $this->authorize('create', [SpaceAction::class, $space]);

        SpaceAction::create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
            'space_id' => $space->id
        ]);

        return redirect()->back()->with(['success' => 'Action créée !']);
    }

    public function addElementUser(Request $request)
    {
        $space = Space::findOrFail($request->input('space'));

        return $this->addElement($request, $space);
    }

    public function toggleCompleted(Request $request, SpaceAction $spaceAction)
    {
        $this->authorize('update', $spaceAction);

        $spaceAction->resolved = !$spaceAction->resolved;
        $spaceAction->update();

        return redirect()->back()->with(['success' => 'Mise à jour effectuée']);
    }
}
