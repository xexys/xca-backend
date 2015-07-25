MovieCard = require('./movie-card')

class MovieCardEdit extends MovieCard

  initialize: ->
    @initGameTitleAutocomplete()


  initGameTitleAutocomplete: ->
    @$('.movie-card_main_game-title').typeahead(
      items: 10
      minLength: 1
      delay: 100

      source: (query, process) ->
        url = '/autocomplete/getGameList';
        data = {
          search: query
        }

        $.getJSON(url, data, (items) ->
          process(items)
        )

      afterSelect: (item) =>
        @$('.movie-card_main_game-id').val(item.id)
    )



module.exports = MovieCardEdit