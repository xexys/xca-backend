app = require('backend/app')
MovieEditPageView = require('backend/blocks-pages/movie_edit')

$ ->
  app.start(pageView: new MovieEditPageView)

