#require('backend/blocks/foo-bar')
#require('backend/blocks/foo-bar_baz')
#require('backend/blocks/foo-bar/item')
#require('backend/blocks/foo-bar/item_active')

Backbone = require('common/blocks-modules/backbone')
Marionette = require('common/blocks-modules/marionette')

class App extends Marionette.Application

  channelName: 'backend'

  onStart: ->
    Backbone.history.start()


module.exports = new App


### dev-code-start ###
window.app = module.exports
### dev-code-end ###

