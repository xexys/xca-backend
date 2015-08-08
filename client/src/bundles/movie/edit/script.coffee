app = require('app')
MovieEditPage = require('blocks-pages/movie_edit')

$ ->
  app.start(pageView: new MovieEditPage)

