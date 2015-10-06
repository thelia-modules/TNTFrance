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
use TNTFrance\Model\TntPriceWeight;
use TNTFrance\Model\TntPriceWeightQuery;


/**
 * This class defines the structure of the 'tnt_price_weight' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TntPriceWeightTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'TNTFrance.Model.Map.TntPriceWeightTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'tnt_price_weight';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\TNTFrance\\Model\\TntPriceWeight';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'TNTFrance.Model.TntPriceWeight';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the ID field
     */
    const ID = 'tnt_price_weight.ID';

    /**
     * the column name for the AREA_ID field
     */
    const AREA_ID = 'tnt_price_weight.AREA_ID';

    /**
     * the column name for the TNT_PRODUCT_LABEL field
     */
    const TNT_PRODUCT_LABEL = 'tnt_price_weight.TNT_PRODUCT_LABEL';

    /**
     * the column name for the TNT_PRODUCT_CODE field
     */
    const TNT_PRODUCT_CODE = 'tnt_price_weight.TNT_PRODUCT_CODE';

    /**
     * the column name for the WEIGHT field
     */
    const WEIGHT = 'tnt_price_weight.WEIGHT';

    /**
     * the column name for the PRICE field
     */
    const PRICE = 'tnt_price_weight.PRICE';

    /**
     * the column name for the PRICE_KG_SUP field
     */
    const PRICE_KG_SUP = 'tnt_price_weight.PRICE_KG_SUP';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'tnt_price_weight.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'tnt_price_weight.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('Id', 'AreaId', 'TntProductLabel', 'TntProductCode', 'Weight', 'Price', 'PriceKgSup', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'areaId', 'tntProductLabel', 'tntProductCode', 'weight', 'price', 'priceKgSup', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(TntPriceWeightTableMap::ID, TntPriceWeightTableMap::AREA_ID, TntPriceWeightTableMap::TNT_PRODUCT_LABEL, TntPriceWeightTableMap::TNT_PRODUCT_CODE, TntPriceWeightTableMap::WEIGHT, TntPriceWeightTableMap::PRICE, TntPriceWeightTableMap::PRICE_KG_SUP, TntPriceWeightTableMap::CREATED_AT, TntPriceWeightTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'AREA_ID', 'TNT_PRODUCT_LABEL', 'TNT_PRODUCT_CODE', 'WEIGHT', 'PRICE', 'PRICE_KG_SUP', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'area_id', 'tnt_product_label', 'tnt_product_code', 'weight', 'price', 'price_kg_sup', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'AreaId' => 1, 'TntProductLabel' => 2, 'TntProductCode' => 3, 'Weight' => 4, 'Price' => 5, 'PriceKgSup' => 6, 'CreatedAt' => 7, 'UpdatedAt' => 8, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'areaId' => 1, 'tntProductLabel' => 2, 'tntProductCode' => 3, 'weight' => 4, 'price' => 5, 'priceKgSup' => 6, 'createdAt' => 7, 'updatedAt' => 8, ),
        self::TYPE_COLNAME       => array(TntPriceWeightTableMap::ID => 0, TntPriceWeightTableMap::AREA_ID => 1, TntPriceWeightTableMap::TNT_PRODUCT_LABEL => 2, TntPriceWeightTableMap::TNT_PRODUCT_CODE => 3, TntPriceWeightTableMap::WEIGHT => 4, TntPriceWeightTableMap::PRICE => 5, TntPriceWeightTableMap::PRICE_KG_SUP => 6, TntPriceWeightTableMap::CREATED_AT => 7, TntPriceWeightTableMap::UPDATED_AT => 8, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'AREA_ID' => 1, 'TNT_PRODUCT_LABEL' => 2, 'TNT_PRODUCT_CODE' => 3, 'WEIGHT' => 4, 'PRICE' => 5, 'PRICE_KG_SUP' => 6, 'CREATED_AT' => 7, 'UPDATED_AT' => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'area_id' => 1, 'tnt_product_label' => 2, 'tnt_product_code' => 3, 'weight' => 4, 'price' => 5, 'price_kg_sup' => 6, 'created_at' => 7, 'updated_at' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('tnt_price_weight');
        $this->setPhpName('TntPriceWeight');
        $this->setClassName('\\TNTFrance\\Model\\TntPriceWeight');
        $this->setPackage('TNTFrance.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('AREA_ID', 'AreaId', 'INTEGER', 'area', 'ID', true, null, null);
        $this->addColumn('TNT_PRODUCT_LABEL', 'TntProductLabel', 'VARCHAR', false, 255, null);
        $this->addColumn('TNT_PRODUCT_CODE', 'TntProductCode', 'VARCHAR', true, 255, null);
        $this->addColumn('WEIGHT', 'Weight', 'FLOAT', true, null, 0);
        $this->addColumn('PRICE', 'Price', 'FLOAT', true, null, 0);
        $this->addColumn('PRICE_KG_SUP', 'PriceKgSup', 'FLOAT', true, null, 0);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Area', '\\Thelia\\Model\\Area', RelationMap::MANY_TO_ONE, array('area_id' => 'id', ), 'CASCADE', null);
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
        return $withPrefix ? TntPriceWeightTableMap::CLASS_DEFAULT : TntPriceWeightTableMap::OM_CLASS;
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
     * @return array (TntPriceWeight object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TntPriceWeightTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TntPriceWeightTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TntPriceWeightTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TntPriceWeightTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TntPriceWeightTableMap::addInstanceToPool($obj, $key);
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
            $key = TntPriceWeightTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TntPriceWeightTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TntPriceWeightTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TntPriceWeightTableMap::ID);
            $criteria->addSelectColumn(TntPriceWeightTableMap::AREA_ID);
            $criteria->addSelectColumn(TntPriceWeightTableMap::TNT_PRODUCT_LABEL);
            $criteria->addSelectColumn(TntPriceWeightTableMap::TNT_PRODUCT_CODE);
            $criteria->addSelectColumn(TntPriceWeightTableMap::WEIGHT);
            $criteria->addSelectColumn(TntPriceWeightTableMap::PRICE);
            $criteria->addSelectColumn(TntPriceWeightTableMap::PRICE_KG_SUP);
            $criteria->addSelectColumn(TntPriceWeightTableMap::CREATED_AT);
            $criteria->addSelectColumn(TntPriceWeightTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.AREA_ID');
            $criteria->addSelectColumn($alias . '.TNT_PRODUCT_LABEL');
            $criteria->addSelectColumn($alias . '.TNT_PRODUCT_CODE');
            $criteria->addSelectColumn($alias . '.WEIGHT');
            $criteria->addSelectColumn($alias . '.PRICE');
            $criteria->addSelectColumn($alias . '.PRICE_KG_SUP');
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
        return Propel::getServiceContainer()->getDatabaseMap(TntPriceWeightTableMap::DATABASE_NAME)->getTable(TntPriceWeightTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(TntPriceWeightTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(TntPriceWeightTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new TntPriceWeightTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a TntPriceWeight or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TntPriceWeight object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TntPriceWeightTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \TNTFrance\Model\TntPriceWeight) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TntPriceWeightTableMap::DATABASE_NAME);
            $criteria->add(TntPriceWeightTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = TntPriceWeightQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { TntPriceWeightTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { TntPriceWeightTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the tnt_price_weight table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TntPriceWeightQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TntPriceWeight or Criteria object.
     *
     * @param mixed               $criteria Criteria or TntPriceWeight object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TntPriceWeightTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TntPriceWeight object
        }

        if ($criteria->containsKey(TntPriceWeightTableMap::ID) && $criteria->keyContainsValue(TntPriceWeightTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TntPriceWeightTableMap::ID.')');
        }


        // Set the correct dbName
        $query = TntPriceWeightQuery::create()->mergeWith($criteria);

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

} // TntPriceWeightTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TntPriceWeightTableMap::buildTableMap();
