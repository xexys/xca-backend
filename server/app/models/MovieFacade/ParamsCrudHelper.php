<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.08.15
 * Time: 16:15
 */

namespace app\models\MovieFacade;

use \app\components\interfaces\FacadeModelCrudHelper;
use \app\models\AR\Game;
use \app\models\AR\Movie;
use \Exception;
use \CException;


class ParamsCrudHelper implements FacadeModelCrudHelper
{
    private $_mainParams;
    private $_fileParams;
    private $_videoParams;
    private $_audioParams;
    
    private $_movie;

    public function __construct($movie, $params)
    {
        $this->_mainParams = $params['mainParams'];
        $this->_fileParams = $params['fileParams'];
        $this->_videoParams = $params['videoParams'];
        $this->_audioParams = $params['audioParams'];
        
        $this->_movie = $movie;
    }

    public function create()
    {
        if ($this->_mainParams) {
            $this->_createMainParams();
        }
        if ($this->_fileParams) {
            $this->_createFileParams();
        }
        if ($this->_videoParams) {
            $this->_createVideoParams();
        }
        if ($this->_audioParams) {
            $this->_createAudioParams();
        }
    }

    public function update()
    {
        if ($this->_mainParams) {
            $this->_updateMainParams();
        }
        if ($this->_fileParams) {
            $this->_updateFileParams();
        }
        if ($this->_videoParams) {
            $this->_updateVideoParams();
        }
        if ($this->_audioParams) {
            $this->_updateAudioParams();
        }
    }

    public function delete()
    {
        $this->_deleteAudioParams();
        $this->_deleteVideoParams();
        $this->_deleteFileParams();
        $this->_deleteMainParams();
    }

// ----- PRIVATE ------------------------------------------------------------------------------------------------------

    private function _createMainParams()
    {
        $game = Game::model()->findByAttributes(array('title' => $this->_mainParams->gameTitle));

        $attrs = $this->_mainParams->getAttributes();
        $attrs['gameId'] = $game->id;
        $movie = $this->_movie;
        $movie->setAttributes($attrs);

        if (!$movie->save()) {
            throw new CException($movie->getFirstErrorMessage());
        }
    }

    private function _createFileParams()
    {
        $this->_checkMovieIsNewRecord();

        $attrs = $this->_fileParams->getAttributes();
        $attrs['movieId'] = $this->_movie->id;
        $movieFile = new Movie\File;
        $movieFile->setAttributes($attrs);

        if (!$movieFile->save()) {
            throw new CException($movieFile->getFirstErrorMessage());
        }
    }

    // TODO: Посчитать frame_quality перед сохранением
    private function _createVideoParams()
    {
        $this->_checkMovieIsNewRecord();

        $attrs = $this->_videoParams->getAttributes();
        $attrs['movieId'] = $this->_movie->id;
        $movieVideo = new Movie\Video;
        $movieVideo->setAttributes($attrs);

        if (!$movieVideo->save()) {
            throw new CException($movieVideo->getFirstErrorMessage());
        }
    }

    private function _createAudioParams()
    {
        $this->_checkMovieIsNewRecord();

        foreach ($this->_audioParams->items as $audioParams) {
            $attrs = $audioParams->getAttributes();
            $attrs['movieId'] = $this->_movie->id;
            $movieAudio = new Movie\Audio;
            $movieAudio->setAttributes($attrs);
            if (!$movieAudio->save()) {
                throw new CException($movieAudio->getFirstErrorMessage());
            }
        }
    }

    private function _updateMainParams()
    {
        $this->_movie->setAttributes($this->_mainParams->getAttributes());

        if (!$this->_movie->save()) {
            throw new CException($this->_movie->getFirstErrorMessage());
        }
    }

    private function _updateFileParams()
    {
        $attrs = $this->_fileParams->getAttributes();
        $this->_movie->file->setAttributes($attrs);

        if (!$this->_movie->file->save()) {
            throw new CException($this->_movie->file->getFirstErrorMessage());
        }
    }

    // TODO: Посчитать frame_quality
    private function _updateVideoParams()
    {
        $attrs = $this->_videoParams->getAttributes();
        $this->_movie->video->setAttributes($attrs);

        if (!$this->_movie->video->save()) {
            throw new CException($this->_movie->video->getFirstErrorMessage());
        }
    }

    private function _updateAudioParams()
    {
        $this->_deleteAudioParams();
        $this->_createAudioParams();
    }

    private function _deleteMainParams()
    {
        $this->_movie->delete();
    }

    private function _deleteFileParams()
    {
        Movie\File::model()->deleteAllByAttributes(array('movie_id' => $this->_movie->id));
    }

    private function _deleteVideoParams()
    {
        Movie\Video::model()->deleteAllByAttributes(array('movie_id' => $this->_movie->id));
    }

    private function _deleteAudioParams()
    {
        Movie\Audio::model()->deleteAllByAttributes(array('movie_id' => $this->_movie->id));
    }

    private function _checkMovieIsNewRecord()
    {
        if ($this->_movie->getIsNewRecord()) {
            throw new CException('The movie must not be a new.');
        }
    }
}