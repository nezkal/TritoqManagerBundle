Tritoq\Bundle\ManagerBoletoBundle
==================================

Bundle para gerenciamento de boletos usando o OpenBoleto

## Instalação


**Via Composer**

```json

"require" : {
        "kriansa/openboleto": "dev-master",
        "tritoq/managerboleto-bundle": "dev-master"
}

```

```bash
php composer.phar update
```

## Configuração


**Registrando o bundle no `AppKernel.php`**


```php

    $bundles = array(
        ...
        new Tritoq\Bundle\ManagerBoletoBundle\TritoqManagerBoletoBundle(),
        ...
    )

```
`app/config/config.yml`

**Registrando o Bundle no Doctrine**

 ```yaml

    doctrine:
            orm:
                entity_managers:
                        default:
                            mappings:
                                TritoqManagerBoletoBundle: ~

 ```

**Setando as configuraçoes**

```yaml

#
#
#  Tipos de Boleto
#
#  bancodebrasilia
#  bancodobrasil
#  bradesco
#  itau
#  santander
#  unicred
#
#
    tritoq_manager_boleto:
        #
        # Infos boleto
        #
        tipo: bancodobrasil
        dias_prazo: 3
        #
        # Dados da conta
        #
        conta: 12039101
        agencia: 2039
        carteira: 18
        convenio: 1234
        #
        # Dados da Empresa Cedente
        #
        cedente: "Empresa"
        endereco: "Endereço 01"
        cidade: "Cidade"
        uf: "SC"
        cnpj: "04.544.191/0001-03"
```

## Configurando a Rota

`app/config/routing.yml`

```yaml

    TritoqManagerBoletoBundle:
        resource: "@TritoqManagerBoletoBundle/Resources/config/routing.yml"
        prefix:   /

```

**Atualizando o Banco de dados**
`app/console doctrine:schema:update --force`

## Usando o serviço


### Adicionando um novo boleto

```php

        /** @var BoletoManager $boleto */
        $boleto = $this->container->get('tritoq.manager.boleto');
        $boleto->add(array(
                'value' => 54.5,
                'payer' => 'Artur Magalhaes',
                'payer_doc' => '123.456.789-01',
                'payer_address' => 'Rua Fulano de tal',
                'sequence' => '11'  // Sequencial do boleto para nosso numero
            )
        );
```


### Buscando o Boleto

```php

    // Buscar o boleto através do doctrine

    $boleto = $em->getRepository('TritoqManagerBoletoBundle')->findOneById(1);

    // Pegando a rota para gerar o link do boleto
    $this->generateUrl('tritoq_manager_boleto', array('hash'=>'meuhash'));


```

** Nota **
> Para acessar o boleto a rota padrão é: `/boleto/{id}` - onde id é o hash gerado para o boleto