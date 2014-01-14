<?php
namespace Admin\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Manifest;
use Application\Form\Post as PostForm;
 
/**
 * Controlador que gerencia os posts
 * 
 * @category Admin
 * @package Controller
 * @author  Elton Minetto <eminetto@coderockr.com>
 */
class IndexController extends ActionController
{
    /**
     * Cria ou edita um post
     * @return void
     */
    public function saveAction()
    {
        $form = new PostForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = new Manifest;
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                $data['post_date'] = date('Y-m-d H:i:s');
                $post->setData($data);
                
                $saved =  $this->getTable('Application\Model\Manifest')->save($post);
                return $this->redirect()->toUrl('/');
            }
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {    
            $post = $this->getTable('Application\Model\Manifest')->get($id);
            $form->bind($post);
            $form->get('submit')->setAttribute('value', 'Edit');
        }
        return new ViewModel(
            array('form' => $form)
        );
    }
     
    /**
     * Exclui um post
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id == 0) {
            throw new \Exception("Código obrigatório");
        }
        
        $this->getTable('Application\Model\Manifest')->delete($id);
        return $this->redirect()->toUrl('/');
    }
 
}