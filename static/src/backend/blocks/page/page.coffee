Marionette = require('common/blocks-modules/marionette');

class PageView extends Marionette.LayoutView

  el: '.page'

  initialize: ->

    console.log('page initialized', @)


module.exports = PageView
