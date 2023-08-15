<?php

function toDecimal($number, $decimals = 0): float {
    return (float) number_format($number, $decimals, ".", "");
}
