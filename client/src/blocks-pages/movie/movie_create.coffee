MoviePage = require('blocks-pages/movie');
MovieCardEditWidget = require('blocks-widgets/movie-card_edit');


class MovieCreatePage extends MoviePage

  initialize: ->
    super
    new MovieCardEditWidget(el: '.movie-card_edit')


module.exports = MovieCreatePage
