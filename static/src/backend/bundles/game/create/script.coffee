app = require('backend/app')
GameCreatePageView = require('backend/blocks-pages/game_create')

$ ->
  app.start(pageView: new GameCreatePageView)

