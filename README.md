tritoq-bundle-ManagerBoletoBundle
==================================

Bundle para gerenciamento de boletos usando o OpenBoleto

## Instalação


** Via Composer

```json

"require" : {
        "tritoq/managerboleto-bundle": "dev-master"
}

```

## Configuração


*** Registrando o bundle no `AppKernel`


```php

    $bundles = array(
        ...
        new Tritoq\Bundle\ManagerBoletoBundle\TritoqManagerBoletoBundle(),
        ...
    )

```
`app/config/config.yml`

*** Registrando o Bundle no Doctrine

 ```yaml

    doctrine:
            orm:
                entity_managers:
                        default:
                            mappings:
                                TritoqManagerBoletoBundle: ~

 ```

*** Setando as configuraçoes

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
        conta: 1203910139
        agencia: 203923-5
        carteira: 06
        #
        # Dados da Empresa Cedente
        #
        cedente: "Empresa"
        endereco: "Endereço 01"
        cidade: "Cidade"
        uf: "SC"
        cnpj: "04.544.191/0001-03"
```