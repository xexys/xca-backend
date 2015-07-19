Marionette = require('common/blocks-modules/marionette');

class MenuView extends Marionette.LayoutView

  el: '.menu'

  initialize: ->

    console.log('menu initialized', @)


module.exports = MenuView
