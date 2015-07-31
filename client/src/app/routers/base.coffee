app = require('app')
Marionette = require('blocks-modules/marionette')
BaseController = require('controllers/base')

class BaseRouter extends Marionette.AppRouter

  controller: new BaseController


  appRoutes:
    'test': 'test',


module.exports = BaseRouter