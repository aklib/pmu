<?php /** @noinspection ALL */
/** @noinspection PhpUnused */

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
        if (!$this->getRequest()->isPost()) {
            return new ViewModel();
        }
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function ajaxmailAction(): Response|ViewModel
    {
        if (!$this->getRequest()->isPost()) {
            $lang = $this->params('language');
            $url = $this->url()->fromRoute('home', ['action' => 'contact', 'language' => $lang]);
            return $this->redirect()->toUrl($url);
        }

        $un = $this->params()->fromPost('username');
        $em = $this->params()->fromPost('useremail');
        $su = $this->params()->fromPost('useresubject');
        $msg = $this->params()->fromPost('mesg');

        if (trim($un) !== '' && trim($msg) !== '' && trim($em) !== '' && trim($su) !== '') {
            if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
                $message = "Hi Anna..<p>" . $un . " has sent a query having subject " . $su . " and email id as " . $em . "</p><p>Query is : " . $msg . "</p>";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <support@barber.com>' . "\r\n";

                $header = [
                    'From'         => 'webmaster@example.com',
                    'Reply-To'     => 'webmaster@example.com',
                    'X-Mailer'     => 'PHP/' . phpversion(),
                    'Content-type' => 'text/html;charset=UTF-8'
                ];


                if (mail('alexej.kisselev@gmail.com', 'Message for Website', $message, $header)) {
                    $messageKey = 'mail.success';
                } else {
                    $messageKey = 'mail.error';
                }
            } else {
                $messageKey = 'mail.invalid.email';
            }
        } else {
            $messageKey = 'mail.invalid.data';
        }
        $viewModel = new ViewModel();
        $viewModel->setVariable('messageKey', $messageKey);
        $viewModel->setTerminal(true);
        return $viewModel;
    }
}
