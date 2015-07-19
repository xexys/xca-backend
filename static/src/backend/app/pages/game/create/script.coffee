require('../../script.js')

MenuView = require('backend/blocks/menu')
GameCreatePageView = require('backend/blocks-pages/game/create')

$ ->
  new MenuView
  new GameCreatePageView

# Блоки, не привязаны к конкретным нодам в доме, имеют стили
# Виджеты, создают экземпляры блоков, имеют свои стили, идет взаимодействие между блоками
#