# Пример подключения блоков:
# require('backend/blocks/foo-bar')
# require('backend/blocks/foo-bar_baz')
# require('backend/blocks/foo-bar/item')
# require('backend/blocks/foo-bar/item_active')

Backbone = require('common/blocks-modules/backbone')
Marionette = require('common/blocks-modules/marionette')

BaseRouter = require('backend/routers/base')
BasePageView = require('backend/blocks-pages/base')


class App extends Marionette.Application

  onBeforeStart: (options = {}) ->
    @_router = options.router || new BaseRouter
    @_pageView = options.pageView || new BasePageView


  onStart: ->
    ### dev-code-start ###
    console.info('App:', 'start')
    console.log('Router:', @_router.constructor.name)
    console.log('Controller:', @_router.controller.constructor.name)
    console.log('PageView:', @_pageView.constructor.name)
    ### dev-code-end ###

    Backbone.history.start()




module.exports = new App


### dev-code-start ###
window.app = module.exports
### dev-code-end ###
