GameCardWidget = require('./game-card')

class GameCardEditWidget extends GameCardWidget


  events:
    'click .game-card_platform-info-btn_add': '_addPlatformInfo'
    'click .game-card_platform-info-btn_remove': '_removePlatformInfo'


  _addPlatformInfo: (e) ->
    e.preventDefault()
    console.log(e)

    template = @_getTemplate()

    $platformInfo = @_getClosestPlatformInfo(e.target)
    $platformInfo.after($(template))


  _removePlatformInfo: (e) ->
    e.preventDefault()

    $platformInfo = @_getClosestPlatformInfo(e.target)
    $platformInfo.remove()


  _getClosestPlatformInfo: (target) ->
    return @$(target).closest('.game-card_platform-info')


  _getTemplate: ->
    @_num = @_num || @$('.game-card_platform-info').length
    template = $('#game-card_platform-info-template').html()
    template.replace(/xxxxx/g, @_num++)
    return template;


module.exports = GameCardEditWidget