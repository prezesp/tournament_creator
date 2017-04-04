<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Comment;
use App\Tournament;

class CommentController extends Controller
{
    public function store(Request $request)
    {
      $comment = new Comment;
      $comment->message = $request->input('message');
      $comment->tournament()->associate($request->input('tournament_id'));

      // Autor komentarza
      if (!empty(Auth::user()))
      {
        $comment->user()->associate(Auth::user());
      }
      else
      {
        $comment->name = $request->input('name');
      }
      $comment->save();

      if($request->ajax())
      {
        $tournament = Tournament::find($request->input('tournament_id'));
        $comments = $tournament->comments()->orderBy('id', 'desc')->paginate(10);
        $comments->withPath('?comments');
        return view('tournament.modules.comments', ['tournament' => $tournament, 'comments' => $comments]);
      }

      return "OK";
    }
}
