<?php

namespace AgnamStore\Tools;

/**
 * Description of Money
 *
 * @author Gory Alexandre
 */
class Money {

    /**
     *  Amount
     * @var float 
     */
    private $amount;

    /**
     * Format of amount True amount HT || False amount TTC
     * @var bool 
     */
    private $formatHT;

    /**
     * Taxe
     * @var float 
     */
    private $taxe;

    public function __construct($amount, $taxe, $formatHT = false) {
        $this->setAmount($amount);
        $this->setFormatHT($formatHT);
        $this->setTaxe($taxe);
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getFormatHT() {
        return $this->formatHT;
    }

    public function getTaxe() {
        return $this->taxe;
    }

    public function setAmount($amount) {
        if (!is_numeric($amount)) {
            throw new \Exception('The format of the parameter amount is not valid (numeric).');
        }
        $this->amount = (float) $amount;
        return $this;
    }

    public function setFormatHT($formatHT) {
        if (!is_bool($formatHT)) {
            throw new \Exception('The format of the parameter formatHT is not valid (numeric).');
        }
        $this->formatHT = (bool) $formatHT;
        return $this;
    }

    public function setTaxe($taxe) {
        if (!is_numeric($taxe)) {
            throw new \Exception('The format of the parameter taxe is not valid (numeric).');
        }
        $this->taxe = (float) $taxe ;
        return $this;
    }

    public function setTaxePercent($taxe) {
        if (!is_numeric($taxe)) {
            throw new \Exception('The format of the parameter taxe is not valid (numeric).');
        }
        $this->taxe = (float) ($taxe / 100);
        return $this;
    }

    public function getAmountHT() {
        if ($this->getFormatHT()) {
            $amount = $this->amount;
        } else {
            $amount = round($this->amount * ( 1.000 / (1.000 + $this->taxe)),2);
        }
        return $amount;
    }

    public function getAmountTTC() {
        if (!$this->getFormatHT()) {
            $amount = $this->amount;
        } else {
            $amount = round(($this->amount * 1.000 + $this->taxe), 2);
        }
        return $amount;
    }

    public function getAmountTaxe() {
        return $this->getAmountTTC() - $this->getAmountHT();
    }

    public function __toString() {
        return (string)$this->amount;
    }

    /**
     * Make the some of amount TTC of all moneys
     * @param array $moneys
     * @return float
     */
    public static function TotalTTC(Array $moneys) {
        $ttc = 0.000;
        foreach ($moneys as $money) {
            $ttc += $money->getAmountTTC();
        }
        return $ttc;
    }

    /**
     * Make the some of amount HT of all moneys
     * @param array $moneys
     * @return float
     */
    public static function TotalHT(Array $moneys) {
        $ht = 0.000;
        foreach ($moneys as $money) {
            $ht += $money->getAmountTTC();
        }
        return $ht;
    }

    /**
     * Make the some of amount taxe of all moneys
     * @param array $moneys
     * @return float
     */
    public static function TotalTaxe(Array $moneys) {
        $taxe = 0.000;
        foreach ($moneys as $money) {
            $taxe += $money->getAmountTaxe();
        }
        return $taxe;
    }

}
