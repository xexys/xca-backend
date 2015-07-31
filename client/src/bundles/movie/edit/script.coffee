app = require('app')
MovieEditPageView = require('blocks-pages/movie_edit')

$ ->
  app.start(pageView: new MovieEditPageView)

