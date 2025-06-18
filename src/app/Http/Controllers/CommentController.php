<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $item_id)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'item_id' => $item_id,
            'content' => $request->content,
        ]);

        return redirect()->route('item.detail', $item_id)->with('message', 'コメントを投稿しました');
    }
}