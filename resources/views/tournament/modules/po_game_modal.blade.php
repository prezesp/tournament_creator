<div class="modal fade" tabindex="-1" role="dialog" id="modal_{{$game->id}}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      {{ Form::open(array('method' => 'PUT', 'route' => ['game.update', $game->id], 'class' => 'form-horizontal')) }}
        <input name="game_id" type="hidden" value="{{$game->id}}"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit game<h4>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-striped table-condensed table-hover">
              <tr>
                <td class="col-xs-8">
                  @if (!$only_score)
                    {{ Form::select('home_seed', $teams, $game->home_seed, array('class' => 'form-control')) }}
                  @else
                    <p class="form-control-static">{{ $game->home->name }}</p>
                  @endif
                </td>
                <td class="col-xs-4 text-right">{{ Form::number('home_score',$game->home_score, array('class' => 'form-control', 'min' => -1)) }}</td>
              </tr>
              <tr>
                <td class="col-xs-8">
                  @if (!$only_score)
                    {{ Form::select('away_seed', $teams, $game->away_seed, array('class' => 'form-control')) }}
                  @else
                    <p class="form-control-static">{{ $game->away->name }}</p>
                  @endif
                </td>
                <td class="col-xs-4 text-right">{{ Form::number('away_score',$game->away_score, array('class' => 'form-control', 'min' => -1)) }}</td>
              </tr>
              <tr>
                <td class="col-xs-8 text-right">
                  <p class="form-control-static"><i class="fa fa-clock-o" aria-hidden="true"></i></p>
                </td>
                <td class="col-xs-4 text-right">{{ Form::text('game_time', empty($game->game_time) ? '00:00' : $game->game_time , array('class' => 'form-control')) }}</td>
              </tr>
            </table>
          </div>
          <div class="progress" style="display:none;">
            <div class="progress-bar progress-bar-striped active" role="progressbar" style="width: 100%">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          {{ Form::submit('Save changes', array('class' => 'btn btn-primary')) }}
        </div>
      {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
