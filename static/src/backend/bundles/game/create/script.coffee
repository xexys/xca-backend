app = require('backend/app')
GameCreatePageView = require('backend/blocks-pages/game_create')

$ ->
  app.rootView = new GameCreatePageView
  app.start()

