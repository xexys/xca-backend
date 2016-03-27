MovieFileCardWidget = require('blocks-widgets/movie-file-card')
cosmetic = require('blocks/cosmetic');


class MovieFileCardEditWidget extends MovieFileCardWidget

  events:
    'click .movie-file-card_audio-btn_add': '_addAudio'
    'click .movie-file-card_audio-btn_remove': '_removeAudio'
    'input .movie-file-card_info-param_movie-title': '_clearMovieId'


  ui: ->
    movieId: '.movie-file-card_info-param_movie-id'
    movieTitle: '.movie-file-card_info-param_movie-title'


  onShow: ->
    @_initGameTitleAutocomplete()


  _initGameTitleAutocomplete: ->
    @ui.movieTitle.typeahead(
#      items: 10
#      minLength: 1
      delay: 100

      source: (query, process) ->
        url = '/autocomplete/getMovieList';
        data = {
          search: query
        }

        return $.getJSON(url, data, (items) ->
          process(items)
        )

      displayText: (item) =>
        return item.game.title + ' - ' + item.title;

      afterSelect: (item) =>
        @ui.movieId.val(item.id)
    )

  _clearMovieId: ->
    @ui.movieId.val(null)


  _addAudio: (event) ->
    event.preventDefault()

    $template = $(@_getAudioTemplate())

    cosmetic.setSelect($template)

    $audio = @_getClosestAudio(event.target)
    $audio.after($template)

    @_toggleRemoveBtn()


  _removeAudio: (event) ->
    event.preventDefault()

    $audio = @_getClosestAudio(event.target)
    $audio.remove()

    @_toggleRemoveBtn()


  _toggleRemoveBtn: ->
    $buttons = @$('.movie-file-card_audio-btn_remove')
    isHidden = $buttons.length == 1
    $buttons.toggleClass('movie-file-card_audio-btn_hidden', isHidden)


  _getAudioTemplate: ->
    @_num = @_num || @_getAllAudio().length
    $template = $('#movie-file-card_audio-template')
    indexPlaceholder = $template.data('indexPlaceholder')
    return $template.html().replace(new RegExp(indexPlaceholder, 'g'), @_num++)


  _getAllAudio: ->
    return @$('.movie-file-card_audio')


  _getClosestAudio: (selector) ->
    return @$(selector).closest('.movie-file-card_audio')

  
  



module.exports = MovieFileCardEditWidget