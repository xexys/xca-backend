#require('backend/blocks/foo-bar')
#require('backend/blocks/foo-bar_baz')
#require('backend/blocks/foo-bar/item')
#require('backend/blocks/foo-bar/item_active')

Marionette = require('common/blocks-modules/marionette')

$ ->
  (new Marionette.Application).start()
