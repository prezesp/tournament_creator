<?php
  // Parametryzowany przez blade skrypt do usuwania gry.
  //
  // - token odczytywany wprost z formularza
  // - z aplikacji odczytywany jest url do ścieżki game.destroy
  // - obiekt $settings określa widok i sekcję, która zostanie zwrócona
?>

<script>
$(function () {
  // Usunięcie
  $( '*[id^="modal_"] form button[data-action=remove]' ).on( 'click', function(e) {
    e.preventDefault();
    var form = $(this).closest('form');
    var id = $('input[name=game_id]', form).val();

    // wyświetlenie progresu
    $('.progress', form).css('display', 'block');


    var data = {
      _method     : "DELETE",
      _token      : $('input[name=_token]', form).val(),
      _view       : '{{ $settings->view }}',
      _section    : '{{ $settings->section }}'
    };

    $.ajax({
      type: "POST",
      url: "{{ route('game.destroy', '') }}" + "/" + id,
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
            $('.progress', form).css('display', 'none');
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
