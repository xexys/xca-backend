MoviePageView = require('blocks-pages/movie');
MovieCardEdit = require('blocks-widgets/movie-card_edit');


class MovieEditPageView extends MoviePageView

  initialize: ->
    new MovieCardEdit(el: '.movie-card_edit')


module.exports = MovieEditPageView