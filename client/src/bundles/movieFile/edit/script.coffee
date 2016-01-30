app = require('app')
MovieFileEditPage = require('blocks-pages/movie-file_edit')

$ ->
  app.start(pageView: new MovieFileEditPage)

