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

  onStart: ->
    @router = @router || new BaseRouter
    @rootView = @rootView || new BasePageView

    ### dev-code-start ###
    console.info('App:', 'start')
    console.log('Router:', @router.constructor.name)
    console.log('Controller:', @router.controller.constructor.name)
    console.log('PageView:', @rootView.constructor.name)
    ### dev-code-end ###

    Backbone.history.start()




module.exports = new App


### dev-code-start ###
window.app = module.exports
### dev-code-end ###
