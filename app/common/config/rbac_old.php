<?php

return array(

/* -------------------------- Роли пользователей --------------------------- */

    'admin'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Администратор',
        'children'=>array(
            'moderator', // Позволим админу всё, что позволено модератору
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'moderator'=> array(
        'type'=> CAuthItem::TYPE_ROLE,
        'description'=> 'Модератор',
        'children'=>array(
            'updateAnswerStatus',
            'user',
            'deleteQuestion',
            'deleteAnswer',
            'deleteMaterial',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'user'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Пользователь',
        'children'=>array(

            'guest', // Позволим пользователю все что может гость

            'createQuestion',
            'readQuestion',
            'updateQuestion',

            'createAnswer',
            'readAnswer',
            'updateAnswer',

            'createMaterial',
            'readMaterial',
            'updateMaterial',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'guest'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Гость',
        'children'=>array(
            'createComment',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    /*
    'banned'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Заблокированный пользователь',
        'children'=>array(),
        'bizRule'=>null,
        'data'=>null
    ),
    */


/* -------------------------- Задачи --------------------------------------- */

    // Вопросы
    'createQuestion'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Добавление вопроса',
        'bizRule'=>null,
        'data'=>null
    ),
    'readQuestion'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Просмотр вопроса',
        'bizRule'=>null,
        'data'=>null
    ),
    'updateQuestion'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Обновление вопроса',
        'bizRule'=>null,
        'data'=>null
    ),
    'deleteQuestion'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Удаление вопроса',
        'bizRule'=>null,
        'data'=>null
    ),
    // Ответы
    'createAnswer'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Создание ответа',
        'children'=>array(
            'answerQuestion'
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'readAnswer'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Просмотр ответа',
        'bizRule'=>null,
        'data'=>null
    ),
    'updateAnswer'=>array(
        'type'=>  CAuthItem::TYPE_ROLE,
        'description'=>'Обновление ответа',
        'children'=>array(
            //'updateOwnAnswer',
            'updateOwnAnswerStatus',
            'voteAnswer'
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'deleteAnswer'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Удаление ответа',
        'bizRule'=>null,
        'data'=>null
    ),

    // Материалы
    'createMaterial'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Добавление материалов',
        'bizRule'=>null,
        'data'=>null
    ),
    'readMaterial'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Просмотр материалов',
        'bizRule'=>null,
        'data'=>null
    ),
    'updateMaterial'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Обновление материалов',
        'children'=>array(
            'rewardMaterial',
            'voteMaterial'
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'deleteMaterial'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Удаление материалов',
        'bizRule'=>null,
        'data'=>null
    ),
    // Комментарии
    'createComment'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Добавление комментариев',
        'bizRule'=>null,
        'data'=>null
    ),


/* -------------------------- Операции ------------------------------------- */
    'updateOwnAnswerStatus'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Помечать свой ответ как наилучший',
        'children'=>array(
            'updateAnswerStatus',
        ),
        'bizRule'=>'return Yii::app()->user->id==$params["user_id"];', // Модератор или автор вопроса
        'data'=>null
    ),
    'updateAnswerStatus'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Помечать ответ как наилучший',
        'bizRule'=>null,
        'data'=>null
    ),
    'updateOwnAnswer'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Обновлять свой ответ',
        'bizRule'=>'return Yii::app()->user->checkAccess("moderator") || Yii::app()->user->id==$params["user_id"];', // Модератор или автор ответа
        'data'=>null
    ),
    'answerQuestion'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Отвечать на вопрос',
        'bizRule'=>'return Yii::app()->user->id!=$params["user_id"];', // Авторы вопросов не могут писать себе ответы
        'data'=>null
    ),
    'voteAnswer'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Голосовать за ответ',
        'bizRule'=>'return Yii::app()->user->id!=$params["user_id"];', // Авторы ответов не могут голосовать за самих себя
        'data'=>null
    ),
    'voteMaterial'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Голосовать за материал',
        'bizRule'=>'return Yii::app()->user->id!=$params["user_id"];', // Авторы материалов не могут голосовать за самих себя
        'data'=>null
    ),





);