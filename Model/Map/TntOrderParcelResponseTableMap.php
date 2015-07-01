<?php

namespace TNTFrance\Model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use TNTFrance\Model\TntOrderParcelResponse;
use TNTFrance\Model\TntOrderParcelResponseQuery;


/**
 * This class defines the structure of the 'tnt_order_parcel_response' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TntOrderParcelResponseTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'TNTFrance.Model.Map.TntOrderParcelResponseTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'tnt_order_parcel_response';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\TNTFrance\\Model\\TntOrderParcelResponse';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'TNTFrance.Model.TntOrderParcelResponse';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the ID field
     */
    const ID = 'tnt_order_parcel_response.ID';

    /**
     * the column name for the ORDER_PRODUCT_ID field
     */
    const ORDER_PRODUCT_ID = 'tnt_order_parcel_response.ORDER_PRODUCT_ID';

    /**
     * the column name for the PICK_UP_NUMBER field
     */
    const PICK_UP_NUMBER = 'tnt_order_parcel_response.PICK_UP_NUMBER';

    /**
     * the column name for the FILE_NAME field
     */
    const FILE_NAME = 'tnt_order_parcel_response.FILE_NAME';

    /**
     * the column name for the SEQUENCE_NUMBER field
     */
    const SEQUENCE_NUMBER = 'tnt_order_parcel_response.SEQUENCE_NUMBER';

    /**
     * the column name for the PARCEL_NUMBER_ID field
     */
    const PARCEL_NUMBER_ID = 'tnt_order_parcel_response.PARCEL_NUMBER_ID';

    /**
     * the column name for the STICKER_NUMBER field
     */
    const STICKER_NUMBER = 'tnt_order_parcel_response.STICKER_NUMBER';

    /**
     * the column name for the TRACKING_URL field
     */
    const TRACKING_URL = 'tnt_order_parcel_response.TRACKING_URL';

    /**
     * the column name for the PRINTED field
     */
    const PRINTED = 'tnt_order_parcel_response.PRINTED';

    /**
     * the column name for the WEIGHT field
     */
    const WEIGHT = 'tnt_order_parcel_response.WEIGHT';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'tnt_order_parcel_response.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'tnt_order_parcel_response.UPDATED_AT';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'OrderProductId', 'PickUpNumber', 'FileName', 'SequenceNumber', 'ParcelNumberId', 'StickerNumber', 'TrackingUrl', 'Printed', 'Weight', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'orderProductId', 'pickUpNumber', 'fileName', 'sequenceNumber', 'parcelNumberId', 'stickerNumber', 'trackingUrl', 'printed', 'weight', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(TntOrderParcelResponseTableMap::ID, TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID, TntOrderParcelResponseTableMap::PICK_UP_NUMBER, TntOrderParcelResponseTableMap::FILE_NAME, TntOrderParcelResponseTableMap::SEQUENCE_NUMBER, TntOrderParcelResponseTableMap::PARCEL_NUMBER_ID, TntOrderParcelResponseTableMap::STICKER_NUMBER, TntOrderParcelResponseTableMap::TRACKING_URL, TntOrderParcelResponseTableMap::PRINTED, TntOrderParcelResponseTableMap::WEIGHT, TntOrderParcelResponseTableMap::CREATED_AT, TntOrderParcelResponseTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'ORDER_PRODUCT_ID', 'PICK_UP_NUMBER', 'FILE_NAME', 'SEQUENCE_NUMBER', 'PARCEL_NUMBER_ID', 'STICKER_NUMBER', 'TRACKING_URL', 'PRINTED', 'WEIGHT', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'order_product_id', 'pick_up_number', 'file_name', 'sequence_number', 'parcel_number_id', 'sticker_number', 'tracking_url', 'printed', 'weight', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'OrderProductId' => 1, 'PickUpNumber' => 2, 'FileName' => 3, 'SequenceNumber' => 4, 'ParcelNumberId' => 5, 'StickerNumber' => 6, 'TrackingUrl' => 7, 'Printed' => 8, 'Weight' => 9, 'CreatedAt' => 10, 'UpdatedAt' => 11, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'orderProductId' => 1, 'pickUpNumber' => 2, 'fileName' => 3, 'sequenceNumber' => 4, 'parcelNumberId' => 5, 'stickerNumber' => 6, 'trackingUrl' => 7, 'printed' => 8, 'weight' => 9, 'createdAt' => 10, 'updatedAt' => 11, ),
        self::TYPE_COLNAME       => array(TntOrderParcelResponseTableMap::ID => 0, TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID => 1, TntOrderParcelResponseTableMap::PICK_UP_NUMBER => 2, TntOrderParcelResponseTableMap::FILE_NAME => 3, TntOrderParcelResponseTableMap::SEQUENCE_NUMBER => 4, TntOrderParcelResponseTableMap::PARCEL_NUMBER_ID => 5, TntOrderParcelResponseTableMap::STICKER_NUMBER => 6, TntOrderParcelResponseTableMap::TRACKING_URL => 7, TntOrderParcelResponseTableMap::PRINTED => 8, TntOrderParcelResponseTableMap::WEIGHT => 9, TntOrderParcelResponseTableMap::CREATED_AT => 10, TntOrderParcelResponseTableMap::UPDATED_AT => 11, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'ORDER_PRODUCT_ID' => 1, 'PICK_UP_NUMBER' => 2, 'FILE_NAME' => 3, 'SEQUENCE_NUMBER' => 4, 'PARCEL_NUMBER_ID' => 5, 'STICKER_NUMBER' => 6, 'TRACKING_URL' => 7, 'PRINTED' => 8, 'WEIGHT' => 9, 'CREATED_AT' => 10, 'UPDATED_AT' => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'order_product_id' => 1, 'pick_up_number' => 2, 'file_name' => 3, 'sequence_number' => 4, 'parcel_number_id' => 5, 'sticker_number' => 6, 'tracking_url' => 7, 'printed' => 8, 'weight' => 9, 'created_at' => 10, 'updated_at' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('tnt_order_parcel_response');
        $this->setPhpName('TntOrderParcelResponse');
        $this->setClassName('\\TNTFrance\\Model\\TntOrderParcelResponse');
        $this->setPackage('TNTFrance.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('ORDER_PRODUCT_ID', 'OrderProductId', 'INTEGER', 'order_product', 'ID', true, null, null);
        $this->addColumn('PICK_UP_NUMBER', 'PickUpNumber', 'INTEGER', true, null, null);
        $this->addColumn('FILE_NAME', 'FileName', 'VARCHAR', false, 255, null);
        $this->addColumn('SEQUENCE_NUMBER', 'SequenceNumber', 'INTEGER', true, null, null);
        $this->addColumn('PARCEL_NUMBER_ID', 'ParcelNumberId', 'INTEGER', false, null, null);
        $this->addColumn('STICKER_NUMBER', 'StickerNumber', 'INTEGER', false, null, null);
        $this->addColumn('TRACKING_URL', 'TrackingUrl', 'VARCHAR', true, 255, null);
        $this->addColumn('PRINTED', 'Printed', 'TINYINT', false, null, 0);
        $this->addColumn('WEIGHT', 'Weight', 'FLOAT', false, null, 0);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('OrderProduct', '\\Thelia\\Model\\OrderProduct', RelationMap::MANY_TO_ONE, array('order_product_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? TntOrderParcelResponseTableMap::CLASS_DEFAULT : TntOrderParcelResponseTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (TntOrderParcelResponse object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TntOrderParcelResponseTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TntOrderParcelResponseTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TntOrderParcelResponseTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TntOrderParcelResponseTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TntOrderParcelResponseTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = TntOrderParcelResponseTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TntOrderParcelResponseTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TntOrderParcelResponseTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::ID);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::PICK_UP_NUMBER);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::FILE_NAME);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::SEQUENCE_NUMBER);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::PARCEL_NUMBER_ID);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::STICKER_NUMBER);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::TRACKING_URL);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::PRINTED);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::WEIGHT);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::CREATED_AT);
            $criteria->addSelectColumn(TntOrderParcelResponseTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.ORDER_PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.PICK_UP_NUMBER');
            $criteria->addSelectColumn($alias . '.FILE_NAME');
            $criteria->addSelectColumn($alias . '.SEQUENCE_NUMBER');
            $criteria->addSelectColumn($alias . '.PARCEL_NUMBER_ID');
            $criteria->addSelectColumn($alias . '.STICKER_NUMBER');
            $criteria->addSelectColumn($alias . '.TRACKING_URL');
            $criteria->addSelectColumn($alias . '.PRINTED');
            $criteria->addSelectColumn($alias . '.WEIGHT');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(TntOrderParcelResponseTableMap::DATABASE_NAME)->getTable(TntOrderParcelResponseTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(TntOrderParcelResponseTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(TntOrderParcelResponseTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new TntOrderParcelResponseTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a TntOrderParcelResponse or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TntOrderParcelResponse object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TntOrderParcelResponseTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \TNTFrance\Model\TntOrderParcelResponse) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TntOrderParcelResponseTableMap::DATABASE_NAME);
            $criteria->add(TntOrderParcelResponseTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = TntOrderParcelResponseQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { TntOrderParcelResponseTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { TntOrderParcelResponseTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the tnt_order_parcel_response table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TntOrderParcelResponseQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TntOrderParcelResponse or Criteria object.
     *
     * @param mixed               $criteria Criteria or TntOrderParcelResponse object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TntOrderParcelResponseTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TntOrderParcelResponse object
        }

        if ($criteria->containsKey(TntOrderParcelResponseTableMap::ID) && $criteria->keyContainsValue(TntOrderParcelResponseTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TntOrderParcelResponseTableMap::ID.')');
        }


        // Set the correct dbName
        $query = TntOrderParcelResponseQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // TntOrderParcelResponseTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TntOrderParcelResponseTableMap::buildTableMap();
