app = require('backend/app')
GameCreatePageView = require('backend/blocks-pages/game_create')
R = require('backend/routers/base2')

$ ->
  app.start(pageView: new GameCreatePageView)

