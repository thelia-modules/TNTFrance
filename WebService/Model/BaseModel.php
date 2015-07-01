<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace TNTFrance\WebService\Model;

use InvalidArgumentException;

/**
 * Class BaseModel
 * @author Julien Chanséaume <julien@thelia.net>
 */
abstract class BaseModel
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Symfony\Component\Serializer\Exception\InvalidArgumentException
     * @throws \BadFunctionCallException
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func($this->$name, $arguments);
        } else {
            if (substr($name, 0, 3) === "get") {
                if (!empty($arguments)) {
                    throw new InvalidArgumentException("The function ".$name." in ".get_class($this)." doesn't take any argument.");
                }

                $realName = $this->getProprietyName($name);
                if (property_exists($this, $realName)) {
                    return $this->$realName;
                }

            } elseif (substr($name, 0, 3) === "set") {
                if (count($arguments) !== 1) {
                    throw new InvalidArgumentException("The function ".$name." in ".get_class($this)."  take only one argument.");
                }

                $realName = $this->getProprietyName($name);
                $this->$realName = $arguments[array_keys($arguments)[0]];

                return $this;
            }

            throw new \BadFunctionCallException("The function ".$name." doesn't exist in ".get_class($this));
        }
    }

    public function toArray($fields = [])
    {
        $vars = get_object_vars($this);
        $varsArray = [];

        foreach ($vars as $varName => $varValue) {
            if (null !== $varValue && (empty($fields) || in_array($varName, $fields))) {
                if ($varValue instanceof BaseModel) {
                    $varsArray[$varName] = $varValue->toArray();
                } else {
                    $varsArray[$varName] = $varValue;
                }
            }
        }

        return $varsArray;
    }

    private function getProprietyName($name)
    {
        $proprietyName = strtolower(substr($name, 3, 1)).substr($name, 4);

        return $proprietyName;
    }
}
