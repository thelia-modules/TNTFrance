<?php
/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 16/06/15
 * Time: 14:02
 */

namespace TNTFrance\Event\Module;


use Thelia\Core\Event\ActionEvent;

class TNTFrancePrintExpeditionEvent extends ActionEvent
{
    /** @var  \TNTFrance\Model\TntOrderParcelResponse[] */
    protected $tntOrderParceResponses;

    public function __construct($tntOrderParceResponses = null)
    {
        $this->tntOrderParceResponses = $tntOrderParceResponses;
    }

    /**
     * @param \TNTFrance\Model\TntOrderParcelResponse[] $tntOrderParceResponses
     *
     * @return TNTFrancePrintExpeditionEvent
     */
    public function setTntOrderParceResponses($tntOrderParceResponses)
    {
        $this->tntOrderParceResponses = $tntOrderParceResponses;

        return $this;
    }

    /**
     * @return \TNTFrance\Model\TntOrderParcelResponse[]
     */
    public function getTntOrderParceResponses()
    {
        return $this->tntOrderParceResponses;
    }
}
