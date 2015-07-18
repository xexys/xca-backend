Marionette = require('common/blocks-modules/marionette')

class GameCard extends Marionette.LayoutView

  initialize: ->
    console.log('GameCard')

  test: ->
    alert('test')


module.exports = GameCard
