## Collection API

### Usages
The collection object may be instantiated via a static factory method returning a `CollectionInterface` or a constructor method.  
```php
//Factory from existing data
$collection = Collection::From(array $keyListOrArray,array $optionalDataList=[]);

//Factory from no data
$collection = Collection::New();

//Constuctor
$collection = new Collection();
```
### `Collection` Methods
#### Collection::From()
```php
static function From(array $keyListOrArray, array $optionalDataList=[]):CollectionInterface;
```
Returns a new object implementing `CollectionInterface` containing the supplied data.<br>
##### Arguments
`array $keyListOrArray` - An array that may be used in 2 ways. First, it may be used a list of keys that corresponds to a list of data. Second, it may be used as a `key=>value` array, in which case the second optional argument is ignored and the collection is built from the `key=>value` pairs.<br><br>
`array $optionalDataList` - An array that, if supplied will be treated as a list of data values that corresponds with the supplied list of keys.
##### Returns
a `CollectionInterface` object<br><br><br>


#### Collection::New()
```php
static function New():CollectionInterface
```
Returns a blank object `CollectionInterface` object.
##### Arguments
none.
##### Returns
a `CollectionInterface` object<br><br><br>

### `CollectionInterface` Methods
#### CollectionInterface::append()
```php
function append(mixed $key,mixed $value): CollectionInterface;
```
Attach a new collection item onto the end of the collection
##### Arguments
`mixed $key` - a key value. This value may be any data type.<br>
`mixed $data` - a data value. This value may be any data type.<br>

##### Returns
a mutated `CollectionInterface` object<br><br><br>


#### CollectionInterface::prepend()
```php
function prepend(mixed $key,mixed $value): CollectionInterface;
```
Attach a new collection item to the beginning of the collection
##### Arguments
`mixed $key` - a key value. This value may be any data type.<br>
`mixed $data` - a data value. This value may be any data type.<br>
##### Returns
a mutated `CollectionInterface` object<br><br><br>


#### CollectionInterface::shift()
```php
function shift(): CollectionInterface;
```
Remove and return the first collection item from the beginning of the list.
##### Arguments
none.
##### Returns
a `CollectionItemInterface` object<br><br><br>


#### CollectionInterface::pop()
```php
function pop(): CollectionInterface;
```
Remove and return the last collection item from the beginning of the list.
##### Arguments
none.
##### Returns
a `CollectionItemInterface` object<br><br><br>


#### CollectionInterface::first()
```php
function first(): CollectionInterface;
```
Return the first collection item from the beginning of the list without removing it from the collection.
##### Arguments
none.
##### Returns
a `CollectionItemInterface` object<br><br><br>


#### CollectionInterface::last()
```php
function last(): CollectionInterface;
```
Return the last collection item from the beginning of the list without removing it from the collection.
##### Arguments
none.
##### Returns
a `CollectionItemInterface` object<br><br><br>


#### CollectionInterface::setDataWhereKey()
```php
function setDataWhereKey(mixed $whereKey, mixed $value, bool $strict = false): CollectionInterface;
```
Set the data value(s) for the collection items containing a matching key. If more than one item contains a matching key, the data will be set for all items containing that key.
##### Arguments
`mixed $whereKey` - the key value to find and match<br>
`mixed $data` - the data that will replace the data in the items with matching keys<br>
`bool $strict` - if `TRUE`, the matching will be performed on a strict basis<br>
##### Returns
a mutated `CollectionInterface` object<br><br><br>


#### CollectionInterface::setKeyWhereData()
```php
function setKeyWhereData(mixed $whereData, mixed $key, bool $strict = false): CollectionInterface;
```
Set the data value(s) for the collection items containing a matching key. If more than one item contains a matching key, the data will be set for all items containing that key.
##### Arguments
`mixed $whereData` - the data value to find and match<br>
`mixed $key` - the key that will replace the key in the items with matching data<br>
`bool $strict` - if `TRUE`, the matching will be performed on a strict basis<br>
##### Returns
a mutated `CollectionInterface` object<br><br><br>


#### CollectionInterface::findDataWhere()
```php
function findDataWhere(mixed $data, mixed $key = null): CollectionInterface;
```
Find collection items with matching data and optionally matching key
##### Arguments
`mixed $data` - the data value to find and match<br>
`mixed $key` - if included, the data and key must both match<br>
##### Returns
a new `CollectionInterface` object containing matching items<br><br><br>


#### CollectionInterface::findKeysWhere()
```php
function findKeysWhere(mixed $key, mixed $data = null): CollectionInterface;
```
Find collection items with matching key and optionally matching data
##### Arguments
`mixed $key` - the key value to find and match<br>
`mixed $data` - if included, the key and data must both match<br>
##### Returns
a new `CollectionInterface` object containing matching items<br><br><br>


#### CollectionInterface::hasKey()
```php
function hasKey(mixed $key): bool;
```
Verify that a collection contains an item with a matching key.
##### Arguments
`mixed $key` - the key value to find and match<br>
##### Returns
`TRUE` if the collection contains an item with a matching key<br><br><br>


### `CollectionItemInterface` Methods
#### CollectionItemInterface::getKey()
```php
function getKey(): mixed;
```
Return the key of the collection item
##### Arguments
none.
##### Returns
the data contained in the key<br><br><br>


#### CollectionItemInterface::getValue()
```php
function getValue(): mixed;
```
Return the value of the collection item
##### Arguments
none.
##### Returns
the value contained in the data property<br><br><br>


#### CollectionItemInterface::getKeyType()
```php
function getKeyType(): string;
```
Return the data type of the key contained in the collection item
##### Arguments
none.
##### Returns
the data type of the key<br><br><br>


#### CollectionItemInterface::getDataType()
```php
function getDataType(): string;
```
Return the data type of the data contained in the collection item
##### Arguments
none.
##### Returns
the data type of the data<br><br><br>


#### CollectionItemInterface::setValue()
```php
function setValue(mixed $data): CollectionItemInterface;
```
Set the value of the data contained in the collection item
##### Arguments
`mixed $data` The data to place in the object
##### Returns
A mutated `CollectionItemInterface` object<br><br><br>


#### CollectionItemInterface::setKey()
```php
function setKey(mixed $key): CollectionItemInterface;
```
Set the value of the key contained in the collection item
##### Arguments
`mixed $key` The data to place in the object
##### Returns
A mutated `CollectionItemInterface` object


#### CollectionItemInterface::tuple()
```php
function tuple(): array;
```
Return the key and value as a tuple
##### Arguments
none
##### Returns
An array containing the key at index 0 and the value and index 1.