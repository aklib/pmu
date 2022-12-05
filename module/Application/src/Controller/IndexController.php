<?php /** @noinspection PhpUnused */

declare(strict_types = 1);

namespace Application\Controller;

use Laminas\Http\Response;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractModuleController
{
    public function indexAction(): ViewModel
    {
        return new ViewModel();
    }

    public function blogAction(): ViewModel
    {
        return new ViewModel();
    }

    public function postAction(): Response|ViewModel
    {
        $postId = $this->getRequest()->getQuery('id', '');
        $file = dirname(__DIR__, 2) . '/view/section/post' . $postId;
        if (!file_exists($file)) {
            return $this->redirect()->toRoute('home', ['action' => 'blog']);
        }
        $viewModel = new ViewModel();
        $viewModel->setTemplate("section/post$postId/post");
        return $viewModel;
    }

    public function galleryAction(): ViewModel
    {
        return new ViewModel();
    }

    public function galleryItemAction(): Response|ViewModel
    {
        $itemId = $this->getRequest()->getQuery('id', '');
        $file = dirname(__DIR__, 2) . '/view/section/item' . $itemId;
        if (!file_exists($file)) {
            die('popal');
            return $this->redirect()->toRoute('home', ['action' => 'gallery']);
        }
        $viewModel = new ViewModel();
        $viewModel->setTemplate("section/item$itemId/item");
        return $viewModel;
    }

    public function servicesAction(): ViewModel
    {
        return new ViewModel();
    }

    public function mastersAction(): ViewModel
    {
        return new ViewModel();
    }

    public function pricesAction(): ViewModel
    {
        return new ViewModel();
    }

    public function contactAction(): ViewModel
    {
        return new ViewModel();
    }

}
