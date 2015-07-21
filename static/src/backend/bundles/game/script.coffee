app = require('backend/app')
GamePageView = require('backend/blocks-pages/game')

$ ->
  app.start(pageView: new GamePageView)

