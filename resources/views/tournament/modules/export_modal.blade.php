<div class="modal fade" tabindex="-1" role="dialog" id="export_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ trans('tournament.export_options') }}<h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-3 col-xs-6 text-right">
            <a href="{{ route('tournament.export', ['tournament' => $tournament->id, 'type' => 'txt']) }}" class="btn btn-default" target="_blank"><i class="fa fa-file-text-o"></i> {{ trans('tournament.export_to') }} .txt</a>
          </div>
          <div class="col-sm-3 col-xs-6 text-left">
            <div class="dropdown">
              <button class="btn btn-default" type="button" data-toggle="dropdown"><i class="fa fa-table"></i> {{ trans('tournament.export_to') }} .csv</button>
              <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <li><a href="{{ route('tournament.export', ['tournament' => $tournament->id, 'type' => 'csv-games']) }}" target="_blank">{{ trans('tournament.games') }}</a></li>
                @if ($tournament->type != 'P')
                  <li><a href="{{ route('tournament.export', ['tournament' => $tournament->id, 'type' => 'csv-groups']) }}" target="_blank">{{ trans('tournament.group_standings') }}</a></li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('common.close') }}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
