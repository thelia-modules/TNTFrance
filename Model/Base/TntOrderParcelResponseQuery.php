<?php

namespace TNTFrance\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use TNTFrance\Model\TntOrderParcelResponse as ChildTntOrderParcelResponse;
use TNTFrance\Model\TntOrderParcelResponseQuery as ChildTntOrderParcelResponseQuery;
use TNTFrance\Model\Map\TntOrderParcelResponseTableMap;
use Thelia\Model\OrderProduct;

/**
 * Base class that represents a query for the 'tnt_order_parcel_response' table.
 *
 *
 *
 * @method     ChildTntOrderParcelResponseQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTntOrderParcelResponseQuery orderByOrderProductId($order = Criteria::ASC) Order by the order_product_id column
 * @method     ChildTntOrderParcelResponseQuery orderByPickUpNumber($order = Criteria::ASC) Order by the pick_up_number column
 * @method     ChildTntOrderParcelResponseQuery orderByFileName($order = Criteria::ASC) Order by the file_name column
 * @method     ChildTntOrderParcelResponseQuery orderBySequenceNumber($order = Criteria::ASC) Order by the sequence_number column
 * @method     ChildTntOrderParcelResponseQuery orderByParcelNumberId($order = Criteria::ASC) Order by the parcel_number_id column
 * @method     ChildTntOrderParcelResponseQuery orderByStickerNumber($order = Criteria::ASC) Order by the sticker_number column
 * @method     ChildTntOrderParcelResponseQuery orderByTrackingUrl($order = Criteria::ASC) Order by the tracking_url column
 * @method     ChildTntOrderParcelResponseQuery orderByPrinted($order = Criteria::ASC) Order by the printed column
 * @method     ChildTntOrderParcelResponseQuery orderByWeight($order = Criteria::ASC) Order by the weight column
 * @method     ChildTntOrderParcelResponseQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTntOrderParcelResponseQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildTntOrderParcelResponseQuery groupById() Group by the id column
 * @method     ChildTntOrderParcelResponseQuery groupByOrderProductId() Group by the order_product_id column
 * @method     ChildTntOrderParcelResponseQuery groupByPickUpNumber() Group by the pick_up_number column
 * @method     ChildTntOrderParcelResponseQuery groupByFileName() Group by the file_name column
 * @method     ChildTntOrderParcelResponseQuery groupBySequenceNumber() Group by the sequence_number column
 * @method     ChildTntOrderParcelResponseQuery groupByParcelNumberId() Group by the parcel_number_id column
 * @method     ChildTntOrderParcelResponseQuery groupByStickerNumber() Group by the sticker_number column
 * @method     ChildTntOrderParcelResponseQuery groupByTrackingUrl() Group by the tracking_url column
 * @method     ChildTntOrderParcelResponseQuery groupByPrinted() Group by the printed column
 * @method     ChildTntOrderParcelResponseQuery groupByWeight() Group by the weight column
 * @method     ChildTntOrderParcelResponseQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTntOrderParcelResponseQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildTntOrderParcelResponseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTntOrderParcelResponseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTntOrderParcelResponseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTntOrderParcelResponseQuery leftJoinOrderProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderProduct relation
 * @method     ChildTntOrderParcelResponseQuery rightJoinOrderProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderProduct relation
 * @method     ChildTntOrderParcelResponseQuery innerJoinOrderProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderProduct relation
 *
 * @method     ChildTntOrderParcelResponse findOne(ConnectionInterface $con = null) Return the first ChildTntOrderParcelResponse matching the query
 * @method     ChildTntOrderParcelResponse findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTntOrderParcelResponse matching the query, or a new ChildTntOrderParcelResponse object populated from the query conditions when no match is found
 *
 * @method     ChildTntOrderParcelResponse findOneById(int $id) Return the first ChildTntOrderParcelResponse filtered by the id column
 * @method     ChildTntOrderParcelResponse findOneByOrderProductId(int $order_product_id) Return the first ChildTntOrderParcelResponse filtered by the order_product_id column
 * @method     ChildTntOrderParcelResponse findOneByPickUpNumber(int $pick_up_number) Return the first ChildTntOrderParcelResponse filtered by the pick_up_number column
 * @method     ChildTntOrderParcelResponse findOneByFileName(string $file_name) Return the first ChildTntOrderParcelResponse filtered by the file_name column
 * @method     ChildTntOrderParcelResponse findOneBySequenceNumber(int $sequence_number) Return the first ChildTntOrderParcelResponse filtered by the sequence_number column
 * @method     ChildTntOrderParcelResponse findOneByParcelNumberId(int $parcel_number_id) Return the first ChildTntOrderParcelResponse filtered by the parcel_number_id column
 * @method     ChildTntOrderParcelResponse findOneByStickerNumber(int $sticker_number) Return the first ChildTntOrderParcelResponse filtered by the sticker_number column
 * @method     ChildTntOrderParcelResponse findOneByTrackingUrl(string $tracking_url) Return the first ChildTntOrderParcelResponse filtered by the tracking_url column
 * @method     ChildTntOrderParcelResponse findOneByPrinted(int $printed) Return the first ChildTntOrderParcelResponse filtered by the printed column
 * @method     ChildTntOrderParcelResponse findOneByWeight(double $weight) Return the first ChildTntOrderParcelResponse filtered by the weight column
 * @method     ChildTntOrderParcelResponse findOneByCreatedAt(string $created_at) Return the first ChildTntOrderParcelResponse filtered by the created_at column
 * @method     ChildTntOrderParcelResponse findOneByUpdatedAt(string $updated_at) Return the first ChildTntOrderParcelResponse filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildTntOrderParcelResponse objects filtered by the id column
 * @method     array findByOrderProductId(int $order_product_id) Return ChildTntOrderParcelResponse objects filtered by the order_product_id column
 * @method     array findByPickUpNumber(int $pick_up_number) Return ChildTntOrderParcelResponse objects filtered by the pick_up_number column
 * @method     array findByFileName(string $file_name) Return ChildTntOrderParcelResponse objects filtered by the file_name column
 * @method     array findBySequenceNumber(int $sequence_number) Return ChildTntOrderParcelResponse objects filtered by the sequence_number column
 * @method     array findByParcelNumberId(int $parcel_number_id) Return ChildTntOrderParcelResponse objects filtered by the parcel_number_id column
 * @method     array findByStickerNumber(int $sticker_number) Return ChildTntOrderParcelResponse objects filtered by the sticker_number column
 * @method     array findByTrackingUrl(string $tracking_url) Return ChildTntOrderParcelResponse objects filtered by the tracking_url column
 * @method     array findByPrinted(int $printed) Return ChildTntOrderParcelResponse objects filtered by the printed column
 * @method     array findByWeight(double $weight) Return ChildTntOrderParcelResponse objects filtered by the weight column
 * @method     array findByCreatedAt(string $created_at) Return ChildTntOrderParcelResponse objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildTntOrderParcelResponse objects filtered by the updated_at column
 *
 */
abstract class TntOrderParcelResponseQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \TNTFrance\Model\Base\TntOrderParcelResponseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\TNTFrance\\Model\\TntOrderParcelResponse', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTntOrderParcelResponseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTntOrderParcelResponseQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \TNTFrance\Model\TntOrderParcelResponseQuery) {
            return $criteria;
        }
        $query = new \TNTFrance\Model\TntOrderParcelResponseQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildTntOrderParcelResponse|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TntOrderParcelResponseTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TntOrderParcelResponseTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildTntOrderParcelResponse A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ORDER_PRODUCT_ID, PICK_UP_NUMBER, FILE_NAME, SEQUENCE_NUMBER, PARCEL_NUMBER_ID, STICKER_NUMBER, TRACKING_URL, PRINTED, WEIGHT, CREATED_AT, UPDATED_AT FROM tnt_order_parcel_response WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildTntOrderParcelResponse();
            $obj->hydrate($row);
            TntOrderParcelResponseTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildTntOrderParcelResponse|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the order_product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderProductId(1234); // WHERE order_product_id = 1234
     * $query->filterByOrderProductId(array(12, 34)); // WHERE order_product_id IN (12, 34)
     * $query->filterByOrderProductId(array('min' => 12)); // WHERE order_product_id > 12
     * </code>
     *
     * @see       filterByOrderProduct()
     *
     * @param     mixed $orderProductId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByOrderProductId($orderProductId = null, $comparison = null)
    {
        if (is_array($orderProductId)) {
            $useMinMax = false;
            if (isset($orderProductId['min'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID, $orderProductId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderProductId['max'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID, $orderProductId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID, $orderProductId, $comparison);
    }

    /**
     * Filter the query on the pick_up_number column
     *
     * Example usage:
     * <code>
     * $query->filterByPickUpNumber(1234); // WHERE pick_up_number = 1234
     * $query->filterByPickUpNumber(array(12, 34)); // WHERE pick_up_number IN (12, 34)
     * $query->filterByPickUpNumber(array('min' => 12)); // WHERE pick_up_number > 12
     * </code>
     *
     * @param     mixed $pickUpNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByPickUpNumber($pickUpNumber = null, $comparison = null)
    {
        if (is_array($pickUpNumber)) {
            $useMinMax = false;
            if (isset($pickUpNumber['min'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::PICK_UP_NUMBER, $pickUpNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pickUpNumber['max'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::PICK_UP_NUMBER, $pickUpNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::PICK_UP_NUMBER, $pickUpNumber, $comparison);
    }

    /**
     * Filter the query on the file_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFileName('fooValue');   // WHERE file_name = 'fooValue'
     * $query->filterByFileName('%fooValue%'); // WHERE file_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fileName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByFileName($fileName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fileName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fileName)) {
                $fileName = str_replace('*', '%', $fileName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::FILE_NAME, $fileName, $comparison);
    }

    /**
     * Filter the query on the sequence_number column
     *
     * Example usage:
     * <code>
     * $query->filterBySequenceNumber(1234); // WHERE sequence_number = 1234
     * $query->filterBySequenceNumber(array(12, 34)); // WHERE sequence_number IN (12, 34)
     * $query->filterBySequenceNumber(array('min' => 12)); // WHERE sequence_number > 12
     * </code>
     *
     * @param     mixed $sequenceNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterBySequenceNumber($sequenceNumber = null, $comparison = null)
    {
        if (is_array($sequenceNumber)) {
            $useMinMax = false;
            if (isset($sequenceNumber['min'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::SEQUENCE_NUMBER, $sequenceNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sequenceNumber['max'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::SEQUENCE_NUMBER, $sequenceNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::SEQUENCE_NUMBER, $sequenceNumber, $comparison);
    }

    /**
     * Filter the query on the parcel_number_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParcelNumberId(1234); // WHERE parcel_number_id = 1234
     * $query->filterByParcelNumberId(array(12, 34)); // WHERE parcel_number_id IN (12, 34)
     * $query->filterByParcelNumberId(array('min' => 12)); // WHERE parcel_number_id > 12
     * </code>
     *
     * @param     mixed $parcelNumberId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByParcelNumberId($parcelNumberId = null, $comparison = null)
    {
        if (is_array($parcelNumberId)) {
            $useMinMax = false;
            if (isset($parcelNumberId['min'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::PARCEL_NUMBER_ID, $parcelNumberId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parcelNumberId['max'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::PARCEL_NUMBER_ID, $parcelNumberId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::PARCEL_NUMBER_ID, $parcelNumberId, $comparison);
    }

    /**
     * Filter the query on the sticker_number column
     *
     * Example usage:
     * <code>
     * $query->filterByStickerNumber(1234); // WHERE sticker_number = 1234
     * $query->filterByStickerNumber(array(12, 34)); // WHERE sticker_number IN (12, 34)
     * $query->filterByStickerNumber(array('min' => 12)); // WHERE sticker_number > 12
     * </code>
     *
     * @param     mixed $stickerNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByStickerNumber($stickerNumber = null, $comparison = null)
    {
        if (is_array($stickerNumber)) {
            $useMinMax = false;
            if (isset($stickerNumber['min'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::STICKER_NUMBER, $stickerNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stickerNumber['max'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::STICKER_NUMBER, $stickerNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::STICKER_NUMBER, $stickerNumber, $comparison);
    }

    /**
     * Filter the query on the tracking_url column
     *
     * Example usage:
     * <code>
     * $query->filterByTrackingUrl('fooValue');   // WHERE tracking_url = 'fooValue'
     * $query->filterByTrackingUrl('%fooValue%'); // WHERE tracking_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $trackingUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByTrackingUrl($trackingUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($trackingUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $trackingUrl)) {
                $trackingUrl = str_replace('*', '%', $trackingUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::TRACKING_URL, $trackingUrl, $comparison);
    }

    /**
     * Filter the query on the printed column
     *
     * Example usage:
     * <code>
     * $query->filterByPrinted(1234); // WHERE printed = 1234
     * $query->filterByPrinted(array(12, 34)); // WHERE printed IN (12, 34)
     * $query->filterByPrinted(array('min' => 12)); // WHERE printed > 12
     * </code>
     *
     * @param     mixed $printed The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByPrinted($printed = null, $comparison = null)
    {
        if (is_array($printed)) {
            $useMinMax = false;
            if (isset($printed['min'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::PRINTED, $printed['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($printed['max'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::PRINTED, $printed['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::PRINTED, $printed, $comparison);
    }

    /**
     * Filter the query on the weight column
     *
     * Example usage:
     * <code>
     * $query->filterByWeight(1234); // WHERE weight = 1234
     * $query->filterByWeight(array(12, 34)); // WHERE weight IN (12, 34)
     * $query->filterByWeight(array('min' => 12)); // WHERE weight > 12
     * </code>
     *
     * @param     mixed $weight The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByWeight($weight = null, $comparison = null)
    {
        if (is_array($weight)) {
            $useMinMax = false;
            if (isset($weight['min'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::WEIGHT, $weight['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weight['max'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::WEIGHT, $weight['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::WEIGHT, $weight, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(TntOrderParcelResponseTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntOrderParcelResponseTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\OrderProduct object
     *
     * @param \Thelia\Model\OrderProduct|ObjectCollection $orderProduct The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function filterByOrderProduct($orderProduct, $comparison = null)
    {
        if ($orderProduct instanceof \Thelia\Model\OrderProduct) {
            return $this
                ->addUsingAlias(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID, $orderProduct->getId(), $comparison);
        } elseif ($orderProduct instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID, $orderProduct->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrderProduct() only accepts arguments of type \Thelia\Model\OrderProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderProduct relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function joinOrderProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderProduct');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'OrderProduct');
        }

        return $this;
    }

    /**
     * Use the OrderProduct relation OrderProduct object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\OrderProductQuery A secondary query class using the current class as primary query
     */
    public function useOrderProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrderProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderProduct', '\Thelia\Model\OrderProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTntOrderParcelResponse $tntOrderParcelResponse Object to remove from the list of results
     *
     * @return ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function prune($tntOrderParcelResponse = null)
    {
        if ($tntOrderParcelResponse) {
            $this->addUsingAlias(TntOrderParcelResponseTableMap::ID, $tntOrderParcelResponse->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the tnt_order_parcel_response table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TntOrderParcelResponseTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TntOrderParcelResponseTableMap::clearInstancePool();
            TntOrderParcelResponseTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildTntOrderParcelResponse or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildTntOrderParcelResponse object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TntOrderParcelResponseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TntOrderParcelResponseTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        TntOrderParcelResponseTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TntOrderParcelResponseTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TntOrderParcelResponseTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TntOrderParcelResponseTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TntOrderParcelResponseTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TntOrderParcelResponseTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TntOrderParcelResponseTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildTntOrderParcelResponseQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TntOrderParcelResponseTableMap::CREATED_AT);
    }

} // TntOrderParcelResponseQuery
