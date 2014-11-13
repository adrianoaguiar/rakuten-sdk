rakuten-sdk
===========

Integração pedidos e produtos no marketplace http://www.rakuten.com.br


!Diagrama classes](http://yuml.me/1d337e2b "Diagrama classes")

## Criando produto simples
Criando um produto simples.
```php
use Rakuten\Dados\Produto\Produto;
use Rakuten\Dados\Produto\Categoria;
use Rakuten\Dados\Produto\Detalhes;
use Rakuten\Dados\Produto\Dimensoes;

// Categoria do produto
$categoria = new Categoria();
$categoria->setCodigo('X15');
$categoria->setNome('Nome Categoria');

// Informações base produto.
$produto = new Produto();
$produto->setNome('nome do produto');
$produto->setCodigo('código');
$produto->setStatus(true);
$produto->setDescricao('Descrição do Produto');
$produto->setEspecificacao('Especificações do Produto');
$produto->setLimitarQuantidade(10);
$produto->setVideo('http://www.youtube.com/watch?v=koyjj87QbXg');
$produto->setCategoria($categoria);
$produto->setMarca('Marca do produto');
$produto->setPrecoMinimo(16.00);
$produto->setImagem('imagem/teste.jpg');
$produto->setPrazoAdicional(1);

// Dimensões do produto
$dimensoes = new Dimensoes();
$dimensoes->setPeso(2);
$dimensoes->setAltura(1.20);
$dimensoes->setLargura(3.19);
$dimensoes->setProfundidade(5.36);

// Detalhe do produto
$detalhes = new Detalhes();
$detalhes->setCodigo('código');
$detalhes->setPreco(20.00);
$detalhes->setPrecoPromocional(16.00);
$detalhes->setEstoque(5);
$detalhes->setEstoqueMinimo(2);
$detalhes->setFreteGratis(true);
$detalhes->setDimensoes($dimensoes);
$detalhes->setSku(true);
$detalhes->setIsbm('2890765416780');
$detalhes->setEan13('2345278965129');
$detalhes->addImagem('imagem/teste1.jpg');
$detalhes->addImagem('imagem/teste2.jpg');
$detalhes->addImagem('imagem/teste3.jpg');
$detalhes->addImagem('imagem/teste4.jpg');
$detalhes->addImagem('imagem/teste5.jpg');
$detalhes->addImagem('imagem/teste6.jpg');

$produto->addSubProduto($detalhes);
```

## Criando produto com sub produto
Criando produto com variações (sub produto).
```php
use Rakuten\Dados\Produto\Produto;
use Rakuten\Dados\Produto\Categoria;
use Rakuten\Dados\Produto\SubProduto;
use Rakuten\Dados\Produto\Dimensoes;
use Rakuten\Dados\Produto\Variacao;

// categoria ...
// produto ...
// dimensoes ...

$variacao_vermelho = new Variacao();
$variacao_vermelho->setNome('Cor');
$variacao_vermelho->setValor('Vermelho');

// cria uma instancia do subproduto
$subproduto_vermelho = new SubProduto();

// mesmos dados do produto simples, incrementa apenas os seguintes dados.
$subproduto_vermelho->setTipo('Cor');
$subproduto_vermelho->addVariacao($variacao_vermelho);

$variacao_azul = new Variacao();
$variacao_azul->setNome('Cor');
$variacao_azul->setValor('Azul');

// mesmos dados do produto simples, incrementa apenas os seguintes dados.
$subproduto_azul->setTipo('Cor');
$subproduto_azul->addVariacao($variacao_azul);

// adiciona variações no produto.
$produto->addSubProduto($subproduto_vermelho);
$produto->addSubProduto($subproduto_azul);
```