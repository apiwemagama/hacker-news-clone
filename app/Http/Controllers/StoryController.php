<?php

namespace App\Http\Controllers;

use App\Models\Story;

class StoryController extends Controller
{
    public function index($type = 'top')
    {
        $validTypes = ['top', 'new', 'best'];
        
        if (!in_array($type, $validTypes)) {
            abort(404, 'Invalid story type');
        }

        $stories = Story::withCount('comments')
            ->where('type', $type)
            ->orderBy('score', 'desc')
            ->paginate(30);

        return view('stories.index', [
            'stories' => $stories,
            'type' => $type
        ]);
    }

    public function show($id)
    {
        $story = Story::with(['comments' => function($query) {
                $query->whereNull('parent_id')->with('replies');
            }])
            ->findOrFail($id);

        return view('stories.show', [
            'story' => $story,
            'type' => $story->type
        ]);
    }
}