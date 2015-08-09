MovieCardWidget = require('./movie-card')

class MovieCardEditWidget extends MovieCardWidget

  events:
    'click .movie-card_audio-btn_add': '_addAudio'
    'click .movie-card_audio-btn_remove': '_removeAudio'


  initialize: ->
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
#        @$('.movie-card_main_game-id').val(item.id)
    )


  _addAudio: (e) ->
    e.preventDefault()

    template = @_getAudioTemplate()

    $audio = @_getClosestAudio(e.target)
    $audio.after($(template))

    @_toggleRemoveBtn()


  _removeAudio: (e) ->
    e.preventDefault()

    $audio = @_getClosestAudio(e.target)
    $audio.remove()

    @_toggleRemoveBtn()


  _toggleRemoveBtn: ->
    $buttons = @$('.movie-card_audio-btn_remove')
    isHidden = $buttons.length == 1
    $buttons.toggleClass('movie-card_audio-btn_hidden', isHidden)


  _getAudioTemplate: ->
    @_num = @_num || @_getAllAudio().length
    $template = $('#movie-card_audio-template')
    indexPlaceholder = $template.data('indexPlaceholder')
    return $template.html().replace(new RegExp(indexPlaceholder, 'g'), @_num++)


  _getAllAudio: ->
    return @$('.movie-card_audio')


  _getClosestAudio: (selector) ->
    return @$(selector).closest('.movie-card_audio')

  
  



module.exports = MovieCardEditWidget