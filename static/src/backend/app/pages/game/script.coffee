app = require('backend/app')
GamePageView = require('backend/blocks-pages/game')

$ ->
  app.rootView = new GamePageView
  app.start()

