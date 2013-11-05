<?php

namespace Tritoq\Bundle\ManagerBoletoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tritoq\Bundle\ManagerBoletoBundle\Service\BoletoManager;

/**
 * Class DefaultController
 * @package Tritoq\Bundle\ManagerBoletoBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @param $id
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Route ("/boleto/{id}", name="tritoq_manager_boleto")
     */
    public function indexAction($id)
    {
        /** @var BoletoManager $service */
        $service = $this->container->get('tritoq.manager.boleto');

        $boleto = $service->getBoletoByHash($id);

        $now = new \DateTime('now');
        $date = $boleto->getDataVencimento();

        if ($now > $date) {
            throw new NotFoundHttpException('Boleto já passou da data de validade');
        }

        $response = new Response($boleto->getOutput());
        return $response;
    }
}
