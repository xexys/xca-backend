GameCardWidget = require('./game-card')

class GameCardEditWidget extends GameCardWidget


  initialize: ->
    @initPlatformIdsSelect()


  initPlatformIdsSelect: ->
#    @$('.game-card_param_platform-ids').select2()



module.exports = GameCardEditWidget