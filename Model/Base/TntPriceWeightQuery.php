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
use TNTFrance\Model\TntPriceWeight as ChildTntPriceWeight;
use TNTFrance\Model\TntPriceWeightQuery as ChildTntPriceWeightQuery;
use TNTFrance\Model\Map\TntPriceWeightTableMap;
use Thelia\Model\Area;

/**
 * Base class that represents a query for the 'tnt_price_weight' table.
 *
 *
 *
 * @method     ChildTntPriceWeightQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTntPriceWeightQuery orderByAreaId($order = Criteria::ASC) Order by the area_id column
 * @method     ChildTntPriceWeightQuery orderByTntProductLabel($order = Criteria::ASC) Order by the tnt_product_label column
 * @method     ChildTntPriceWeightQuery orderByTntProductCode($order = Criteria::ASC) Order by the tnt_product_code column
 * @method     ChildTntPriceWeightQuery orderByWeight($order = Criteria::ASC) Order by the weight column
 * @method     ChildTntPriceWeightQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildTntPriceWeightQuery orderByPriceKgSup($order = Criteria::ASC) Order by the price_kg_sup column
 * @method     ChildTntPriceWeightQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTntPriceWeightQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildTntPriceWeightQuery groupById() Group by the id column
 * @method     ChildTntPriceWeightQuery groupByAreaId() Group by the area_id column
 * @method     ChildTntPriceWeightQuery groupByTntProductLabel() Group by the tnt_product_label column
 * @method     ChildTntPriceWeightQuery groupByTntProductCode() Group by the tnt_product_code column
 * @method     ChildTntPriceWeightQuery groupByWeight() Group by the weight column
 * @method     ChildTntPriceWeightQuery groupByPrice() Group by the price column
 * @method     ChildTntPriceWeightQuery groupByPriceKgSup() Group by the price_kg_sup column
 * @method     ChildTntPriceWeightQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTntPriceWeightQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildTntPriceWeightQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTntPriceWeightQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTntPriceWeightQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTntPriceWeightQuery leftJoinArea($relationAlias = null) Adds a LEFT JOIN clause to the query using the Area relation
 * @method     ChildTntPriceWeightQuery rightJoinArea($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Area relation
 * @method     ChildTntPriceWeightQuery innerJoinArea($relationAlias = null) Adds a INNER JOIN clause to the query using the Area relation
 *
 * @method     ChildTntPriceWeight findOne(ConnectionInterface $con = null) Return the first ChildTntPriceWeight matching the query
 * @method     ChildTntPriceWeight findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTntPriceWeight matching the query, or a new ChildTntPriceWeight object populated from the query conditions when no match is found
 *
 * @method     ChildTntPriceWeight findOneById(int $id) Return the first ChildTntPriceWeight filtered by the id column
 * @method     ChildTntPriceWeight findOneByAreaId(int $area_id) Return the first ChildTntPriceWeight filtered by the area_id column
 * @method     ChildTntPriceWeight findOneByTntProductLabel(string $tnt_product_label) Return the first ChildTntPriceWeight filtered by the tnt_product_label column
 * @method     ChildTntPriceWeight findOneByTntProductCode(string $tnt_product_code) Return the first ChildTntPriceWeight filtered by the tnt_product_code column
 * @method     ChildTntPriceWeight findOneByWeight(double $weight) Return the first ChildTntPriceWeight filtered by the weight column
 * @method     ChildTntPriceWeight findOneByPrice(double $price) Return the first ChildTntPriceWeight filtered by the price column
 * @method     ChildTntPriceWeight findOneByPriceKgSup(double $price_kg_sup) Return the first ChildTntPriceWeight filtered by the price_kg_sup column
 * @method     ChildTntPriceWeight findOneByCreatedAt(string $created_at) Return the first ChildTntPriceWeight filtered by the created_at column
 * @method     ChildTntPriceWeight findOneByUpdatedAt(string $updated_at) Return the first ChildTntPriceWeight filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildTntPriceWeight objects filtered by the id column
 * @method     array findByAreaId(int $area_id) Return ChildTntPriceWeight objects filtered by the area_id column
 * @method     array findByTntProductLabel(string $tnt_product_label) Return ChildTntPriceWeight objects filtered by the tnt_product_label column
 * @method     array findByTntProductCode(string $tnt_product_code) Return ChildTntPriceWeight objects filtered by the tnt_product_code column
 * @method     array findByWeight(double $weight) Return ChildTntPriceWeight objects filtered by the weight column
 * @method     array findByPrice(double $price) Return ChildTntPriceWeight objects filtered by the price column
 * @method     array findByPriceKgSup(double $price_kg_sup) Return ChildTntPriceWeight objects filtered by the price_kg_sup column
 * @method     array findByCreatedAt(string $created_at) Return ChildTntPriceWeight objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildTntPriceWeight objects filtered by the updated_at column
 *
 */
abstract class TntPriceWeightQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \TNTFrance\Model\Base\TntPriceWeightQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\TNTFrance\\Model\\TntPriceWeight', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTntPriceWeightQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTntPriceWeightQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \TNTFrance\Model\TntPriceWeightQuery) {
            return $criteria;
        }
        $query = new \TNTFrance\Model\TntPriceWeightQuery();
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
     * @return ChildTntPriceWeight|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TntPriceWeightTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TntPriceWeightTableMap::DATABASE_NAME);
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
     * @return   ChildTntPriceWeight A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, AREA_ID, TNT_PRODUCT_LABEL, TNT_PRODUCT_CODE, WEIGHT, PRICE, PRICE_KG_SUP, CREATED_AT, UPDATED_AT FROM tnt_price_weight WHERE ID = :p0';
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
            $obj = new ChildTntPriceWeight();
            $obj->hydrate($row);
            TntPriceWeightTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTntPriceWeight|array|mixed the result, formatted by the current formatter
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
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TntPriceWeightTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TntPriceWeightTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntPriceWeightTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the area_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAreaId(1234); // WHERE area_id = 1234
     * $query->filterByAreaId(array(12, 34)); // WHERE area_id IN (12, 34)
     * $query->filterByAreaId(array('min' => 12)); // WHERE area_id > 12
     * </code>
     *
     * @see       filterByArea()
     *
     * @param     mixed $areaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByAreaId($areaId = null, $comparison = null)
    {
        if (is_array($areaId)) {
            $useMinMax = false;
            if (isset($areaId['min'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::AREA_ID, $areaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($areaId['max'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::AREA_ID, $areaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntPriceWeightTableMap::AREA_ID, $areaId, $comparison);
    }

    /**
     * Filter the query on the tnt_product_label column
     *
     * Example usage:
     * <code>
     * $query->filterByTntProductLabel('fooValue');   // WHERE tnt_product_label = 'fooValue'
     * $query->filterByTntProductLabel('%fooValue%'); // WHERE tnt_product_label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tntProductLabel The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByTntProductLabel($tntProductLabel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tntProductLabel)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tntProductLabel)) {
                $tntProductLabel = str_replace('*', '%', $tntProductLabel);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TntPriceWeightTableMap::TNT_PRODUCT_LABEL, $tntProductLabel, $comparison);
    }

    /**
     * Filter the query on the tnt_product_code column
     *
     * Example usage:
     * <code>
     * $query->filterByTntProductCode('fooValue');   // WHERE tnt_product_code = 'fooValue'
     * $query->filterByTntProductCode('%fooValue%'); // WHERE tnt_product_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tntProductCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByTntProductCode($tntProductCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tntProductCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tntProductCode)) {
                $tntProductCode = str_replace('*', '%', $tntProductCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TntPriceWeightTableMap::TNT_PRODUCT_CODE, $tntProductCode, $comparison);
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
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByWeight($weight = null, $comparison = null)
    {
        if (is_array($weight)) {
            $useMinMax = false;
            if (isset($weight['min'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::WEIGHT, $weight['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weight['max'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::WEIGHT, $weight['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntPriceWeightTableMap::WEIGHT, $weight, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntPriceWeightTableMap::PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the price_kg_sup column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceKgSup(1234); // WHERE price_kg_sup = 1234
     * $query->filterByPriceKgSup(array(12, 34)); // WHERE price_kg_sup IN (12, 34)
     * $query->filterByPriceKgSup(array('min' => 12)); // WHERE price_kg_sup > 12
     * </code>
     *
     * @param     mixed $priceKgSup The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByPriceKgSup($priceKgSup = null, $comparison = null)
    {
        if (is_array($priceKgSup)) {
            $useMinMax = false;
            if (isset($priceKgSup['min'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::PRICE_KG_SUP, $priceKgSup['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceKgSup['max'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::PRICE_KG_SUP, $priceKgSup['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntPriceWeightTableMap::PRICE_KG_SUP, $priceKgSup, $comparison);
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
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntPriceWeightTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(TntPriceWeightTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TntPriceWeightTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Area object
     *
     * @param \Thelia\Model\Area|ObjectCollection $area The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function filterByArea($area, $comparison = null)
    {
        if ($area instanceof \Thelia\Model\Area) {
            return $this
                ->addUsingAlias(TntPriceWeightTableMap::AREA_ID, $area->getId(), $comparison);
        } elseif ($area instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TntPriceWeightTableMap::AREA_ID, $area->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByArea() only accepts arguments of type \Thelia\Model\Area or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Area relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function joinArea($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Area');

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
            $this->addJoinObject($join, 'Area');
        }

        return $this;
    }

    /**
     * Use the Area relation Area object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\AreaQuery A secondary query class using the current class as primary query
     */
    public function useAreaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArea($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Area', '\Thelia\Model\AreaQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTntPriceWeight $tntPriceWeight Object to remove from the list of results
     *
     * @return ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function prune($tntPriceWeight = null)
    {
        if ($tntPriceWeight) {
            $this->addUsingAlias(TntPriceWeightTableMap::ID, $tntPriceWeight->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the tnt_price_weight table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TntPriceWeightTableMap::DATABASE_NAME);
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
            TntPriceWeightTableMap::clearInstancePool();
            TntPriceWeightTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildTntPriceWeight or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildTntPriceWeight object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TntPriceWeightTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TntPriceWeightTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        TntPriceWeightTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TntPriceWeightTableMap::clearRelatedInstancePool();
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
     * @return     ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TntPriceWeightTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TntPriceWeightTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TntPriceWeightTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TntPriceWeightTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TntPriceWeightTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildTntPriceWeightQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TntPriceWeightTableMap::CREATED_AT);
    }

} // TntPriceWeightQuery
