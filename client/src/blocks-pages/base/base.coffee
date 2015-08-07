Marionette = require('blocks-modules/marionette');


class BasePageView extends Marionette.LayoutView

  el: '.page'


  initialize: ->
    @$('select').select2(
      minimumResultsForSearch: 10
    )


module.exports = BasePageView

