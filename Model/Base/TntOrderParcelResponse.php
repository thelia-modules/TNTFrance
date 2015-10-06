<?php

namespace TNTFrance\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use TNTFrance\Model\TntOrderParcelResponse as ChildTntOrderParcelResponse;
use TNTFrance\Model\TntOrderParcelResponseQuery as ChildTntOrderParcelResponseQuery;
use TNTFrance\Model\Map\TntOrderParcelResponseTableMap;
use Thelia\Model\OrderProduct as ChildOrderProduct;
use Thelia\Model\OrderProductQuery;

abstract class TntOrderParcelResponse implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\TNTFrance\\Model\\Map\\TntOrderParcelResponseTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the account_id field.
     * @var        int
     */
    protected $account_id;

    /**
     * The value for the order_product_id field.
     * @var        int
     */
    protected $order_product_id;

    /**
     * The value for the pick_up_number field.
     * @var        int
     */
    protected $pick_up_number;

    /**
     * The value for the file_name field.
     * @var        string
     */
    protected $file_name;

    /**
     * The value for the sequence_number field.
     * @var        int
     */
    protected $sequence_number;

    /**
     * The value for the parcel_number_id field.
     * @var        int
     */
    protected $parcel_number_id;

    /**
     * The value for the sticker_number field.
     * @var        int
     */
    protected $sticker_number;

    /**
     * The value for the tracking_url field.
     * @var        string
     */
    protected $tracking_url;

    /**
     * The value for the printed field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $printed;

    /**
     * The value for the weight field.
     * Note: this column has a database default value of: 0
     * @var        double
     */
    protected $weight;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * @var        OrderProduct
     */
    protected $aOrderProduct;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->printed = 0;
        $this->weight = 0;
    }

    /**
     * Initializes internal state of TNTFrance\Model\Base\TntOrderParcelResponse object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>TntOrderParcelResponse</code> instance.  If
     * <code>obj</code> is an instance of <code>TntOrderParcelResponse</code>, delegates to
     * <code>equals(TntOrderParcelResponse)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return TntOrderParcelResponse The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return TntOrderParcelResponse The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [account_id] column value.
     *
     * @return   int
     */
    public function getAccountId()
    {

        return $this->account_id;
    }

    /**
     * Get the [order_product_id] column value.
     *
     * @return   int
     */
    public function getOrderProductId()
    {

        return $this->order_product_id;
    }

    /**
     * Get the [pick_up_number] column value.
     *
     * @return   int
     */
    public function getPickUpNumber()
    {

        return $this->pick_up_number;
    }

    /**
     * Get the [file_name] column value.
     *
     * @return   string
     */
    public function getFileName()
    {

        return $this->file_name;
    }

    /**
     * Get the [sequence_number] column value.
     *
     * @return   int
     */
    public function getSequenceNumber()
    {

        return $this->sequence_number;
    }

    /**
     * Get the [parcel_number_id] column value.
     *
     * @return   int
     */
    public function getParcelNumberId()
    {

        return $this->parcel_number_id;
    }

    /**
     * Get the [sticker_number] column value.
     *
     * @return   int
     */
    public function getStickerNumber()
    {

        return $this->sticker_number;
    }

    /**
     * Get the [tracking_url] column value.
     *
     * @return   string
     */
    public function getTrackingUrl()
    {

        return $this->tracking_url;
    }

    /**
     * Get the [printed] column value.
     *
     * @return   int
     */
    public function getPrinted()
    {

        return $this->printed;
    }

    /**
     * Get the [weight] column value.
     *
     * @return   double
     */
    public function getWeight()
    {

        return $this->weight;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [account_id] column.
     *
     * @param      int $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setAccountId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->account_id !== $v) {
            $this->account_id = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::ACCOUNT_ID] = true;
        }


        return $this;
    } // setAccountId()

    /**
     * Set the value of [order_product_id] column.
     *
     * @param      int $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setOrderProductId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_product_id !== $v) {
            $this->order_product_id = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID] = true;
        }

        if ($this->aOrderProduct !== null && $this->aOrderProduct->getId() !== $v) {
            $this->aOrderProduct = null;
        }


        return $this;
    } // setOrderProductId()

    /**
     * Set the value of [pick_up_number] column.
     *
     * @param      int $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setPickUpNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->pick_up_number !== $v) {
            $this->pick_up_number = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::PICK_UP_NUMBER] = true;
        }


        return $this;
    } // setPickUpNumber()

    /**
     * Set the value of [file_name] column.
     *
     * @param      string $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setFileName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->file_name !== $v) {
            $this->file_name = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::FILE_NAME] = true;
        }


        return $this;
    } // setFileName()

    /**
     * Set the value of [sequence_number] column.
     *
     * @param      int $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setSequenceNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sequence_number !== $v) {
            $this->sequence_number = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::SEQUENCE_NUMBER] = true;
        }


        return $this;
    } // setSequenceNumber()

    /**
     * Set the value of [parcel_number_id] column.
     *
     * @param      int $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setParcelNumberId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parcel_number_id !== $v) {
            $this->parcel_number_id = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::PARCEL_NUMBER_ID] = true;
        }


        return $this;
    } // setParcelNumberId()

    /**
     * Set the value of [sticker_number] column.
     *
     * @param      int $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setStickerNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sticker_number !== $v) {
            $this->sticker_number = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::STICKER_NUMBER] = true;
        }


        return $this;
    } // setStickerNumber()

    /**
     * Set the value of [tracking_url] column.
     *
     * @param      string $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setTrackingUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tracking_url !== $v) {
            $this->tracking_url = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::TRACKING_URL] = true;
        }


        return $this;
    } // setTrackingUrl()

    /**
     * Set the value of [printed] column.
     *
     * @param      int $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setPrinted($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->printed !== $v) {
            $this->printed = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::PRINTED] = true;
        }


        return $this;
    } // setPrinted()

    /**
     * Set the value of [weight] column.
     *
     * @param      double $v new value
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setWeight($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->weight !== $v) {
            $this->weight = $v;
            $this->modifiedColumns[TntOrderParcelResponseTableMap::WEIGHT] = true;
        }


        return $this;
    } // setWeight()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[TntOrderParcelResponseTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[TntOrderParcelResponseTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->printed !== 0) {
                return false;
            }

            if ($this->weight !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('AccountId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->account_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('OrderProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_product_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('PickUpNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pick_up_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('FileName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->file_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('SequenceNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sequence_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('ParcelNumberId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parcel_number_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('StickerNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sticker_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('TrackingUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tracking_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('Printed', TableMap::TYPE_PHPNAME, $indexType)];
            $this->printed = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('Weight', TableMap::TYPE_PHPNAME, $indexType)];
            $this->weight = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : TntOrderParcelResponseTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 13; // 13 = TntOrderParcelResponseTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \TNTFrance\Model\TntOrderParcelResponse object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aOrderProduct !== null && $this->order_product_id !== $this->aOrderProduct->getId()) {
            $this->aOrderProduct = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TntOrderParcelResponseTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTntOrderParcelResponseQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aOrderProduct = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see TntOrderParcelResponse::setDeleted()
     * @see TntOrderParcelResponse::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TntOrderParcelResponseTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildTntOrderParcelResponseQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TntOrderParcelResponseTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(TntOrderParcelResponseTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(TntOrderParcelResponseTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(TntOrderParcelResponseTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                TntOrderParcelResponseTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aOrderProduct !== null) {
                if ($this->aOrderProduct->isModified() || $this->aOrderProduct->isNew()) {
                    $affectedRows += $this->aOrderProduct->save($con);
                }
                $this->setOrderProduct($this->aOrderProduct);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TntOrderParcelResponseTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TntOrderParcelResponseTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::ACCOUNT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ACCOUNT_ID';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_PRODUCT_ID';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::PICK_UP_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'PICK_UP_NUMBER';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::FILE_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'FILE_NAME';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::SEQUENCE_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'SEQUENCE_NUMBER';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::PARCEL_NUMBER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PARCEL_NUMBER_ID';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::STICKER_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'STICKER_NUMBER';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::TRACKING_URL)) {
            $modifiedColumns[':p' . $index++]  = 'TRACKING_URL';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::PRINTED)) {
            $modifiedColumns[':p' . $index++]  = 'PRINTED';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::WEIGHT)) {
            $modifiedColumns[':p' . $index++]  = 'WEIGHT';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO tnt_order_parcel_response (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'ACCOUNT_ID':
                        $stmt->bindValue($identifier, $this->account_id, PDO::PARAM_INT);
                        break;
                    case 'ORDER_PRODUCT_ID':
                        $stmt->bindValue($identifier, $this->order_product_id, PDO::PARAM_INT);
                        break;
                    case 'PICK_UP_NUMBER':
                        $stmt->bindValue($identifier, $this->pick_up_number, PDO::PARAM_INT);
                        break;
                    case 'FILE_NAME':
                        $stmt->bindValue($identifier, $this->file_name, PDO::PARAM_STR);
                        break;
                    case 'SEQUENCE_NUMBER':
                        $stmt->bindValue($identifier, $this->sequence_number, PDO::PARAM_INT);
                        break;
                    case 'PARCEL_NUMBER_ID':
                        $stmt->bindValue($identifier, $this->parcel_number_id, PDO::PARAM_INT);
                        break;
                    case 'STICKER_NUMBER':
                        $stmt->bindValue($identifier, $this->sticker_number, PDO::PARAM_INT);
                        break;
                    case 'TRACKING_URL':
                        $stmt->bindValue($identifier, $this->tracking_url, PDO::PARAM_STR);
                        break;
                    case 'PRINTED':
                        $stmt->bindValue($identifier, $this->printed, PDO::PARAM_INT);
                        break;
                    case 'WEIGHT':
                        $stmt->bindValue($identifier, $this->weight, PDO::PARAM_STR);
                        break;
                    case 'CREATED_AT':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'UPDATED_AT':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TntOrderParcelResponseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getAccountId();
                break;
            case 2:
                return $this->getOrderProductId();
                break;
            case 3:
                return $this->getPickUpNumber();
                break;
            case 4:
                return $this->getFileName();
                break;
            case 5:
                return $this->getSequenceNumber();
                break;
            case 6:
                return $this->getParcelNumberId();
                break;
            case 7:
                return $this->getStickerNumber();
                break;
            case 8:
                return $this->getTrackingUrl();
                break;
            case 9:
                return $this->getPrinted();
                break;
            case 10:
                return $this->getWeight();
                break;
            case 11:
                return $this->getCreatedAt();
                break;
            case 12:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['TntOrderParcelResponse'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['TntOrderParcelResponse'][$this->getPrimaryKey()] = true;
        $keys = TntOrderParcelResponseTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getAccountId(),
            $keys[2] => $this->getOrderProductId(),
            $keys[3] => $this->getPickUpNumber(),
            $keys[4] => $this->getFileName(),
            $keys[5] => $this->getSequenceNumber(),
            $keys[6] => $this->getParcelNumberId(),
            $keys[7] => $this->getStickerNumber(),
            $keys[8] => $this->getTrackingUrl(),
            $keys[9] => $this->getPrinted(),
            $keys[10] => $this->getWeight(),
            $keys[11] => $this->getCreatedAt(),
            $keys[12] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aOrderProduct) {
                $result['OrderProduct'] = $this->aOrderProduct->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TntOrderParcelResponseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setAccountId($value);
                break;
            case 2:
                $this->setOrderProductId($value);
                break;
            case 3:
                $this->setPickUpNumber($value);
                break;
            case 4:
                $this->setFileName($value);
                break;
            case 5:
                $this->setSequenceNumber($value);
                break;
            case 6:
                $this->setParcelNumberId($value);
                break;
            case 7:
                $this->setStickerNumber($value);
                break;
            case 8:
                $this->setTrackingUrl($value);
                break;
            case 9:
                $this->setPrinted($value);
                break;
            case 10:
                $this->setWeight($value);
                break;
            case 11:
                $this->setCreatedAt($value);
                break;
            case 12:
                $this->setUpdatedAt($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TntOrderParcelResponseTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAccountId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setOrderProductId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setPickUpNumber($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setFileName($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSequenceNumber($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setParcelNumberId($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setStickerNumber($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setTrackingUrl($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setPrinted($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setWeight($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setCreatedAt($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setUpdatedAt($arr[$keys[12]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TntOrderParcelResponseTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TntOrderParcelResponseTableMap::ID)) $criteria->add(TntOrderParcelResponseTableMap::ID, $this->id);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::ACCOUNT_ID)) $criteria->add(TntOrderParcelResponseTableMap::ACCOUNT_ID, $this->account_id);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID)) $criteria->add(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID, $this->order_product_id);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::PICK_UP_NUMBER)) $criteria->add(TntOrderParcelResponseTableMap::PICK_UP_NUMBER, $this->pick_up_number);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::FILE_NAME)) $criteria->add(TntOrderParcelResponseTableMap::FILE_NAME, $this->file_name);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::SEQUENCE_NUMBER)) $criteria->add(TntOrderParcelResponseTableMap::SEQUENCE_NUMBER, $this->sequence_number);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::PARCEL_NUMBER_ID)) $criteria->add(TntOrderParcelResponseTableMap::PARCEL_NUMBER_ID, $this->parcel_number_id);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::STICKER_NUMBER)) $criteria->add(TntOrderParcelResponseTableMap::STICKER_NUMBER, $this->sticker_number);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::TRACKING_URL)) $criteria->add(TntOrderParcelResponseTableMap::TRACKING_URL, $this->tracking_url);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::PRINTED)) $criteria->add(TntOrderParcelResponseTableMap::PRINTED, $this->printed);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::WEIGHT)) $criteria->add(TntOrderParcelResponseTableMap::WEIGHT, $this->weight);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::CREATED_AT)) $criteria->add(TntOrderParcelResponseTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(TntOrderParcelResponseTableMap::UPDATED_AT)) $criteria->add(TntOrderParcelResponseTableMap::UPDATED_AT, $this->updated_at);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(TntOrderParcelResponseTableMap::DATABASE_NAME);
        $criteria->add(TntOrderParcelResponseTableMap::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \TNTFrance\Model\TntOrderParcelResponse (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAccountId($this->getAccountId());
        $copyObj->setOrderProductId($this->getOrderProductId());
        $copyObj->setPickUpNumber($this->getPickUpNumber());
        $copyObj->setFileName($this->getFileName());
        $copyObj->setSequenceNumber($this->getSequenceNumber());
        $copyObj->setParcelNumberId($this->getParcelNumberId());
        $copyObj->setStickerNumber($this->getStickerNumber());
        $copyObj->setTrackingUrl($this->getTrackingUrl());
        $copyObj->setPrinted($this->getPrinted());
        $copyObj->setWeight($this->getWeight());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \TNTFrance\Model\TntOrderParcelResponse Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildOrderProduct object.
     *
     * @param                  ChildOrderProduct $v
     * @return                 \TNTFrance\Model\TntOrderParcelResponse The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrderProduct(ChildOrderProduct $v = null)
    {
        if ($v === null) {
            $this->setOrderProductId(NULL);
        } else {
            $this->setOrderProductId($v->getId());
        }

        $this->aOrderProduct = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildOrderProduct object, it will not be re-added.
        if ($v !== null) {
            $v->addTntOrderParcelResponse($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildOrderProduct object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildOrderProduct The associated ChildOrderProduct object.
     * @throws PropelException
     */
    public function getOrderProduct(ConnectionInterface $con = null)
    {
        if ($this->aOrderProduct === null && ($this->order_product_id !== null)) {
            $this->aOrderProduct = OrderProductQuery::create()->findPk($this->order_product_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrderProduct->addTntOrderParcelResponses($this);
             */
        }

        return $this->aOrderProduct;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->account_id = null;
        $this->order_product_id = null;
        $this->pick_up_number = null;
        $this->file_name = null;
        $this->sequence_number = null;
        $this->parcel_number_id = null;
        $this->sticker_number = null;
        $this->tracking_url = null;
        $this->printed = null;
        $this->weight = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aOrderProduct = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TntOrderParcelResponseTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildTntOrderParcelResponse The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[TntOrderParcelResponseTableMap::UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
