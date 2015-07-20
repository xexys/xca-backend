Marionette = require('common/blocks-modules/marionette');
PageView = require('backend/blocks/page');
GameCardView = require('backend/blocks/game-card');


class GameCreatePageView extends PageView

  initialize: ->
    super
    @_gameCard = new GameCardView(el: '.game-card');


module.exports = GameCreatePageView
