MovieCardWidget = require('blocks-widgets/movie-card')

class MovieCardEditWidget extends MovieCardWidget

  onShow: ->
    @_initGameTitleAutocomplete()


  _initGameTitleAutocomplete: ->
    @$('.movie-card_main-param_game-title').typeahead(
#      items: 10
#      minLength: 1
      delay: 100

      source: (query, process) ->
        url = '/autocomplete/getGameList';
        data = {
          search: query
        }

        $.getJSON(url, data, (items) ->
          process(items)
        )

#      afterSelect: (item) =>
#        @$('.movie-file-card_main_game-id').val(item.id)
    )


module.exports = MovieCardEditWidget