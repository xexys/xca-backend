Marionette = require('common/blocks-modules/marionette')

class GameCard extends Marionette.LayoutView

#  events:
#    'click .btn-success': 'add'


  initialize: ->
    console.log('GameCard')


  add: ->
    confirm('Точно добавить ролик?')


module.exports = GameCard
