<?php
/////////////////////////////////////////////////////////////////////////
//Namespace
/////////////////////////////////////////////////////////////////////////
namespace App\Helpers\WhiteboxFeatures;



/////////////////////////////////////////////////////////////////////////
//Imports
/////////////////////////////////////////////////////////////////////////
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Serializable;
use Traversable;



/**A class that aims to be a nice replacement to the native PHP array
 * Class MagicalArray
 * @package WhiteBox\Helpers
 */
class MagicalArray implements IteratorAggregate, ArrayAccess, Countable, Serializable, I_JsonSerializable {
    /////////////////////////////////////////////////////////////////////////
    //Properties
    /////////////////////////////////////////////////////////////////////////
    /**The wrapped array used for manipulations and storage
     * @var array
     */
    protected $array;

    /**The default value to send back if none is available
     * @var mixed
     */
    protected $default;



    /////////////////////////////////////////////////////////////////////////
    //Magics
    /////////////////////////////////////////////////////////////////////////
    /**Construct a magical array from a regular array
     * MagicalArray constructor.
     * @param array $arr being the array to construct the object from
     * @param string $default being the default value that would be sent if a required key doesn't exist
     */
    public function __construct(array $arr=[], $default=""){
        $this->array = $arr;
        $this->default = $default;
    }

    /** A syntactic sugar wrapper that serves as a getter
     * @param mixed $key being the key in the array
     * @return mixed
     */
    public function __invoke($key){
        if(isset($this->array[$key]))
            return $this->array[$key];
        else
            return $this->default;
    }

    /////////////////////////////////////////////////////////////////////////
    //Methods
    /////////////////////////////////////////////////////////////////////////
    /**Apply the collection reduction algorithm to this MagicalArray
     * @param callable $reducer being the reducer function used, must be (acc_type, element_type)->newAcc_type
     * @param $acc
     * @return mixed
     * @internal param mixed $accu being the default value of the accumulator
     */
    public function reduce(callable $reducer, $acc){
        foreach ($this as $key=>$value)
            $acc = $reducer($acc, $value, $key);

        return $acc;
    }

    /**Apply the collection mapping algorithm to this MagicalArray
     * @param callable $mapper being the mapper function, must be (element_type, ?key_type)->newElement_type
     * @return MagicalArray
     */
    public function map(callable $mapper): self{
        //return new MagicalArray( array_map($mapper, $this->array) );
        $arr = [];
        $is_assoc = ArrayHelper::is_assoc($this->array);
        foreach($this as $key=>$value) {
            if($is_assoc)
                $arr[$key] = $mapper($value, $key);
            else
                $arr[] = $mapper($value, $key);
        }

        return new MagicalArray($arr, $this->default);
    }

    /**Apply the collection filtering algorithm to this MagicalArray
     * @param callable $predicate being the predicate used to keep elements, must be (element_type, ?key_type)->bool
     * @return MagicalArray
     */
    public function filter(callable $predicate): self{
        //return new MagicalArray( array_filter($this->array, $predicate) );
        $arr = [];
        $is_assoc = ArrayHelper::is_assoc($this->array);
        foreach ($this as $key=>$value) {
            if ($predicate($value, $key)) {
                if($is_assoc)
                    $arr[$key] = $value;
                else
                    $arr[] = $value;
            }
        }

        return new MagicalArray($arr, $this->default);
    }

    /**Call a procedure on each element of this MagicalArray
     * @param callable $procedure being the procedure to call, must be (element_type)->mixed|void
     * @return $this
     */
    public function forEach(callable $procedure): self{
        foreach($this->array as $key=>$value)
            $procedure($value, $key);

        return $this;
    }

    /**Returns a sorted copy of this MagicalArray
     * @return MagicalArray
     */
    public function sort(): MagicalArray{
        $arr = array_merge($this->array, []);
        sort($arr);
        return new MagicalArray($arr);
    }

    /**Sorts this MagicalArray
     * @return $this
     */
    public function sortInPlace(): self{
        sort($this->array);
        return $this;
    }

    /**
     * @param callable $sortComparator
     * @return MagicalArray
     */
    public function sortBy(callable $sortComparator): self{
        $arr = array_merge($this->array, []);
        usort($arr, $sortComparator);
        return new MagicalArray($arr);
    }

    public function sortInPlaceBy(callable $sortComparator): self{
        usort($this->array, $sortComparator);
        return $this;
    }


    /**Gives the size of this MagicalArray
     * @return int
     */
    public function size(): int{
        return $this->count();
    }


    /**An alias for size()
     * @return int
     */
    public function length(): int{
        return $this->size();
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
        return new ArrayIterator($this->array);
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset): bool{
        return isset($this->array[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset){
        return $this->__invoke($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value): void{
        if(is_null($offset))
            $this->array[] = $value;
        else
            $this->array[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset): void{
        unset($this->array[$offset]);
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize(): string{
        return serialize($this->array);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized): void{
        self::__construct(unserialize($serialized));
    }

    /**Allows to any MagicalArray to be passed to count() as an argument
     * @return int
     */
    public function count(): int{
        return count($this->array);
    }

    /**Creates an instance from a JSON string
     * @param string $json being the JSON string representing the object to create
     * @return MagicalArray
     */
    public static function fromJson(string $json): self{
        return new MagicalArray(json_decode($json, true));
    }

    /**Converts the instance back to JSON (as a string)
     * @return string
     */
    public function toJson(): string{
        return json_encode($this->array);
    }
}