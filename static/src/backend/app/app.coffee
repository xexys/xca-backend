#require('backend/blocks/foo-bar')
#require('backend/blocks/foo-bar_baz')
#require('backend/blocks/foo-bar/item')
#require('backend/blocks/foo-bar/item_active')

Marionette = require('common/blocks-modules/marionette')


class App extends Marionette.Application


module.exports = new App
