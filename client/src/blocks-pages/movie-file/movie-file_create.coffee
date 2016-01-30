MovieFilePage = require('blocks-pages/movie-file');
MovieFileCardEditWidget = require('blocks-widgets/movie-file-card_edit');

class MovieFileCreatePage extends MovieFilePage

  onShow: ->
    super

    @movieFileCard.show(new MovieFileCardEditWidget(
      el: '.movie-file-card_edit'
    ))


module.exports = MovieFileCreatePage