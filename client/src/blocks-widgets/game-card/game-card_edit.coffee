GameCardWidget = require('./game-card')

class GameCardEditWidget extends GameCardWidget


  events:
    'click .game-card_platform-info-btn_add': '_addPlatformInfo'
    'click .game-card_platform-info-btn_remove': '_removePlatformInfo'


  _addPlatformInfo: (e) ->
    e.preventDefault()
    console.log(e)

# 1. Найти секцию
# 2. Загрузить шаблон
# 3. Отрендерить



  _removePlatformInfo: (e) ->
    e.preventDefault()
    console.log(e)



module.exports = GameCardEditWidget