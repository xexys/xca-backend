app = require('backend/app')
BaseRouter = require('backend/routers/base')
BasePageView = require('backend/blocks-pages/base')


$ ->

  app.router = new BaseRouter
  app.rootView = new BasePageView

  app.start()

