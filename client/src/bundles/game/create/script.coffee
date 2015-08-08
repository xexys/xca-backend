app = require('app')
GameCreatePage = require('blocks-pages/game_create')

$ ->
  app.start(pageView: new GameCreatePage)

