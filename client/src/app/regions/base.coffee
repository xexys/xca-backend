Marionette = require('blocks-modules/marionette');


class BaseRegion extends Marionette.Region

  attachHtml: (view) ->
    if !document.body.contains(view.el) then super



module.exports = BaseRegion