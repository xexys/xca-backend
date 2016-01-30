MoviePage = require('blocks-pages/movie');
MovieCardEditWidget = require('blocks-widgets/movie-card_edit');

class MovieCreatePage extends MoviePage

  onShow: ->
    @movieCard.show(new MovieCardEditWidget(
      el: '.movie-card_edit'
    ))



module.exports = MovieCreatePage
