Marionette = require('common/blocks-modules/marionette');
GameCard = require('backend/blocks/game-card');


class GameCreatePage extends Marionette.LayoutView

  initialize: ->

    console.log('GameCreatePage')

    @_gameCard = new GameCard({el: '.game-card'});

    @_gameCard.test()


module.exports = GameCreatePage
