<div class="panel-body">
  <div class="row">
    <div class="col-sm-12">
      {{ Form::open(array('route' => 'comment.store', 'class' => 'form-horizontal add-comment', 'data-toggle' => 'validator' )) }}
      <input name="tournament_id" type="hidden" value="{{ $tournament->id }}"/>
      @if (!Auth::check())
        <div class="form-group" style="display:none">
          <div class="col-sm-6">
            {{ Form::text('name', '', array('class' => 'form-control', 'placeholder' => trans('comments.name'), 'required')) }}
          </div>
        </div>
      @endif
      <div class="form-group">
        <div class="col-sm-12">
          {{ Form::textarea('message', '', array('class' => 'form-control', 'placeholder' => trans('comments.leave_a_comment'), 'rows' => 3, 'required', 'maxlength' => '255')) }}
        </div>
      </div>
      <div class="form-group" style="display:none">
        <div class="col-sm-12">
          {!! app('captcha')->display($attributes = ['data-callback' => 'captcha_onclick']); !!}
          <input type="text" name="recaptcha" required value="" pattern="1" data-error="{{ trans('comments.prove_not_robot') }}" style="display: none">
          <div class="help-block with-errors"></div>
        </div>
      </div>
      <div class="progress" style="display:none;">
        <div class="progress-bar progress-bar-striped active" role="progressbar" style="width: 100%">
        </div>
      </div>
      <div class="form-group" style="display:none">
        <div class="col-sm-8">
          <button type="button" class="btn btn-default">{{ trans('comments.cancel') }}</button>
          {{ Form::submit(trans('comments.post'), array('class' => 'btn btn-primary')) }}
        </div>
      </div>
      <hr/>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      @if ($comments->isEmpty())
        <em> No comments </em>
      @endif
      @foreach ($comments as $comment)
        <div class="list-group">
          <div class="row">
            <div class="col-sm-8">
              <h4 class="list-group-item-heading">
                @if (empty($comment->user))
                  <em>{{ $comment->name }}</em> <!--i class="fa fa-user-times" aria-hidden="true" title="Unregistered user"></i-->
                @else
                  {{ $comment->user->name }} <i class="fa fa-user" aria-hidden="true"></i>
                @endif
              </h4>
            </div>
            <div class="col-sm-4 text-right">
              {{ $comment->created_at }} {{-- ->timezone(Auth::user()->timezone) --}}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <p class="list-group-item-text text-justify">{{ $comment->message }}</p>
            </div>
          </div>
        </div>
      @endforeach

      <div class="text-center">{!! $comments->render() !!}</div>
    </div>
  </div>
</div>
@include('tournament.scripts.post-comment-js')

<script>
$( document ).ready(function() {
  $('form textarea[name=message]').on('focus', function() {
    $(this).closest('form').find('.form-group').css('display', 'block');
  });
  $('form button[type=button]').on('click', function() {
    $(this).closest('form').find('.form-group').css('display', 'none');
    $(this).closest('form').find('textarea[name=message]').closest('.form-group').css('display', 'block');
    $(this).closest('form')[0].reset();
    $(this).closest('form').validator('destroy').validator()
    //$("form").bootstrapValidator('resetForm', true);
  });
});

function captcha_onclick(e) {
  console.log(e);
  $('form textarea[name=message]').closest('form').find('input[name=recaptcha]').val(1);
  $('form textarea[name=message]').closest('form').validator('validate');
}
</script>
