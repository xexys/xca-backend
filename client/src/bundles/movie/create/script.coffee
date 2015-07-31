app = require('app')
MovieCreatePageView = require('blocks-pages/movie_create')

$ ->
  app.start(pageView: new MovieCreatePageView)

