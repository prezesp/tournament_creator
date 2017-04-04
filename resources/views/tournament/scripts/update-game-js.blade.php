<?php
  // Parametryzowany przez blade skrypt do aktualizowania gry.
  //
  // - token i id gry odczytywane są wprost z formularza
  // - z aplikacji odczytywany jest url do ścieżki game.update
  // - obiekt $settings określa widok i sekcję, która zostanie zwrócona,
  //   oraz informację, czy skrypt ma aktualizować drużyny biorące udział
?>

<script>
$(function () {
  $( '*[id^="modal_"] form' ).on( 'submit', function(e) {
    e.preventDefault();

    // zablokowanie formularza
    $(' input', this).prop('readonly', true);
    $(' select', this).prop('disabled', true);

    // wyświetlenie progresu
    $('.progress', this).css('display', 'block');

    // pobranie pól formularza
    var id = $('input[name=game_id]', this).val();
    var data = {
      _method     : "PUT",
      _token      : $('input[name=_token]', this).val(),
      @if (empty($settings->only_score))
        home_id     : $('select[name=home_id]', this).val(),
        away_id     : $('select[name=away_id]', this).val(),
      @endif
      home_score  : $('input[name=home_score]', this).val(),
      away_score  : $('input[name=away_score]', this).val(),
      game_time   : $('input[name=game_time]', this).val(),
      _view       : '{{ $settings->view }}',
      _section    : '{{ $settings->section }}'
    };

    var that = this;

    // zapytanie
    $.ajax({
      type: "POST",
      url: "{{ route('game.update', '') }}" + "/" + id,
      data: data,
      success: function(response) {
        $('div[class="modal-backdrop fade in"]').animate(
          {
            opacity: 0
          },
          220,
          function() {
            // ręczne zamknięcie modala i aktualizacja treści
            $('body').removeClass('modal-open');
            $('.progress', that).css('display', 'none');
            $('.tournament-content').html(response);
            this.remove();
          }
        );
      },
      error: function() {
        alert('Unauthorized access!');
        window.location.replace("{{ route('login') }}");
      }
    });
  });
});
</script>
