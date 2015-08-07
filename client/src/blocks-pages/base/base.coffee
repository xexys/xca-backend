Marionette = require('blocks-modules/marionette');


class BasePageView extends Marionette.LayoutView

  el: '.page'


  initialize: ->
    @$('select').select2(
      minimumResultsForSearch: 7
    )


module.exports = BasePageView

