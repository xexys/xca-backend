console.log("pages");

require('backend/blocks/foo-bar')
require('backend/blocks/foo-bar_baz')
require('backend/blocks/foo-bar/item')
require('backend/blocks/foo-bar/item_active')

Marionette = require('common/blocks-modules/marionette')

$(->

  pageId = $('.page').data('pageId')

  V = require('backend/blocks-pages/game/create')
  new V

  console.log(V)


  class BaseApp extends Marionette.Application

  (new BaseApp).start()

)

