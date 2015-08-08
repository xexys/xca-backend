app = require('app')
MovieCreatePage = require('blocks-pages/movie_create')

$ ->
  app.start(pageView: new MovieCreatePage)

