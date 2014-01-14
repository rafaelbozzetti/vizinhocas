<?php
namespace Application\Model;
 
use Core\Test\ModelTestCase;
use Application\Model\Manifest;
use Zend\InputFilter\InputFilterInterface;
 
/**
 * @group Model
 */
class ManifestTest extends ModelTestCase
{
    public function testGetInputFilter()
    {
        $manifest = new Manifest();
        $if = $manifest->getInputFilter();
        //testa se existem filtros
        $this->assertInstanceOf("Zend\InputFilter\InputFilter", $if);
        return $if;
    }
 
    /**
     * @depends testGetInputFilter
     */
    public function testInputFilterValid($if)
    {
        //testa os filtros
        $this->assertEquals(4, $if->count());
 
        $this->assertTrue($if->has('id'));
        $this->assertTrue($if->has('title'));
        $this->assertTrue($if->has('description'));
        $this->assertTrue($if->has('post_date'));
    }
    
    /**
     * @expectedException Core\Model\EntityException
     */
    public function testInputFilterInvalido()
    {
        //testa se os filtros estão funcionando
        $manifest = new Manifest();
        //title só pode ter 100 caracteres
        $manifest->title = 'Lorem Ipsum é simplesmente uma simulação de texto da indústria 
        tipográfica e de impressos. Lorem Ipsum é simplesmente uma simulação de texto 
        da indústria tipográfica e de impressos';
    }        
 
    /**
     * Teste de inserção de um manifesto válido
     */
    public function testInsert()
    {
        $manifest = $this->addManifest();
 
        $saved = $this->getTable('Application\Model\Manifest')->save($manifest);
 
        //testa o filtro de tags e espaços
        $this->assertEquals('TESTE', $saved->description);
        //testa o auto increment da chave primária
        $this->assertEquals(1, $saved->id);
    }
 
    /**
     * @expectedException Core\Model\EntityException
     * @expectedExceptionMessage Input inválido: description = 
     */
    public function testInsertInvalido()
    {
        $manifest = new Manifest();
        $manifest->title = 'teste';
        $manifest->description = '';
 
        $saved = $this->getTable('Application\Model\Manifest')->save($manifest);
    }    
 
    public function testUpdate()
    {
        $tableGateway = $this->getTable('Application\Model\Manifest');
        $manifest = $this->addManifest();
 
        $saved = $tableGateway->save($manifest);
        $id = $saved->id;
 
        $this->assertEquals(1, $id);
 
        $manifest = $tableGateway->get($id);
        $this->assertEquals('TESTE', $manifest->title);
 
        $manifest->title = 'TESTEaaa';
        $updated = $tableGateway->save($manifest);
 
        $manifest = $tableGateway->get($id);
        $this->assertEquals('TESTEaaa', $manifest->title);
    }
 
    /**
     * @expectedException Core\Model\EntityException
     * @expectedExceptionMessage Could not find row 1
     */
    public function testDelete()
    {
        $tableGateway = $this->getTable('Application\Model\Manifest');
        $manifest = $this->addManifest();
 
        $saved = $tableGateway->save($manifest);
        $id = $saved->id;
 
        $deleted = $tableGateway->delete($id);
        $this->assertEquals(1, $deleted); //numero de linhas excluidas
 
        $manifest = $tableGateway->get($id);
    }
 
    private function addManifest()
    {
        $manifest = new Manifest();
        $manifest->title = 'TESTE';
        $manifest->description = 'TESTE';
        $manifest->post_date = date('Y-m-d H:i:s');
 
        return $manifest;
    }
 
}
