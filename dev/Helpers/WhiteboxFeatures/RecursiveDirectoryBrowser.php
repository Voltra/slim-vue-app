<?php
/////////////////////////////////////////////////////////////////////////
//Namespace
/////////////////////////////////////////////////////////////////////////
namespace App\Helpers\WhiteboxFeatures;



/////////////////////////////////////////////////////////////////////////
//Imports
/////////////////////////////////////////////////////////////////////////
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Traversable;



/**A class used to browse (recursively) a directory
 * Class RecursiveDirectoryBrowser
 * @package WhiteBox\Filesystem
 */
class RecursiveDirectoryBrowser extends AbstractDirectoryBrowser {
    /////////////////////////////////////////////////////////////////////////
    //Magics
    /////////////////////////////////////////////////////////////////////////
    /**Instantiate from a URI
     * I_FSBrowser constructor.
     * @param string $uri being the URI to load from
     * @throws Exception
     */
    public function __construct(string $uri){
        parent::__construct($uri);
    }



    /////////////////////////////////////////////////////////////////////////
    //Overrides
    /////////////////////////////////////////////////////////////////////////
    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator(): Traversable{
        $dir = new RecursiveDirectoryIterator($this->uri);
        return new RecursiveIteratorIterator($dir);
    }
}