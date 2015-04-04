<?php
/**
 * $params["userId"] - id пользователя, для которого проверяется правило
 */

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
            'user', // Позволим модератору всё, что позволено пользователю
            'questionManager',
            'answerManager',
            'materialManager',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'user'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Пользователь',
        'children'=>array(
            'guest', // Позволим пользователю все что может гость
            'questionAuthor',
            'answerAuthor',
            'materialAuthor',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'guest'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Гость',
        'children'=>array(
            'questionViewer',
            'answerViewer',
            'materialViewer',
            'commentAuthor',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'banned'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Заблокированный пользователь',
        'children'=>array(
            'questionViewer',
            'answerViewer',
            'materialViewer',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    
/* ---------------- Роли для выполнения различных операций ----------------- */
    
    // Роли для управления вопросами
    'questionViewer'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Просмотрщик вопросов',
        'children'=>array(
            'viewQuestion',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'questionAuthor'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Автор вопросов',
        'children'=>array(
            'questionViewer',
            'createQuestion',
            'closeOwnQuestion',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'questionManager'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Менеджер вопросов',
        'children'=>array(
            'questionAuthor',
            'viewDeletedQuestion',
            'closeQuestion',
            'deleteQuestion'
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    
    // Роли для управления ответами
    'answerViewer'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Просмотрщик ответов',
        'children'=>array(
            'viewAnswer',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'answerAuthor'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Автор ответов',
        'children'=>array(
            'answerViewer',
            'createAnswer',
            'voteAnswer',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'answerManager'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Менеджер ответов',
        'children'=>array(
            'answerAuthor',
            'viewDeletedAnswer',
            'deleteAnswer',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    // Роли для управления материалами
    'materialViewer'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Просмотрщик материалов',
        'children'=>array(
            'viewMaterial',
            'viewMaterialTopic',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'materialAuthor'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Автор материалов',
        'children'=>array(
            'materialViewer',
            'createMaterial',
            'voteMaterial',
            'rewardMaterial',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'materialManager'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Менеджер материалов',
        'children'=>array(
            'materialAuthor',
            'viewDeletedMaterial',
            'viewAllMaterialTopics',
            'deleteMaterial',
            'deleteMaterialTopic',
        ),
        'bizRule'=>null,
        'data'=>null
    ),

    // Роли для управления комментариями
    'commentViewer'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Просмотрщик комментариев',
        'children'=>array(
            'viewComment',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    'commentAuthor'=>array(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Автор комментариев',
        'children'=>array(
            'commentViewer',
            'createComment',
        ),
        'bizRule'=>null,
        'data'=>null
    ),
    
/* -------------------------- Задачи --------------------------------------- */
    'closeOwnQuestion'=>array(
        'type'=>  CAuthItem::TYPE_TASK,
        'description'=>'Изменение статуса своего вопроса на закрытый',
        'children'=>array(
            'closeQuestion',
        ),
        'bizRule'=>'return $params["userId"]==$params["questionAuthorId"];', // Автор вопроса может закрыть вопрос
        'data'=>null
    ),
/* -------------------------- Операции --------------------------------------- */

    // Вопросы
    'createQuestion'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Создание нового вопроса',
        'bizRule'=>null,
        'data'=>null
    ),
    'viewQuestion'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Просмотр вопроса',
        'bizRule'=>null,
        'data'=>null
    ),
    'closeQuestion'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Изменение статуса вопроса на закрытый',
        'bizRule'=>null,
        'data'=>null
    ),
    'viewDeletedQuestion'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Просмотр удаленного вопроса',
        'bizRule'=>null,
        'data'=>null
    ),
    
    'deleteQuestion'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Удаление вопроса',
        'bizRule'=>null,
        'data'=>null
    ),
    
    // Ответы
    'createAnswer'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Создание нового ответа',
        'bizRule'=>'return $params["userId"]!=$params["questionAuthorId"];', // Авторы вопросов не могут писать себе ответы
        'data'=>null
    ),
    'viewAnswer'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Просмотр ответа',
        'bizRule'=>null,
        'data'=>null
    ),
    'viewDeletedAnswer'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Просмотр удаленного ответа',
        'bizRule'=>null,
        'data'=>null
    ),
    'voteAnswer'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Голосовать за ответ',
        'bizRule'=>'return $params["userId"]!=$params["answerAuthorId"];', // Авторы ответов не могут голосовать за самих себя
        'data'=>null
    ),
    'deleteAnswer'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Удаление ответа',
        'bizRule'=>null,
        'data'=>null
    ),

    // Материалы
    'createMaterial'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Создание нового материала',
        'bizRule'=>null,
        'data'=>null
    ),
    'viewMaterial'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Просмотр материала',
        'bizRule'=>null,
        'data'=>null
    ),
    'viewDeletedMaterial'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Просмотр удаленного материала',
        'bizRule'=>null,
        'data'=>null
    ),
    'voteMaterial'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Голосовать за материал',
        'bizRule'=>'return $params["userId"]!=$params["user_id"];', // Авторы материалов не могут голосовать за самих себя
        'data'=>null
    ),
    'rewardMaterial'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Сделать взнос за материал',
        'bizRule'=>null,
        'data'=>null
    ),
    'deleteMaterial'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Удаление материалов',
        'bizRule'=>null,
        'data'=>null
    ),
    
    // Темы материалов
    'viewMaterialTopic'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Просмотр темы материалов',
        'bizRule'=>null,
        'data'=>null
    ),
    'viewAllMaterialTopics'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Просмотр всех тем материалов всех пользователей',
        'bizRule'=>null,
        'data'=>null
    ),
    'deleteMaterialTopic'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Удаление темы материалов',
        'bizRule'=>null,
        'data'=>null
    ),
    
    // Комментарии
    'viewComment'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Просмотр комментария',
        'bizRule'=>null,
        'data'=>null
    ),
    'createComment'=>array(
        'type'=>  CAuthItem::TYPE_OPERATION,
        'description'=>'Добавление нового комментария',
        'bizRule'=>null,
        'data'=>null
    ),
    
    // Пользователи
    


);