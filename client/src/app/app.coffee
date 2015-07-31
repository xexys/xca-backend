# Пример подключения блоков:
#require('blocks/foo-bar')
#require('blocks/foo-bar_baz')
#require('blocks/foo-bar/item')
#require('blocks/foo-bar/item_active')

Backbone = require('blocks-modules/backbone')
Marionette = require('blocks-modules/marionette')

BaseRouter = require('routers/base')

BasePageView = require('blocks-pages/base')


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
