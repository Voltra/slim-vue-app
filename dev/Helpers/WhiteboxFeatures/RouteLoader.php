<?php
/////////////////////////////////////////////////////////////////////////
//Namespace
/////////////////////////////////////////////////////////////////////////
namespace App\Helpers\WhiteboxFeatures;



/////////////////////////////////////////////////////////////////////////
//Imports
/////////////////////////////////////////////////////////////////////////
use Exception;



/**
 * Class RouteLoader
 * @package WhiteBox\Routing
 */
class RouteLoader{
    /////////////////////////////////////////////////////////////////////////
    //Traits used
    /////////////////////////////////////////////////////////////////////////
    use T_RouteLoader;

    /////////////////////////////////////////////////////////////////////////
    //Methods
    /////////////////////////////////////////////////////////////////////////
    /**Generate a loader file each time it is called (to the given file URI)
     * Can be used in your code or to do a generator script (in shell for instance)
     * @param string $autoloaderFileURI
     * @return string
     * @throws Exception if it cannot access to the autoloader file
     */
    public function generateLoaderFile(string $autoloaderFileURI): string{
        $phpFiles = $this->getPhpFiles();

        $autoloader = fopen($autoloaderFileURI,"w+");
        if(!$autoloader)
            throw new Exception("failed to create the autoloader file for the route loader.");

        fwrite($autoloader, "<?php\n");
        $phpFiles->forEach(function(string $filePath) use($autoloader){
            fwrite($autoloader, "require_once '{$filePath}';\n");
        });
        fclose($autoloader);

        return (string)realpath($autoloaderFileURI);
    }

    /**Retrieves the PHP files path from the directory of this loader
     * @return MagicalArray
     */
    protected function getPhpFiles(): MagicalArray{
        return (new RecursiveDirectoryBrowser($this->path))
        ->toMagicalArray()
        ->filter(function(string $elem){
            ["extension" => $extension] = pathinfo($elem);
            $isPhp = $extension === "php";
            return $isPhp;
        })
        ->sortBy(function(string $lhs, string $rhs): int{
            if($lhs === $rhs)
                return 0;
            else{
                $depthOf = function(string $str): int{
                    $str = str_replace("\\", "/", $str);
                    $d = substr_count($str, "/");
                    if($d === false)
                        return 1;
                    return $d;
                };

                $depthLhs = call_user_func($depthOf, $lhs);
                $depthRhs = call_user_func($depthOf, $rhs);

                if($depthLhs === $depthRhs)
                    return $lhs <=> $rhs;
                else
                    return $depthLhs <=> $depthRhs;
            }
        });
    }
}