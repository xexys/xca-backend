
module.exports =

  setSelect: (el) ->
    $(el).find('select').select2(
      minimumResultsForSearch: 10
    )


