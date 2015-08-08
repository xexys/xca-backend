app = require('app')
GameEditPage = require('blocks-pages/game_edit')

$ ->
  app.start(pageView: new GameEditPage)

