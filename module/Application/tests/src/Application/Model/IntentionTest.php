<?php
namespace Application\Model;
 
use Core\Test\ModelTestCase;
use Application\Model\Manifest;
use Application\Model\Intention;
use Zend\InputFilter\InputFilterInterface;
 
/**
 * @group Model
 */
class IntentionTest extends ModelTestCase
{
    public function testGetInputFilter()
    {
        $comment = new Intention();
        $if = $comment->getInputFilter();
 
        $this->assertInstanceOf("Zend\InputFilter\InputFilter", $if);
        return $if;
    }
 
    /**
     * @depends testGetInputFilter
     */
    public function testInputFilterValid($if)
    {
        $this->assertEquals(7, $if->count());
 
        $this->assertTrue($if->has('id'));
        $this->assertTrue($if->has('post_id'));
        $this->assertTrue($if->has('description'));
        $this->assertTrue($if->has('name'));
        $this->assertTrue($if->has('email'));
        $this->assertTrue($if->has('comment_date'));
    }
    
    /**
     * @expectedException Core\Model\EntityException
     * @expectedExceptionMessage Input inválido: email = 
     */
    public function testInputFilterInvalido()
    {
        $comment = new Intention();
        //email deve ser um e-mail válido
        $comment->email = 'email_invalido';
    }
 
    /**
     * Teste de inserção de um comment válido
     */
    public function testInsert()
    {
        $comment = $this->addComment();
 
        $saved = $this->getTable('Application\Model\Intention')->save($comment);
 
        $this->assertEquals(
            'Comentário importante alert("ok");', $saved->description
        );
        $this->assertEquals(1, $saved->id);
    }
 
    /**
     * @expectedException Zend\Db\Adapter\Exception\InvalidQueryException
     */
    public function testInsertInvalido()
    {
        $comment = new Intention();
        $comment->description = 'teste';
        $comment->post_id = 0;
 
        $saved = $this->getTable('Application\Model\Intention')->save($comment);
    }    
 
    public function testUpdate()
    {
        $tableGateway = $this->getTable('Application\Model\Intention');
        $comment = $this->addComment();
 
        $saved = $tableGateway->save($comment);
        $id = $saved->id;
 
        $this->assertEquals(1, $id);
 
        $comment = $tableGateway->get($id);
        $this->assertEquals('eminetto@coderockr.com', $comment->email);
 
        $comment->email = 'eminetto@gmail.com';
        $updated = $tableGateway->save($comment);
 
        $comment = $tableGateway->get($id);
        $this->assertEquals('eminetto@gmail.com', $comment->email);
 
    }
 
    /**
     * @expectedException Zend\Db\Adapter\Exception\InvalidQueryException
     * @expectedExceptionMessage Statement could not be executed
     */
    public function testUpdateInvalido()
    {
        $tableGateway = $this->getTable('Application\Model\Intention');
        $comment = $this->addComment();
 
        $saved = $tableGateway->save($comment);
        $id = $saved->id;
 
        $comment = $tableGateway->get($id);
        $comment->post_id = 10;
        $updated = $tableGateway->save($comment);
    }
 
    /**
     * @expectedException Core\Model\EntityException
     * @expectedExceptionMessage Could not find row 1
     */
    public function testDelete()
    {
        $tableGateway = $this->getTable('Application\Model\Intention');
        $comment = $this->addComment();
 
        $saved = $tableGateway->save($comment);
        $id = $saved->id;
 
        $deleted = $tableGateway->delete($id);
        $this->assertEquals(1, $deleted); //numero de linhas excluidas
 
        $comment = $tableGateway->get($id);
    }
 
    private function addPost()
    {
        $post = new Manifest();
        $post->title = 'Apple compra a Coderockr';
        $post->description = 'A Apple compra a <b>Coderockr</b><br> ';
        $post->post_date = date('Y-m-d H:i:s');
 
        $saved = $this->getTable('Application\Model\Manifest')->save($post);
 
        return $saved;
    }
 
    private function addComment() 
    {
        $post = $this->addPost();
        $comment = new Intention();
        $comment->post_id = $post->id;
        $comment->description = 'Comentário importante <script>alert("ok");</script> <br> ';
        $comment->name = 'Elton Minetto';
        $comment->email = 'eminetto@coderockr.com';
        $comment->comment_date = date('Y-m-d H:i:s');
 
        return $comment;
    }
}