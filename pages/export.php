<?php

/**
 * Admin page to export a CSV list of exchange rates for a given exchange/currency pair.
 */

$exchange = require_get("exchange");
$currency1 = require_get("currency1");
$currency2 = require_get("currency2");
$date = require_get("date");

$q = db()->prepare("SELECT * FROM ticker_historical WHERE exchange=? AND currency1=? AND currency2=? AND created_at_day=TO_DAYS(?)");
$q->execute(array($exchange, $currency1, $currency2, $date));

$result = array();
while ($row = $q->fetch()) {
  $result[] = $row;
}

$q = db()->prepare("SELECT * FROM ticker WHERE exchange=? AND currency1=? AND currency2=? AND created_at_day=TO_DAYS(?)");
$q->execute(array($exchange, $currency1, $currency2, $date));

while ($row = $q->fetch()) {
  $result[] = $row;
}

header('Content-Type: application/json');
echo json_encode($result);

