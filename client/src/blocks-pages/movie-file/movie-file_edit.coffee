MovieFilePage = require('blocks-pages/movie-file');
MovieFileCardEditWidget = require('blocks-widgets/movie-file-card_edit');


class MovieFileEditPage extends MovieFilePage

  onShow: ->
    @movieFileCard.show(new MovieFileCardEditWidget(
      el: '.movie-file-card_edit'
    ))


module.exports = MovieFileEditPage
