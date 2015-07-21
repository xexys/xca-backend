Marionette = require('common/blocks-modules/marionette')

class BaseController extends Marionette.Object

  test: ->
    console.info('Route changed:', 'test')


module.exports = BaseController