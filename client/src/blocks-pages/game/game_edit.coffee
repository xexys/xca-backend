GamePage = require('blocks-pages/game');
GameCardEditWidget = require('blocks-widgets/game-card_edit');

class GameEditPage extends GamePage

  onShow: ->
    @gameCard.show(new GameCardEditWidget(
      el: '.game-card_edit'
    ))



module.exports = GameEditPage
