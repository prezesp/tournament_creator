//// INNE FUNKCJE
var shuffle = function (a) {
  var j, x, i;
  for (i = a.length; i; i--) {
    j = Math.floor(Math.random() * i);
    x = a[i - 1];
    a[i - 1] = a[j];
    a[j] = x;
  }
}

//// PLUGINY (ROZSZERZANIE PRZEZ JQUERY)
!function( $ ) {
  // MOD SEARCH
  $.fn.search = function(host, synchronize_input) {

    // obiekt do zarządzania przechowywanymi danymi
    var manager = {
      data      : {},
      add       : function(id, value) {
        this.data[id] = value;
        this.synchronize();
      },
      remove    : function(id) {
        delete this.data[id];
        this.synchronize();
      },
      contains  : function(id) {
        return id in this.data;
      },
      synchronize: function() {
        if (synchronize_input != undefined) {
          synchronize_input.val(Object.keys(this.data));
        }
      }
    };

    // znalezienie kontrolek
    var mod_input   = $(this).find('input').first();
    var mod_button  = $(this).find('button[class="btn btn-primary btn-sm"]').first();
    var mod_dropdown= $(this).find('ul[class=dropdown-menu]').first();
    var mod_results = $(this).find('ul[class=list-group]').first();


    // wybór pozycji z listy rozwijalnej
    var list_position_click = function (e) {
        var li = $( e.currentTarget );

        mod_input.val(li.text());
        mod_input.attr('data-index', li.attr('data-index'));
        mod_dropdown.parent().removeClass('open');

        return false;
     };

     // dodanie itemu do listy wyników
     var add_item = function (id, value) {
       // sprawdzenie czy pole nie jest puste i czy manager nie zawiera już rekordu
       if (value.length > 0
          && !manager.contains(id)
          && id != undefined)
       {
         // dodanie do danych
         manager.add(id, value);

         // dodanie do gui
         var result_delete_button = $('<a/>', {
           'class':'icon',
           html: '<i class="fa fa-remove"></i>',
           'click' : function() {
             manager.remove(id);
             result_delete_button.parent().remove();
           }
         });

         var result_item = $('<li/>', {
           'class' : 'list-group-item',
           'html' : value,
           'data-index' : id
         }).append(result_delete_button);

         mod_results.append(result_item);

         // wyczyszczenie
         mod_input.val('');
         mod_input.removeAttr('data-index');
       }
     };

    // zmiana wartości w polu wyszukiwania
    mod_input.css("color", "red");
    mod_input.keyup(function(e) {
      var value_to_search = this.value;
      if (value_to_search.length != 0)
      {
        $('ul[class=dropdown-menu]').dropdown('toggle');
        $.ajax({
          type: "GET",
          url: host + "/" + value_to_search,
          success: function( msg ) {
            mod_dropdown.html('');

            // dodanie wyników zapytania do listy
            $.each(msg, function(k, v) {
              mod_dropdown.append(
                $('<li/>', {
                  'html' : '<a href="#">' + v.name + '</a>',
                  'data-index': v.id,
                  'click' : list_position_click
                })
              );
            });
            if (msg.length == 0) {
              mod_dropdown.parent().removeClass('open');
            }
          }
        });
      }
      else
      {
        mod_dropdown.html('');
        mod_dropdown.parent().removeClass('open');
      }
    });

    // obsługa przycisku do dodawania moderatora
    mod_button.click(function(e) {
       e.preventDefault();

       var id     = mod_input.attr('data-index');
       var value  = mod_input.val();

       add_item(id, value);
     });

     // przy inicjalizacji synchro
     if (synchronize_input != undefined) {
       var users = synchronize_input.val().replace(/[{}]/g, '').split(',');
       synchronize_input.val('');
       users.forEach( function (pair) {
         var id     = pair.split(':')[1];
         var value  = pair.split(':')[0].replace(/['"]+/g, '');

         add_item(id, value);
       });
     }


     return this;
  };
  // END MOD

  // MOD TEAMS
  $.fn.teams_plugin = function(options, args) {
    // domyślny typ
    var type = 'GP';

    // znalezienie kontrolek
    var mod_plugin_container  = $(this);
    var mod_alert_duplicates  = $(this).find('.alert-danger').eq(0);
    var mod_alert_empty       = $(this).find('.alert-danger').eq(1);
    var mod_team_counter      = $(this).find('.team_counter').eq(0);

    var self = this;
    // metody publiczne
    var methods = {
        setType: function() {
          //wystawiona metoda
          self.type = args['type'];
          mod_plugin_container.find('input[name="group_counter"]').closest(".form-group").css('display', (self.type == "GP") ? 'block': 'none');
          mod_plugin_container.find('.group-name').css('display', (self.type == "GP") ? 'inline-block': 'none');
        },
        validate: function() {
          customValidator = args['custom_validator'];
          var itemCount = mod_plugin_container.find('input[name="teams[]"]').length;
          return customValidator(self.type, itemCount) && validate();
        },
        initByValues: function() {
          var items = args['items'];
          for (var i=0; i<items.length; i++) {
            if (i!=0) {
              addItem(false);
            }
            mod_plugin_container.find('input[name="teams[]"]').eq(i).val(items[i]);
          }
        }
    };

    // metody prywatne
    // sprawdzenie duplikatów
    function hasDuplicate(callback) {
      var inputs = mod_plugin_container.find('input[name="teams[]"]');
      var has_empty = false;
      var valid = true;
      inputs.each(function(i) {
        var that = this;
        if ($(that).val().length > 0) {
          inputs.each(function(j) {
            if (i!=j) {
              if ($(that).val() == $(this).val()) {
                valid = false;
              }
            }
          });
        } else {
          has_empty = true;
        }
      });
      callback(valid, has_empty);
    }

    // dynamiczna walidacja nie uwzględnia pustych pól (bo dynamicznie dodajemy)
    function dynamicValidate() {
      validate(true);
      mod_team_counter.html('(' + mod_plugin_container.find('input[name="teams[]"]').length + ')');
    }

    // walidacja pluginu
    function validate(omit_empty_fields) {
      var result = 'a';
      hasDuplicate(function (valid, hasEmpty) {
        mod_alert_duplicates.css('display', valid ? 'none' : 'block');
        if (!omit_empty_fields) {
          mod_alert_empty.css('display', !hasEmpty ? 'none' : 'block');
        } else {
          // pomijanie sprawdzania czy pole jest puste
          // jednak jeśli wszystkie są uzupełnione to ukrywamy komunikat
          // przy edycji, gdy pojawia sie pole nie chcemy od razu pokazywać alertu
          if (!hasEmpty) {
            mod_alert_empty.css('display', 'none');
          }
        }

        result = (valid && !hasEmpty);
      });
      return result
    }

    // usunięcie itemu
    function removeItem(that) {
      var index = $(that).index();
      $(that).remove();
      mod_plugin_container.find('input[name="teams[]"]')[index-1].focus();
      calculateGroups();
      dynamicValidate();
    };

    // dodanie itemu
    function addItem(init_item) {
      // div zawierający item
      var item = $('<div/>', {
        'class': 'input-group group-div'
      });

      // pole tekstowe
      var item_input = $('<input/>', {
        'class': 'form-control input-sm',
        'type' : 'text',
        'name' : 'teams[]',
        'autocomplete': 'off'
      });

      // przyciski (usuwanie / numer grupy)
      var item_buttons = $('<div/>', {
        'class': 'input-group-btn'
      });
      item_buttons.append($('<button/>', {
        'class': 'btn btn-default btn-sm',
        'type' : 'button',
        'html' : '<i class="fa fa-trash-o" aria-hidden="true"></i>',
        'click': function(){ removeItem(item); }
      }));
      item_buttons.append($('<button/>', {
        'class': 'btn btn-default btn-sm group-name',
        'type' : 'button'
      })).find('.group-name').css('display', (type == 'GP') ? 'inline-block': 'none');

      item.append(item_input);
      item.append(item_buttons);
      mod_plugin_container.find('.item-container').append(item);

      // zaznaczenie itemu
      if (!init_item) {
        item_input.focus();
      }

      // dodanie akcji (backspace; enter; jakikolwiek inny przycisk)
      item_input.keydown(function(e) {
        if (e.keyCode == 8 && $(this).val().length == 0 && !init_item) {
          removeItem(item);
          e.preventDefault();
          return false;
        }
      });
      item_input.keypress(function(e) {
        if(e.keyCode == 13) {
          addItem(false);
          e.preventDefault();
          return false;
        }
      });
      item_input.keyup(function(e) {
        dynamicValidate();
      });

      // przeliczenie grup
      calculateGroups();
    };

    function calculateGroups() {
      // przelicz wszystkie grupy
      var group = 'A';
      var group_counter = parseInt(mod_plugin_container.find('input[name="group_counter"]').val());
      var a = new Array();
      for (var i=0; i<mod_plugin_container.find('.group-name').length; i++)
      {
        a.push((i+group_counter) % group_counter);
      }
      a = a.sort();
      var colors = new Array("red",  "blue", "yellow", "green", "violet");
      mod_plugin_container.find('.group-name').each(function(index) {
        $(this).html(String.fromCharCode(group.charCodeAt(0) + a[index]));
        $(this).css('border-left', 'solid 3px ' + colors[a[index] % colors.length]);
      });
    };

    var methodOutput;

    this.each(function () {
      if (methods[options]) {
        methodOutput = methods[options].apply( this, arguments);
        return methodOutput;
      }
      else if (!options)
      {
        // właściwy plugin
        if (args != undefined && args['debug']) {
          $(this).css('border', '1px red dotted');
        }

        // dodaj początkowy item
        addItem(true);

        // akcja dla liczby grup
        mod_plugin_container.find('input[name="group_counter"]').first().change(function() {
          if ($(this).val().length > 0)
            calculateGroups();
        });

        // obsługa przycisku dodania itemu
        mod_plugin_container.find('button:has(i[class="fa fa-plus"])').first().click(function() {
          addItem(false);
        });

        //obsługa przycisku 'shuffle'
        mod_plugin_container.find('button:has(i[class="fa fa-random"])').first().click(function() {
          var teams_array = new Array();
          $('input[name="teams[]"]').each(function(i) {
            teams_array.push($(this).val());
          });

          shuffle(teams_array);

          mod_plugin_container.find('input[name="teams[]"]').each(function(i) {
            $(this).val(teams_array[i]);
          });

          calculateGroups();
        });

        return this;
      }
    });
    if (methodOutput != undefined) {
      return methodOutput;
    } else {
      return this;
    }
  };
  // END MOD
}( window.jQuery );
