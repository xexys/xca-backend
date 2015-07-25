app = require('backend/app')
MovieCreatePageView = require('backend/blocks-pages/movie_create')

$ ->
  app.start(pageView: new MovieCreatePageView)

