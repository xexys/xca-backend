# Пример подключения блоков:
#require('blocks/foo-bar')
#require('blocks/foo-bar_baz')
#require('blocks/foo-bar/item')
#require('blocks/foo-bar/item_active')

Marionette = require('blocks-modules/marionette')

BaseRouter = require('routers/base')
BasePageView = require('blocks-pages/base')
HtmlLayout = require('views/layouts/html')


class App extends Marionette.Application

  onBeforeStart: (options = {}) ->
    Router = options.Router || BaseRouter
    PageView = options.PageView || BasePageView

    @_router = new Router
    @_pageView = new PageView(el: '.page')

    new HtmlLayout(pageView: @_pageView)


  onStart: ->
    ### dev-code-start ###
    console.info('App:', 'start')
    console.log('Router:', @_router.constructor.name)
    console.log('Controller:', @_router.controller.constructor.name)
    console.log('PageView:', @_pageView.constructor.name)
    ### dev-code-end ###

    Marionette.Backbone.history.start()


module.exports = new App


### dev-code-start ###
window.app = module.exports
### dev-code-end ###
