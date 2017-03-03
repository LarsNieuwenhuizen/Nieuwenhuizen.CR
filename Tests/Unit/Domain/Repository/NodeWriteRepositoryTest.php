<?php
namespace Nieuwenhuizen\CR\Tests\Unit\Domain\Repository;

use Neos\Flow\Tests\UnitTestCase;

class NodeWriteRepositoryTest extends UnitTestCase
{

    /**
     * @test
     */
    public function testIfGetFreeNodeNameReturnsAnNodeName()
    {
        $nodeWriteRepositoryMock = $this->getAccessibleMock('Nieuwenhuizen\CR\Domain\Repository\NodeWriteRepository', ['dummy'], [], '', false);
        $nodeMock = $this->getMock('Neos\ContentRepository\Domain\Model\Node', ['getNode'], [], '', false);

        $nodeMock->expects($this->once())->method('getNode');

        $this->assertEquals(
            'my-node-name',
            $nodeWriteRepositoryMock->getFreeNodeName('My node name', $nodeMock)
        );
    }

}