<?php
/*
 * RatePAY php-library
 *
 * This document contains trade secret data which are the property of
 * RatePAY GmbH, Berlin, Germany. Information contained herein must not be used,
 * copied or disclosed in whole or part unless permitted in writing by RatePAY GmbH.
 * All rights reserved by RatePAY GmbH.
 *
 * Copyright (c) 2020 RatePAY GmbH / Berlin / Germany
 */

namespace RatePAY\Tests\Unit\Model\Request;

use PHPUnit\Framework\TestCase;
use RatePAY\Model\Request\CalculationRequest;
use RatePAY\ModelBuilder;

class CalculationRequestTest extends TestCase
{
    public function testInitializationSetsSubtype()
    {
        $request = new CalculationRequest();

        $this->assertTrue($request->isSubtypeRequired());
        $this->assertEquals(['calculation-by-rate', 'calculation-by-time'], $request->getAdmittedSubtypes());
    }

    public function testRuleSucceed()
    {
        $head = new ModelBuilder();

        $request = new CalculationRequest();
        $request->setHead($head->getModel());

        $this->assertTrue($request->rule());
    }

    public function testRuleFailed()
    {
        $head = new ModelBuilder();
        $head->setTransactionId('foo-1234567890');

        $request = new CalculationRequest();
        $request->setHead($head->getModel());

        $this->assertFalse($request->rule());
        $this->assertEquals('Calculation Request does not allow transaction id', $request->getErrorMsg());
    }
}
