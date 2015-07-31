app = require('app')
GameCreatePageView = require('blocks-pages/game_create')

$ ->
  app.start(pageView: new GameCreatePageView)

