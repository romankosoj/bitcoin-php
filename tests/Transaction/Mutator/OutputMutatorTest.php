<?php

namespace BitWasp\Bitcoin\Tests\Transaction\Mutator;

use BitWasp\Bitcoin\Script\Script;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Bitcoin\Transaction\Mutator\OutputMutator;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Buffertools\Buffer;

class OutputMutatorTest extends AbstractTestCase
{
    public function testModifiesOutput()
    {
        $value = 50;
        $newValue = 150;
        $script = new Script();
        $newScript = new Script(new Buffer('a'));
        $output = new TransactionOutput($value, $script);
        $modifier = new OutputMutator($output);
        $newOutput = $modifier
            ->value($newValue)
            ->script($newScript)
            ->done();

        $this->assertEquals($newValue, $newOutput->getValue());
        $this->assertEquals($newScript, $newOutput->getScript());
    }

    public function testSetsNull()
    {
        $value = 50;
        $script = new Script();
        $output = new TransactionOutput($value, $script);
        $modifier = new OutputMutator($output);
        $newOutput = $modifier
            ->null()
            ->done();

        $this->assertEquals('18446744073709551615', $newOutput->getValue());
        $this->assertEquals($script, $newOutput->getScript());
    }
}
