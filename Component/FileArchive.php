<?php
namespace Xtlan\Core\Component;

use yii\data\Object;
use Yii;

/**
* FileArchive
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class FileArchive extends Object
{

    //Полное имя файла с путем (архив)
    private $fullname;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {

        //Имя архива
        $filepath = Yii::getAlias('@app/runtime');
        $filename =  'image_' . date('Hi_dmY') . '.tar';

        //Полное имя архива
        $this->fullname = $filepath . '/' .$filename;

        //Если архив уже существовал
        if (file_exists($this->fullname)) {
            if (is_writable($this->fullname)) {
                unlink($this->fullname);
            } else {
                throw new \Exception('Нет прав');
            }
        }
    }

    /**
     * execCommand
     *
     * @param mixed $command
     * @access private
     * @return void
     */
    private function execCommand( $command)
    {
        exec($command, $output, $status);
        if ($status != 0) {
            throw new \Exception("Ошибка при выполнении комманд архивации status:{$status}");
        }
        return true;
    }


    /**
     * addFile
     *
     * @param mixed $fullname
     * @access public
     * @return void
     */
    public function addFile($fullname)
    {
        if (!file_exists($this->fullname)) {
            $this->execCommand("tar -cvf {$this->fullname} {$fullname}");
        } else {
            $this->execCommand("tar -rvf {$this->fullname} {$fullname}");
        }
    }

    /**
     * addRelativeFile
     *
     * @param mixed $corePath
     * @param mixed $relPath
     * @access public
     * @return void
     */
    public function addRelativeFile($corePath, $relPath)
    {
        $curDirectory = getcwd();
        chdir($corePath);
        $this->addFile($relPath);
        chdir($curDirectory);
    }


    /**
     * getArchiveName
     *
     * @access public
     * @return void
     */
    public function getArchiveName()
    {
        return $this->fullname;
    }
    
}
