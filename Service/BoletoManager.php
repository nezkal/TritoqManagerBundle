<?php
namespace Tritoq\Bundle\ManagerBoletoBundle\Service;

use Doctrine\ORM\EntityManager;
use OpenBoleto\Agente;
use OpenBoleto\BoletoAbstract;
use OpenBoleto\BoletoFactory;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Tritoq\Bundle\ManagerBoletoBundle\Entity\Boleto;

/**
 * Class BoletoManager
 * @package Tritoq\Bundle\ManagerBoletoBundle\Service
 */
class BoletoManager
{
    const BUNDLE = 'TritoqManagerBoletoBundle';

    /**
     * @var array
     */
    private $_map = array(
        1 => BoletoType::BANCO_DO_BRASIL,
        33 => BoletoType::BANCO_SANTANDER,
        70 => BoletoType::BANCO_DE_BRASILIA,
        90 => BoletoType::BANCO_UNICRED,
        237 => BoletoType::BANCO_BRADESCO,
        341 => BoletoType::BANCO_ITAU
    );

    /**
     * @var array
     */
    private $data = array();

    /**
     * @var array
     */
    private $configurations;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $configurations
     */
    public function setConfigurations($configurations)
    {
        $this->configurations = $configurations['boleto'];
    }

    /**
     * @return array
     */
    public function getConfigurations()
    {
        return $this->configurations;
    }

    /**
     * @param array $params
     * @return BoletoAbstract
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    private function factoryBoleto(array $params = array())
    {
        $keymap = $this->configurations['tipo'];

        if (!in_array($keymap, $this->_map))
            throw new InvalidArgumentException('Invalid keymap for Bank (' . $keymap . ')');

        return BoletoFactory::loadByBankId(array_keys($this->_map, $keymap), $params);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $hash
     * @return BoletoAbstract
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function getBoletoByHash($hash)
    {
        $data = null;
        //
        if (!array_key_exists($hash, $this->data)) {

            /** @var Boleto $obj */
            $obj = $this->entityManager->getRepository(self::BUNDLE . ':Boleto')->findOneByHash($hash);

            if (!$obj)
                throw new InvalidOptionsException('No hash for data: ' . $hash);

            $parameters = array();
            $parameters['value'] = $obj->getValue();
            $parameters['sequence'] = $obj->getSequencial();
            $parameters = array_merge($obj->getSacado(), $parameters);

            $boleto_obj = $this->createBoleto($parameters);
            $data = $boleto_obj;

        } else {
            $data = $this->data[$hash];
        }


        return $data;
    }

    /**
     * @param array $parameters
     * @return \OpenBoleto\BoletoAbstract
     */
    private function createBoleto(array $parameters)
    {
        $payer_name = $parameters['payer'];
        $payer_document = $parameters['payer_doc'];
        $payer_address = $parameters['payer_address'];

        $cedente_name = $this->configurations['cedente'];
        $cedente_document = $this->configurations['cnpj'];
        $cedente_address = $this->configurations['endereco'];
        $cedente_city = $this->configurations['cidade'];
        $cedente_uf = $this->configurations['uf'];

        $sacado = new Agente($payer_name, $payer_document, $payer_address);
        $cedente = new Agente($cedente_name, $cedente_document, $cedente_address, null, $cedente_city, $cedente_uf);

        $value = $parameters['value'];

        $days_expires = $this->configurations['dias_prazo'];
        $date_expires = new \DateTime('now');
        $date_expires->add(new \DateInterval('P' . $days_expires . 'D'));

        $configurations['cedente'] = $cedente;
        $configurations['sacado'] = $sacado;
        $configurations['dataVencimento'] = $date_expires;
        $configurations['sequencial'] = $parameters['sequence'];
        $configurations['valor'] = $value;
        $configurations = array_merge($this->getConfigurations(), $configurations);

        $boleto = $this->factoryBoleto($configurations);

        return $boleto;
    }


    /**
     * @param $parameters
     * @return \OpenBoleto\BoletoAbstract
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    public function add($parameters)
    {
        $requires = array("value", "sequence", "payer");

        if (isset($parameters['value']) and isset($parameters['payer']) and isset($parameters['sequence'])) {

            $value = $parameters['value'];
            $boleto_obj = $this->createBoleto($parameters);

            $boleto_entity = new Boleto();
            $boleto_entity->setValue($value);

            $boleto_entity->setSacado(array(
                'payer' => $boleto_obj->getSacado()->getNome(),
                'payer_doc' => $boleto_obj->getSacado()->getDocumento(),
                'payer_address' => $boleto_obj->getSacado()->getEndereco()
            ));

            $boleto_entity->setNossoNumero($boleto_obj->getNossoNumero());
            $boleto_entity->setDateValidate($boleto_obj->getDataVencimento());
            $boleto_entity->setSequencial($boleto_obj->getSequencial());
            $this->entityManager->persist($boleto_entity);
            $this->entityManager->flush();

            $this->data[$boleto_entity->getHash()] = $boleto_obj;

            return $boleto_obj;
        } else {
            throw new InvalidArgumentException('Invalid parameters, need: ' . implode(',', $requires));
        }
    }
} 