<?php
  // Parametryzowany przez blade skrypt do dodawania komentarza.
  //
  // - token i pola odczytywane wprost z formularza
  // - z aplikacji odczytywany jest url do ścieżki comment.store
  // - obiekt $tournament to turniej do ktorego zostanie przypisany komentarz
?>

<script>
$(function () {
  // Dodanie
  $( 'form[class="form-horizontal add-comment"]' ).on( 'submit', function(e) {
    // sprawdzenie błędów
    if ($(this).validator('validate').has('.has-error').length == 0) {
      e.preventDefault();

      // wyświetlenie progresu
      $('.progress', this).css('display', 'block');

      // pola do zapytania
      var data = {
        _method     : "POST",
        _token      : $('input[name=_token]', this).val(),
        message     : $('textarea[name=message]', this).val(),
        name        : $('input[name=name]', this).val(),
        tournament_id : '{{ $tournament->id }}'
      };

      var that = this;

      // zapytanie
      $.ajax({
        type: "POST",
        url: "{{ route('comment.store') }}",
        data: data,
        success: function(response) {
          $('.tournament-content').html(response);
          $('.progress', that).css('display', 'none');
        }
      });
    }
  });
});
</script>
