GamePage = require('blocks-pages/game');
GameCardEditWidget = require('blocks-widgets/game-card_edit');

class GameCreatePage extends GamePage

  initialize: ->
    super
    new GameCardEditWidget(el: '.game-card_edit')



module.exports = GameCreatePage
