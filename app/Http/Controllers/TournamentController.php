<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Tournament;
use App\Group;
use App\Team;
use App\User;


class TournamentController extends Controller
{

    public function index()
    {
        $tournaments = Tournament::where('is_private', false)->orderBy('id', 'desc')->paginate(10);
        return view('tournament.index', ['tournaments' => $tournaments]);
    }

    public function show($tournamentId)
    {
        $tournament = Tournament::find($tournamentId);
        $comments = $tournament->comments()->orderBy('id', 'desc')->paginate(10);
        $comments->withPath('?comments');
        return view('tournament.show', ['tournament' => $tournament, 'comments' => $comments]);
    }

    public function create()
    {
      if (Auth::check())
      {
        return view('tournament/create');
      }
      else
      {
        return redirect('/');
      }
    }

    public function destroy($tournamentId, Request $request)
    {
      if (Auth::check())
      {
        $tournament = Tournament::find($tournamentId);
        $tournament->delete();

        $message = 'Tournament have been deleted.';
        $request->session()->flash('message', $message);
      }
      return redirect('tournament');
    }

    public function store(Request $request)
    {
      if (Auth::check())
      {

        $gameGenController = app('App\Http\Controllers\GameGeneratorController');

        $groups = array();
        $group_count = intval($request->input('group_counter'));

        // przypisania do grup
        $group_indicator = array();
        $group_sizes = array();
        for($i=0; $i<count($request->input('teams')); $i++)
        {
          $nr = ($i+$group_count) % $group_count;
          if (!array_key_exists($nr, $group_sizes))
            $group_sizes[$nr] = 0;
          $group_sizes[$nr] += 1;

          array_push($group_indicator, ($i+$group_count) % $group_count);
        }
        sort($group_indicator);

        // utworzenie turnieju
        $tournament = new Tournament;
        $tournament->name = $request->input('name');
        $tournament->description = $request->input('description');
        $tournament->sport = $request->input('sport');
        $tournament->www = str_replace(array('http://', 'https://'), '', $request->input('webpage'));
        $tournament->date = $request->input('date');
        $tournament->is_private = empty($request->input('is_private')) ? false : $request->input('is_private');
        $tournament->type = $request->input('type');
        $tournament->seeds = $request->input('seeds');
        $tournament->win_pts = $request->input('win_pts');
        $tournament->draw_pts = $request->input('draw_pts');
        $tournament->loss_pts = $request->input('loss_pts');
        $tournament->user()->associate(Auth::user());
        $tournament->save();

        // utworzenie Group
        $last_team = 0;
        $gr = 'A';
        for($i=0; $i<$group_count; $i++)
        {
          $group = new Group;
          $group->name = $gr++;
          $tournament->groups()->save($group);

          // utworzenie teamów
          $teams = array();
          for($j=$last_team; $j<$last_team+$group_sizes[$i]; $j++)
          {
            $team = new Team;
            $team->name = $request->input('teams')[$j];
            array_push($teams, $team);
          }
          $last_team += count($teams);
          $group->teams()->saveMany($teams);

          // Wygenerowanie meczów dla każdej z grup
          $gameGenController->generateGroupGames($group);
        }
        $tournament->save();

        if (!in_array($tournament->type, array('L', 'DL')))
        {
          $gameGenController->generatePlayoffGames($tournament);
        }

        $message = 'Well done! Tournament have been created.';
        $request->session()->flash('message', $message);

        return redirect('tournament/'.$tournament->id);
      }
      else
      {
        return redirect('/');
      }
    }

    public function edit($tournamentId)
    {
      if (Auth::check())
      {
        $tournament = Tournament::find($tournamentId);
        return view('tournament.edit', ['tournament' => $tournament]);
      }
      else
      {
        return redirect('/');
      }
    }

    public function update($tournamentId, Request $request)
    {
      $tournament = Tournament::find($tournamentId);

      if (!empty($request->input('name')))
      {
        $tournament->name = $request->input('name');
      }
      $tournament->description = $request->input('description');
      $tournament->www = str_replace(array('http://', 'https://'), '', $request->input('webpage'));
      $tournament->is_private = empty($request->input('is_private')) ? false : $request->input('is_private');
      $tournament->date = $request->input('date');

      // tylko onwer może modyfikować moderatorów
      if ($tournament->user == Auth::user())
      {
        $moderators = explode(',', $request->input('moderators'));
        $tournament->moderators()->sync($moderators);
      }

      $tournament->save();

      $message = 'Well done! Tournament have been modified.';
      $request->session()->flash('message', $message);

      return redirect('tournament/'.$tournament->id);
    }

    public function search(Request $request)
    {
      $phrase = $request->input('phrase');
      $request->session()->forget('message');
      if (strlen($phrase) < 3)
      {
        $message = 'Too short phrase (min 3. chars)';
        $request->session()->flash('message', $message);
        return view('tournament.search', ['tournaments' => []]);
      }
      $tournaments = Tournament::where('name', 'like', '%'.$phrase.'%')->get();
      return view('tournament.search', ['tournaments' => $tournaments]);
    }
}
