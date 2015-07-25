MoviePageView = require('backend/blocks-pages/movie');
MovieCardEdit = require('backend/blocks/movie-card_edit');


class MovieCreatePageView extends MoviePageView

  initialize: ->
    new MovieCardEdit(el: '.movie-card_edit')


module.exports = MovieCreatePageView
