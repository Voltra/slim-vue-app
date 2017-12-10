<?php
/////////////////////////////////////////////////////////////////////////
//Namespace
/////////////////////////////////////////////////////////////////////////
namespace App\Helpers\WhiteboxFeatures;



/**An interface representing any object that can be converted to a MagicalArray or an array
 * Interface I_MagicalArrayable
 * @package WhiteBox\Helpers
 */
interface I_MagicalArrayable{
    /////////////////////////////////////////////////////////////////////////
    //Methods
    /////////////////////////////////////////////////////////////////////////
    /**Converts the instance to an array
     * @return array
     */
    public function toArray(): array;

    /**Converts the instance to a MagicalArray
     * @return MagicalArray
     */
    public function toMagicalArray(): MagicalArray;
}