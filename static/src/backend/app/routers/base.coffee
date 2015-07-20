app = require('backend/app')
Marionette = require('common/blocks-modules/marionette')
BaseController = require('backend/controllers/base')

class BaseRouter extends Marionette.AppRouter

  controller: new BaseController


  appRoutes:
    'test': 'test',


module.exports = BaseRouter