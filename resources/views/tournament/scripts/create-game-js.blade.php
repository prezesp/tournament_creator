<?php
  // Parametryzowany przez blade skrypt do tworzenia nowej gry.
  //
  // - token odczytywany wprost z formularza
  // - z aplikacji odczytywany jest url do ścieżki game.store
  // - obiekt $settings określa widok i sekcję, która zostanie zwrócona
  // - obiekt $group to grupa do której zostanie przypisana nowa gra
?>

<script>
$(function () {
  // Dodanie
  $( 'form[class="form-horizontal add-team"]' ).on( 'submit', function(e) {
    e.preventDefault();

    // wyświetlenie progresu
    $('.progress', this).css('display', 'block');

    // pola do zapytania
    var data = {
      _method     : "POST",
      _token      : $('input[name=_token]', this).val(),
      _view       : '{{ $settings->view }}',
      _section    : '{{ $settings->section }}',
      group_id    : '{{ $group->id }}'
    };

    var that = this;

    // zapytanie
    $.ajax({
      type: "POST",
      url: "{{ route('game.store') }}",
      data: data,
      success: function(response) {
        $('.tournament-content').html(response);
        $('.progress', that).css('display', 'none');
      },
      error: function() {
        alert('Unauthorized access!');
        window.location.replace("{{ route('login') }}");
      }
    });
  });
});
</script>
